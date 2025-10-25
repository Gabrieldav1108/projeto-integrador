<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;

class TeacherStudentController extends Controller
{
    public function index()
    {
        // Buscar todos os users com role student
        $students = User::where('role', 'student')->with(['schoolClasses'])->get();
        return view('teacher.students.index', compact('students'));
    }

    public function show($userId)
    {
        // Buscar o user student com todas as informações
        $student = User::where('role', 'student')
            ->with([
                'schoolClasses', 
                'schoolClasses.teachers',
                'schoolClasses.subjects'
            ])->findOrFail($userId);

        $grades = $this->getStudentGrades($student->id);

        return view('teacher.studentInformation', compact('student', 'grades'));
    }

    private function getStudentGrades($studentId)
    {
        return [
            'first_trimester' => [
                ['name' => 'Prova 1', 'grade' => 8.5],
                ['name' => 'Prova 2', 'grade' => 7.8],
                ['name' => 'Prova 3', 'grade' => 9.2],
            ],
            'second_trimester' => [
                ['name' => 'Prova 1', 'grade' => 6.7],
                ['name' => 'Prova 2', 'grade' => 8.9],
                ['name' => 'Prova 3', 'grade' => 7.5],
            ],
            'third_trimester' => [
                ['name' => 'Prova 1', 'grade' => 9.0],
                ['name' => 'Prova 2', 'grade' => 8.2],
                ['name' => 'Prova 3', 'grade' => 9.5],
            ]
        ];
    }

    public function showByClass($classId)
    {
        $schoolClass = SchoolClass::with(['students'])->findOrFail($classId);
        return view('teacher.students.by-class', compact('schoolClass'));
    }
}