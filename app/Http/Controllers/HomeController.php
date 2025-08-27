<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class HomeController extends Controller
{
        public function index()
    {
        $schoolClasses = SchoolClass::orderBy('name')->paginate(12);
        
        return view('teacher.home', compact('schoolClasses'));
    }
}
