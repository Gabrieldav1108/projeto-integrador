<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\SchoolClass;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AssignmentSubmissionController extends Controller
{
    /**
     * MOSTRAR ENTREGAS DE UM TRABALHO
     */
    public function showSubmissions($classId, Assignment $assignment)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            abort(403, 'Acesso negado. Usuário não é um professor.');
        }

        // Verificar se o assignment pertence à turma
        if ($assignment->class_id != $classId) {
            abort(404, 'Trabalho não encontrado nesta turma.');
        }

        $schoolClass = SchoolClass::findOrFail($classId);

        // Buscar trabalho APENAS se for da matéria do professor
        if ($assignment->subject_id != $teacher->subject_id) {
            abort(403, 'Acesso negado. Este trabalho não é da sua matéria.');
        }

        // Carregar relações necessárias
        $assignment->load(['submissions.student.user', 'schoolClass.students.user']);

        // Estatísticas
        $totalStudents = $assignment->schoolClass->students->count();
        $submittedCount = $assignment->submissions->count();
        $gradedCount = $assignment->submissions->where('points', '!=', null)->count();

        return view('teacher.assignment-submissions', compact(
            'schoolClass', 
            'assignment',
            'totalStudents',
            'submittedCount',
            'gradedCount',
            'teacher'
        ));
    }

    /**
     * AVALIAR ENTREGA
     */
    public function gradeSubmission(Request $request, $classId, Assignment $assignment, AssignmentSubmission $submission)
    {
        // Verificar se pertence ao assignment e turma corretos
        if ($submission->assignment_id != $assignment->id || $assignment->class_id != $classId) {
            abort(404, 'Entrega não encontrada.');
        }

        $validated = $request->validate([
            'points' => 'required|numeric|min:0|max:' . $assignment->max_points,
            'feedback' => 'nullable|string|max:500',
        ]);

        try {
            $submission->update([
                'points' => $validated['points'],
                'feedback' => $validated['feedback'],
                'is_graded' => true,
                'grade_percentage' => ($validated['points'] / $assignment->max_points) * 100,
            ]);

            return redirect()
                ->route('assignment.submissions', ['classId' => $classId, 'assignment' => $assignment->id])
                ->with('success', 'Trabalho avaliado com sucesso!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erro ao avaliar trabalho: ' . $e->getMessage());
        }
    }

    /**
     * DOWNLOAD DA ENTREGA DO ALUNO
     */
    public function downloadSubmission($classId, Assignment $assignment, AssignmentSubmission $submission)
    {
        // Verificar se a submissão pertence ao assignment e class corretos
        if ($submission->assignment_id != $assignment->id || $assignment->class_id != $classId) {
            abort(404, 'Entrega não encontrada.');
        }

        // Verificar se o arquivo existe
        if (!$submission->file_path || !Storage::disk('public')->exists($submission->file_path)) {
            abort(404, 'Arquivo não encontrado.');
        }

        $filename = 'entrega_' . $submission->student->name . '_' . $assignment->title . '.' . pathinfo($submission->file_path, PATHINFO_EXTENSION);
        
        return Storage::disk('public')->download($submission->file_path, $filename);
    }

    /**
     * EXCLUIR ENTREGA (para casos de entrega incorreta)
     */
    public function destroy($classId, Assignment $assignment, AssignmentSubmission $submission)
    {
        try {
            // Verificar se pertence ao assignment e turma correta
            if ($submission->assignment_id != $assignment->id || $assignment->class_id != $classId) {
                abort(404, 'Entrega não encontrada.');
            }

            // Deletar arquivo se existir
            if ($submission->file_path && Storage::disk('public')->exists($submission->file_path)) {
                Storage::disk('public')->delete($submission->file_path);
            }

            $submission->delete();

            return redirect()
                ->route('assignment.submissions', ['classId' => $classId, 'assignment' => $assignment->id])
                ->with('success', 'Entrega excluída com sucesso!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Erro ao excluir entrega: ' . $e->getMessage());
        }
    }
}