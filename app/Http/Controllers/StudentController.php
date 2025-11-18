<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\ClassInformation;
use App\Models\Grade;
use App\Models\Student;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('schoolClass')->get();
        return view('admin.students.manage', compact('students'));
    }

    public function show($studentId)
    {
        $student = Student::with(['user', 'schoolClass'])->findOrFail($studentId);
        return view('teacher.students.show', compact('student'));
    }

    public function showSubject($subjectId)
    {
        $user = Auth::user();
        
        // Buscar a matéria
        $subject = Subject::findOrFail($subjectId);
        
        // Verificar se o aluno está matriculado na matéria
        $isStudentInSubject = $subject->schoolClasses()
            ->whereHas('students', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })->exists();

        if (!$isStudentInSubject) {
            abort(403, 'Você não está matriculado nesta matéria.');
        }

        // Buscar turmas do aluno
        $userClasses = $user->schoolClasses;

        // Buscar avisos APENAS desta matéria e das turmas do aluno
        $classIds = $user->schoolClasses->pluck('id');
        $classInformations = ClassInformation::whereIn('class_id', $classIds)
            ->where('subject_id', $subjectId) // ← FILTRAR POR MATÉRIA
            ->active()
            ->orderBy('created_at', 'desc')
            ->get();

        // Buscar professor principal (buscar professores que lecionam esta matéria nas turmas do aluno)
        $mainTeacher = Teacher::whereHas('schoolClasses', function($query) use ($classIds) {
                $query->whereIn('classes.id', $classIds);
            })
            ->whereHas('subject', function($query) use ($subjectId) {
                $query->where('subjects.id', $subjectId);
            })
            ->with('user')
            ->first();

        // Buscar trabalhos
        $assignments = Assignment::whereIn('class_id', $classIds)
            ->where('subject_id', $subjectId)
            ->with(['schoolClass', 'teacher.user'])
            ->active()
            ->orderBy('due_date', 'asc')
            ->get()
            ->map(function($assignment) use ($user) {
                $assignment->student_submission = $assignment->getStudentSubmission($user->id);
                $assignment->can_submit = !$assignment->is_expired && !$assignment->hasStudentSubmission($user->id);
                return $assignment;
            });

        return view('student.classInformation', compact(
            'subject',
            'userClasses',
            'classInformations',
            'mainTeacher',
            'assignments'
        ));
    }

    public function showGrades($subjectId = null)
    {
        $user = Auth::user();
        
        // Se não foi passada uma matéria específica, busca todas as matérias do aluno
        if ($subjectId) {
            // Buscar notas de uma matéria específica
            $subject = Subject::with(['teachers', 'schoolClasses.students'])->findOrFail($subjectId);
            
            // Verificar se o aluno está matriculado nesta matéria
            $isStudentInSubject = $subject->schoolClasses()
                ->whereHas('students', function($query) use ($user) {
                    $query->where('users.id', $user->id);
                })->exists();

            if (!$isStudentInSubject) {
                abort(403, 'Você não está matriculado nesta matéria.');
            }

            // Buscar as notas do aluno nesta matéria
            $grades = Grade::where('student_id', $user->id)
                ->where('subject_id', $subjectId)
                ->get()
                ->groupBy('trimester');

            $subjects = collect([$subject]);
        } else {
            // Buscar todas as matérias do aluno com suas notas
            $subjects = Subject::whereHas('schoolClasses.students', function($query) use ($user) {
                $query->where('users.id', $user->id);
            })->with(['teachers'])->get();

            $grades = \App\Models\Grade::where('student_id', $user->id)
                ->get()
                ->groupBy(['subject_id', 'trimester']);
        }

        return view('student.grades', compact('subjects', 'grades', 'subjectId'));
    }

    public function create()
    {
        $schoolClasses = SchoolClass::all();
        return view('admin.students.create', compact('schoolClasses'));
    }
    
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users', // Corrigido para 'users'
            'age' => 'required|integer|min:1|max:25',
            'password' => 'required|string|min:6|confirmed',
            'class_id' => 'required|exists:classes,id',
        ]);

        DB::transaction(function () use ($validatedData) {
            // 1. Criar usuário para login - SEM class_id na tabela users
            $user = User::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'role' => 'student',
            ]);

            $user->schoolClasses()->attach($validatedData['class_id']);

            Student::create([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'age' => $validatedData['age'],
                'password' => Hash::make($validatedData['password']),
                'class_id' => $validatedData['class_id'],
                'user_id' => $user->id, 
            ]);
        });

        return redirect()->route('admin.students.index')->with('success', 'Estudante criado e matriculado na turma com sucesso!');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $schoolClasses = SchoolClass::all();
        
        // Buscar o usuário correspondente
        $user = User::where('email', $student->email)->first();
        
        return view('admin.students.edit', compact('student', 'schoolClasses', 'user'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:students,email,' . $student->id . '|unique:users,email,' . $student->user_id,
            'age' => 'required|integer|min:1|max:25',
            'password' => 'nullable|string|min:6',
            'class_id' => 'required|exists:classes,id',
        ]);

        DB::transaction(function () use ($student, $validatedData) {
            // 1. Atualizar estudante
            $student->update([
                'name' => $validatedData['name'],
                'email' => $validatedData['email'],
                'age' => $validatedData['age'],
                'class_id' => $validatedData['class_id'],
                'password' => !empty($validatedData['password']) 
                    ? Hash::make($validatedData['password']) 
                    : $student->password,
            ]);

            // 2. Atualizar usuário correspondente
            $user = User::find($student->user_id);
            if ($user) {
                // Atualizar matrícula na tabela pivô
                $user->schoolClasses()->sync([$validatedData['class_id']]);
                
                // Atualizar dados do usuário
                $user->update([
                    'name' => $validatedData['name'],
                    'email' => $validatedData['email'],
                    'password' => !empty($validatedData['password']) 
                        ? Hash::make($validatedData['password']) 
                        : $user->password,
                ]);
            }
        });

        return redirect()->route('admin.students.index')->with('success', 'Estudante atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        
        DB::transaction(function () use ($student) {
            // Encontrar e deletar o usuário pelo user_id (mais confiável)
            $user = User::find($student->user_id);
            if ($user) {
                // Remover matrículas antes de deletar
                $user->schoolClasses()->detach();
                $user->delete();
            }
            
            $student->delete();
        });

        return redirect()->route('admin.students.index')->with('success', 'Estudante deletado com sucesso!');
    }

}