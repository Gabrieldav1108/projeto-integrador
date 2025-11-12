<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassInformation;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Container\Attributes\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage as FacadesStorage;

class ClassInformationController extends Controller
{
    public function index($classId)
    {
        $schoolClass = SchoolClass::with(['students'])->findOrFail($classId);
        
        $informations = ClassInformation::where('class_id', $classId)
            ->active() 
            ->latest()
            ->get();
        
        // Agora usamos $schoolClass->students diretamente (que são users)
        return view('teacher.class', compact('schoolClass', 'informations'));
    }

    public function create($classId)
    {
        $schoolClass = SchoolClass::findOrFail($classId);
        
        $currentInformations = ClassInformation::where('class_id', $classId)
            ->active() 
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('teacher.addClassInformation', compact('schoolClass', 'currentInformations'));
    }

    public function store(Request $request, $classId)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
        ]);

        try {
            $user = Auth::user();
            
            if (!$user) {
                throw new \Exception('Usuário não autenticado.');
            }

            $teacher = Teacher::where('user_id', $user->getAuthIdentifier())->first();

            if (!$teacher) {
                throw new \Exception('Professor não encontrado. Faça login como professor.');
            }

            if (!$teacher->getKey()) {
                throw new \Exception('ID do professor não encontrado.');
            }

            if (!$teacher->subject_id) {
                throw new \Exception('Você não tem uma matéria vinculada. Contate o administrador.');
            }

            $schoolClass = SchoolClass::with('teachers')->findOrFail($classId);
            
            $isTeacherInClass = $schoolClass->teachers->contains(function ($classTeacher) use ($teacher) {
                return $classTeacher->getKey() === $teacher->getKey();
            });

            if (!$isTeacherInClass) {
                throw new \Exception('Você não tem acesso a esta turma.');
            }

            ClassInformation::create([
                'class_id' => $classId,
                'subject_id' => $teacher->subject_id,
                'content' => $validated['content'],
                'date' => $validated['date'],
                'time' => $validated['time'],
            ]);

            return redirect()
                ->route('teacher.class.informations', $classId)
                ->with('success', 'Aviso adicionado com sucesso!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erro ao adicionar aviso: ' . $e->getMessage());
        }
    }

    public function edit($classId, $id)
    {
        $schoolClass = SchoolClass::findOrFail($classId);
        $information = ClassInformation::where('class_id', $classId)
            ->findOrFail($id);
        
        $currentInformations = ClassInformation::where('class_id', $classId)
            ->active() 
            ->orderBy('created_at', 'desc')
            ->get();
            
        return view('teacher.editClassInformation', compact('schoolClass', 'information', 'currentInformations'));
    }

    public function update(Request $request, $classId, $informationId)
    {
        $validated = $request->validate([
            'content' => 'required|string|max:1000',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
        ]);

        try {
            $information = ClassInformation::where('class_id', $classId)
                ->findOrFail($informationId);
            
            $information->update($validated);

            return redirect()
                ->route('teacher.class.informations', $classId)
                ->with('success', 'Aviso atualizado com sucesso!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erro ao atualizar aviso. Tente novamente.');
        }
    }

    public function destroy($classId, $id)
    {
        try {
            $information = ClassInformation::where('class_id', $classId)
                ->findOrFail($id);
            
            $information->delete();

            return redirect()
                ->route('teacher.class.informations', $classId)
                ->with('success', 'Aviso excluído com sucesso!');

        } catch (\Exception $e) {
            return back()
                ->with('error', 'Erro ao excluir aviso. Tente novamente.');
        }
    }

    public function showAssignments($classId)
    {
        $schoolClass = SchoolClass::with(['students'])->findOrFail($classId);
        
        $assignments = Assignment::where('class_id', $classId)
            ->with(['submissions.student', 'teacher.user'])
            ->active()
            ->latest()
            ->get();

        return view('teacher.assignment-submissions', compact('schoolClass', 'assignments'));
    }

    /**
     * CRIAR NOVO TRABALHO
     */
    public function createAssignment($classId)
    {
        $schoolClass = SchoolClass::findOrFail($classId);
        $teacher = Teacher::where('user_id', Auth::id())->firstOrFail();
        
        $currentAssignments = Assignment::where('class_id', $classId)
            ->active()
            ->orderBy('due_date', 'asc')
            ->get();

        return view('teacher.create-assignment', compact('schoolClass', 'currentAssignments', 'teacher'));
    }

    /**
     * SALVAR NOVO TRABALHO
     */
    public function storeAssignment(Request $request, $classId)
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

            return redirect()
                ->route('teacher.class.assignments', $classId)
                ->with('success', 'Trabalho criado com sucesso!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erro ao criar trabalho: ' . $e->getMessage());
        }
    }

    /**
     * MOSTRAR ENTREGAS DE UM TRABALHO
     */
    public function showSubmissions($classId, $assignmentId)
    {
        $schoolClass = SchoolClass::findOrFail($classId);
        $assignment = Assignment::with(['submissions.student', 'schoolClass.students'])
            ->where('class_id', $classId)
            ->findOrFail($assignmentId);

        // Estatísticas
        $totalStudents = $assignment->schoolClass->students->count();
        $submittedCount = $assignment->submissions->count();
        $gradedCount = $assignment->submissions->where('points', '!=', null)->count();

        return view('teacher.assignment-submissions', compact(
            'schoolClass', 
            'assignment',
            'totalStudents',
            'submittedCount',
            'gradedCount'
        ));
    }

    /**
     * AVALIAR ENTREGA
     */
    public function gradeSubmission(Request $request, $classId, $assignmentId, $submissionId)
    {
        $validated = $request->validate([
            'points' => 'required|numeric|min:0|max:1000',
            'feedback' => 'nullable|string|max:500',
        ]);

        try {
            $submission = AssignmentSubmission::where('assignment_id', $assignmentId)
                ->findOrFail($submissionId);

            $submission->update([
                'points' => $validated['points'],
                'feedback' => $validated['feedback'],
            ]);

            return redirect()
                ->route('teacher.class.assignment.submissions', ['classId' => $classId, 'assignmentId' => $assignmentId])
                ->with('success', 'Trabalho avaliado com sucesso!');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Erro ao avaliar trabalho: ' . $e->getMessage());
        }
    }

    /**
     * DOWNLOAD DE ARQUIVO ENTREGUE
     */
    public function downloadSubmission($classId, $assignmentId, $submissionId)
    {
        $submission = AssignmentSubmission::where('assignment_id', $assignmentId)
            ->findOrFail($submissionId);

        if (!$submission->file_path || !FacadesStorage::exists($submission->file_path)) {
            abort(404, 'Arquivo não encontrado.');
        }

        return FacadesStorage::download($submission->file_path);
    }
}