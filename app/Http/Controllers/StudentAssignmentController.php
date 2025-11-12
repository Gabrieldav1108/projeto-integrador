<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentAssignmentController extends Controller
{
    /**
     * MOSTRAR TRABALHOS DISPONÍVEIS PARA O ALUNO
     */
    public function index()
    {
        $user = Auth::user();
        
        // Buscar todas as turmas do aluno
        $userClasses = $user->schoolClasses;
        
        // Buscar trabalhos das turmas do aluno
        $assignments = Assignment::whereIn('class_id', $userClasses->pluck('id'))
            ->with(['schoolClass', 'subject', 'teacher.user'])
            ->notExpired()
            ->active()
            ->orderBy('due_date', 'asc')
            ->get()
            ->map(function($assignment) use ($user) {
                $assignment->student_submission = $assignment->getStudentSubmission($user->id);
                // CORREÇÃO: usar is_expired em vez de isExpired()
                $assignment->can_submit = !$assignment->is_expired && !$assignment->hasStudentSubmission($user->id);
                return $assignment;
            });

        return view('student.assignments', compact('assignments', 'userClasses'));
    }

    /**
     * MOSTRAR TRABALHOS DE UMA MATÉRIA ESPECÍFICA
     */
    public function showSubjectAssignments($subjectId)
    {
        $user = Auth::user();
        $subject = Subject::with(['schoolClasses.students'])->findOrFail($subjectId);

        // Verificar se o aluno está matriculado na matéria
        $isStudentInSubject = $subject->schoolClasses()
            ->whereHas('students', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })->exists();

        if (!$isStudentInSubject) {
            abort(403, 'Você não está matriculado nesta matéria.');
        }

        // Buscar trabalhos da matéria
        $classIds = $subject->schoolClasses->pluck('id');
        $assignments = Assignment::whereIn('class_id', $classIds)
            ->where('subject_id', $subjectId)
            ->with(['schoolClass', 'teacher.user'])
            ->notExpired()
            ->active()
            ->orderBy('due_date', 'asc')
            ->get()
            ->map(function($assignment) use ($user) {
                $assignment->student_submission = $assignment->getStudentSubmission($user->id);
                // CORREÇÃO: usar is_expired em vez de isExpired()
                $assignment->can_submit = !$assignment->is_expired && !$assignment->hasStudentSubmission($user->id);
                return $assignment;
            });

        return view('student.subject-assignments', compact('assignments', 'subject'));
    }

    /**
     * MOSTRAR DETALHES DE UM TRABALHO
     */
    public function show($assignmentId)
    {
        $user = Auth::user();
        
        $assignment = Assignment::with(['schoolClass', 'subject', 'teacher.user'])
            ->findOrFail($assignmentId);

        // Verificar se o aluno está na turma do trabalho
        $isStudentInClass = $assignment->schoolClass->students->contains('id', $user->id);
        if (!$isStudentInClass) {
            abort(403, 'Você não tem acesso a este trabalho.');
        }

        $studentSubmission = $assignment->getStudentSubmission($user->id);
        // CORREÇÃO: usar is_expired em vez de isExpired()
        $canSubmit = !$assignment->is_expired && !$studentSubmission;

        return view('student.assignments.assignment-show', compact('assignment', 'studentSubmission', 'canSubmit'));
    }

    /**
     * MOSTRAR FORMULÁRIO DE ENTREGA
     */
    public function createSubmission($assignmentId)
    {
        $user = Auth::user();
        
        $assignment = Assignment::with(['schoolClass'])->findOrFail($assignmentId);

        // Verificar se o aluno pode entregar
        $isStudentInClass = $assignment->schoolClass->students->contains('id', $user->id);
        $hasSubmission = $assignment->hasStudentSubmission($user->id);
        // CORREÇÃO: usar is_expired em vez de isExpired()
        $isExpired = $assignment->is_expired;

        if (!$isStudentInClass) {
            abort(403, 'Você não tem acesso a este trabalho.');
        }

        if ($hasSubmission) {
            return redirect()->route('student.assignment.show', $assignmentId)
                ->with('info', 'Você já entregou este trabalho.');
        }

        if ($isExpired) {
            return redirect()->route('student.assignment.show', $assignmentId)
                ->with('error', 'O prazo para entrega deste trabalho expirou.');
        }

        return view('student.assignments.assignment-submit', compact('assignment'));
    }

    /**
     * PROCESSAR ENTREGA DO TRABALHO
     */
    public function storeSubmission(Request $request, $assignmentId)
    {
        $user = Auth::user();
        $assignment = Assignment::findOrFail($assignmentId);

        // Validar se pode entregar
        if ($assignment->hasStudentSubmission($user->id)) {
            return back()->with('error', 'Você já entregou este trabalho.');
        }

        // CORREÇÃO: usar is_expired em vez de isExpired()
        if ($assignment->is_expired) {
            return back()->with('error', 'O prazo para entrega expirou.');
        }

        $validated = $request->validate([
            'comments' => 'nullable|string|max:1000',
            'assignment_file' => 'required|file|max:10240|mimes:pdf,doc,docx,txt,zip,rar,jpg,jpeg,png',
        ]);

        try {
            // Fazer upload do arquivo
            $filePath = null;
            if ($request->hasFile('assignment_file')) {
                $file = $request->file('assignment_file');
                $fileName = 'assignment_' . $assignment->id . '_student_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $filePath = $file->storeAs('assignments', $fileName, 'public');
            }

            // Criar a entrega
            AssignmentSubmission::create([
                'assignment_id' => $assignment->id,
                'student_id' => $user->id,
                'file_path' => $filePath,
                'comments' => $validated['comments'],
                'submitted_at' => now(),
            ]);

            return redirect()->route('student.assignment.show', $assignmentId)
                ->with('success', 'Trabalho entregue com sucesso!');

        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao entregar trabalho: ' . $e->getMessage());
        }
    }

    /**
     * MOSTRAR ENTREGAS DO ALUNO
     */
    public function mySubmissions()
    {
        $user = Auth::user();
        
        $submissions = AssignmentSubmission::where('student_id', $user->id)
            ->with(['assignment.schoolClass', 'assignment.subject', 'assignment.teacher.user'])
            ->orderBy('submitted_at', 'desc')
            ->get();

        return view('student.my-submissions', compact('submissions'));
    }
}