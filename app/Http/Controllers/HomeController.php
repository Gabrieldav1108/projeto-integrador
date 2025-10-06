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
        
        // Remover o with('teachers') - não precisamos mais
        $subjects = Subject::whereHas('schoolClasses.students', function($query) use ($user) {
            $query->where('users.id', $user->id);
        })->get();

        return view('student.home', compact('subjects'));
    }

    public function indexTeacher()
    {
        return view('teacher.home');
    }
}