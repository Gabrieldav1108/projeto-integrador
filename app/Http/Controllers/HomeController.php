<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Página inicial do Admin
     */
    public function indexAdmin()
    {
        return view('admin.home');
    }

    /**
     * Página inicial do Teacher (corrigido o nome)
     */
    public function indexTeacher() // Ou mude para indexTeacher se preferir
    {
        $schoolClasses = SchoolClass::paginate(8);
        return view('teacher.home', compact('schoolClasses'));
    }

    /**
     * Página inicial do Student (se necessário)
     */
    public function indexStudent()
    {
        return view('student.home');
    }
}