<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;

class HomeController extends Controller
{
    /**
     * Redireciona para a home baseada no role
     */
    public function redirectToRoleBasedHome()
    {
        /** @var User $user */
        $user = Auth::user();
        
        if ($user->role === 'admin') {
            return redirect()->route('admin.home');
        } elseif ($user->role === 'teacher') {
            return redirect()->route('teacher.home');
        } elseif ($user->role === 'student') {
            return redirect()->route('student.home');
        }
        
        return redirect('/login');
    }

    public function indexAdmin()
    {
        return view('admin.home');
    }

    public function indexStudent()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $subjects = Subject::whereHas('schoolClasses.students', function($query) use ($user) {
            $query->where('users.id', $user->id);
        })->with(['classInformations' => function($query) {
            $query->active()->latest();
        }])->get();

        return view('student.home', compact('subjects'));
    }

    public function showSubjectClasses($subjectId)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        $subject = Subject::with(['schoolClasses' => function($query) use ($user) {
            $query->whereHas('students', function($q) use ($user) {
                $q->where('users.id', $user->id);
            })->with(['classInformations' => function($q) {
                $q->active()->latest();
            }]);
        }])->findOrFail($subjectId);

        return view('student.subject-classes', compact('subject'));
    }

    public function indexTeacher()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        
        // Buscar o professor pelo user_id
        $teacher = \App\Models\Teacher::where('user_id', $user->id)->first();
        
        if ($teacher) {
                $schoolClasses = $teacher->schoolClasses()->withCount('students')->get();
                
                logger('Professor: ' . $teacher->name);
                logger('Turmas encontradas: ' . $schoolClasses->count());
                foreach($schoolClasses as $class) {
                    logger('Turma: ' . $class->name . ' - Alunos: ' . $class->students_count);
                }
            } else {
            $schoolClasses = collect();
            logger('Professor não encontrado para user_id: ' . $user->id);
        }

        return view('teacher.home', compact('schoolClasses'));
    }
}