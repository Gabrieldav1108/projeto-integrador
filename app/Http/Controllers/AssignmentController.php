<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AssignmentController extends Controller
{
    public function create($classId)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();
        $schoolClass = SchoolClass::findOrFail($classId);

        // Buscar trabalhos APENAS da matéria do professor atual
        $currentAssignments = Assignment::where('class_id', $classId)
            ->where('subject_id', $teacher->subject_id) // ← FILTRAR PELA MATÉRIA DO PROFESSOR
            ->active()
            ->orderBy('due_date', 'asc')
            ->get();

        // Buscar matérias da turma (para o select, se necessário)
        $subjects = $schoolClass->subjects;

        return view('teacher.assignments.create', compact(
            'schoolClass', 
            'currentAssignments', 
            'teacher', 
            'subjects'
        ));
    }

    /**
     * SALVAR NOVO TRABALHO
     */
    public function store(Request $request, $classId)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'due_date' => 'required|date|after_or_equal:today',
            'due_time' => 'nullable|date_format:H:i',
            'max_points' => 'required|numeric|min:0|max:1000',
        ]);

        try {
            $user = Auth::user();
            $teacher = Teacher::where('user_id', $user->id)->firstOrFail();
            $schoolClass = SchoolClass::findOrFail($classId);

            // Verificar se o professor tem acesso à turma
            $isTeacherInClass = $schoolClass->teachers->contains('id', $teacher->id);
            if (!$isTeacherInClass) {
                throw new \Exception('Você não tem acesso a esta turma.');
            }

            Assignment::create([
                'class_id' => $classId,
                'subject_id' => $teacher->subject_id,
                'teacher_id' => $teacher->id,
                'title' => $validated['title'],
                'description' => $validated['description'],
                'due_date' => $validated['due_date'],
                'due_time' => $validated['due_time'],
                'max_points' => $validated['max_points'],
            ]);

            logger('Trabalho criado com sucesso! Matéria: ' . $teacher->subject_id);

            return redirect()
                ->route('teacher.class.informations', $classId)
                ->with('success', 'Trabalho criado com sucesso!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erro ao criar trabalho: ' . $e->getMessage());
        }
    }


    /**
     * EDITAR TRABALHO - IGUAL AOS AVISOS
     */
    public function edit($classId, $assignment)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->firstOrFail();
        $schoolClass = SchoolClass::findOrFail($classId);

        $assignment = Assignment::where('class_id', $classId)
            ->where('subject_id', $teacher->subject_id)
            ->findOrFail($assignment);

        return view('teacher.assignments.edit', compact(
            'schoolClass', 
            'assignment',
            'teacher'
        ));
    }

    /**
     * ATUALIZAR TRABALHO - IGUAL AOS AVISOS
     */
    public function update(Request $request, $classId, $assignment)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'due_date' => 'required|date',
            'due_time' => 'nullable|date_format:H:i',
            'max_points' => 'required|numeric|min:0|max:1000',
        ]);

        try {
            $user = Auth::user();
            $teacher = Teacher::where('user_id', $user->id)->firstOrFail();
            
            $assignment = Assignment::where('class_id', $classId)
                ->where('subject_id', $teacher->subject_id)
                ->findOrFail($assignment);

            $assignment->update($validated);

            return redirect()
                ->route('teacher.class.informations', $classId)
                ->with('success', 'Trabalho atualizado com sucesso!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erro ao atualizar trabalho: ' . $e->getMessage());
        }
    }

    /**
     * EXCLUIR TRABALHO - 
     */
    public function destroy($classId, Assignment $assignment)
    {
        try {
            // Bloqueia tentativa de deletar trabalho de outra turma
            if ($assignment->class_id != $classId) {
                return back()->with('error', 'Trabalho não pertence a esta turma.');
            }

            // Exclui todas as entregas primeiro
            if ($assignment->submissions()->count() > 0) {
                $assignment->submissions()->delete(); // Exclui todas as submissions
            }

            $assignment->delete();

            return redirect()
                ->route('teacher.class.informations', $classId)
                ->with('success', 'Trabalho excluído com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao excluir: ' . $e->getMessage());
        }
    }
}