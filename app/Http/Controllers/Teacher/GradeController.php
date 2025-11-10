<?php
// app/Http/Controllers/Teacher/GradeController.php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function create($studentId)
    {
        $student = User::where('role', 'student')->findOrFail($studentId);
        $teacher = Auth::user();
        
        // Verificar se o professor tem matéria atribuída
        if (!$this->teacherHasSubject($teacher)) {
            return redirect()->route('teacher.students.show', $studentId)
                ->with('error', 'Você não está atribuído a nenhuma matéria.');
        }
        
        $subject = $teacher->main_subject;
        $subjects = $teacher->subjects_collection;

        return view('teacher.grades.create', compact('student', 'subjects', 'subject'));
    }

    public function store(Request $request, $studentId)
    {
        $teacher = Auth::user();
        
        // Verificar se o professor tem matéria atribuída
        if (!$this->teacherHasSubject($teacher)) {
            return redirect()->route('teacher.students.show', $studentId)
                ->with('error', 'Você não está atribuído a nenhuma matéria.');
        }

        $teacherSubjectId = $teacher->main_subject->id;

        $validated = $request->validate([
            'subject_id' => [
                'required', 
                'exists:subjects,id',
                function ($attribute, $value, $fail) use ($teacherSubjectId) {
                    if ($value != $teacherSubjectId) {
                        $fail('Você só pode atribuir notas para sua própria matéria.');
                    }
                }
            ],
            'trimester' => 'required|in:first_trimester,second_trimester,third_trimester',
            'assessment_name' => 'required|string|max:100',
            'grade' => 'required|numeric|min:0|max:10',
            'assessment_date' => 'nullable|date'
        ]);

        $validated['student_id'] = $studentId;

        Grade::create($validated);

        return redirect()->route('teacher.students.show', $studentId)
            ->with('success', 'Nota adicionada com sucesso!');
    }

    public function edit($studentId, $gradeId)
    {
        $student = User::where('role', 'student')->findOrFail($studentId);
        $grade = Grade::where('student_id', $studentId)->findOrFail($gradeId);
        
        // Verificar se o professor tem permissão para editar esta nota
        $teacher = Auth::user();
        
        if (!$this->teacherHasSubject($teacher) || $grade->subject_id != $teacher->main_subject->id) {
            abort(403, 'Você não tem permissão para editar esta nota.');
        }
        
        $subject = $teacher->main_subject;
        $subjects = $teacher->subjects_collection;

        return view('teacher.grades.edit', compact('student', 'grade', 'subjects', 'subject'));
    }

    public function update(Request $request, $studentId, $gradeId)
    {
        $grade = Grade::where('student_id', $studentId)->findOrFail($gradeId);
        $teacher = Auth::user();

        // Verificar permissão antes de atualizar
        if (!$this->teacherHasSubject($teacher) || $grade->subject_id != $teacher->main_subject->id) {
            abort(403, 'Você não tem permissão para editar esta nota.');
        }

        $teacherSubjectId = $teacher->main_subject->id;

        $validated = $request->validate([
            'subject_id' => [
                'required', 
                'exists:subjects,id',
                function ($attribute, $value, $fail) use ($teacherSubjectId) {
                    if ($value != $teacherSubjectId) {
                        $fail('Você só pode atribuir notas para sua própria matéria.');
                    }
                }
            ],
            'trimester' => 'required|in:first_trimester,second_trimester,third_trimester',
            'assessment_name' => 'required|string|max:100',
            'grade' => 'required|numeric|min:0|max:10',
            'assessment_date' => 'nullable|date'
        ]);

        $grade->update($validated);

        return redirect()->route('teacher.students.show', $studentId)
            ->with('success', 'Nota atualizada com sucesso!');
    }

    public function destroy($studentId, $gradeId)
    {
        $grade = Grade::where('student_id', $studentId)->findOrFail($gradeId);
        
        // Verificar permissão antes de deletar
        $teacher = Auth::user();
        
        if (!$this->teacherHasSubject($teacher) || $grade->subject_id != $teacher->main_subject->id) {
            abort(403, 'Você não tem permissão para excluir esta nota.');
        }
        
        $grade->delete();

        return redirect()->route('teacher.students.show', $studentId)
            ->with('success', 'Nota removida com sucesso!');
    }

    /**
     * Método auxiliar para verificar se o professor tem matéria
     */
    private function teacherHasSubject($teacher): bool
    {
        return $teacher->isTeacher() && 
               $teacher->teacherProfile && 
               $teacher->teacherProfile->subject;
    }
}