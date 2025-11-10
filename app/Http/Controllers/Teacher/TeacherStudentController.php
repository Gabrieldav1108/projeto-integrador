<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
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

        // Se não tiver campo age, usar um valor padrão
        if (!isset($student->age)) {
            $student->age = 15; // ou qualquer lógica para calcular idade
        }

        $grades = $this->getStudentGrades($student->id);

        return view('teacher.studentInformation', compact('student', 'grades'));
    }

    // No método show do TeacherStudentController
    private function getStudentGrades($studentId)
    {
        $grades = Grade::where('student_id', $studentId)
            ->with('subject')
            ->get()
            ->groupBy('trimester');

        return [
            'first_trimester' => $grades->get('first_trimester', collect())->map(function($grade) {
                return [
                    'id' => $grade->id, // ← Adicionar o ID
                    'name' => $grade->assessment_name,
                    'grade' => $grade->grade,
                    'weight' => $grade->weight,
                    'subject' => $grade->subject->name
                ];
            })->toArray(),
            'second_trimester' => $grades->get('second_trimester', collect())->map(function($grade) {
                return [
                    'id' => $grade->id, // ← Adicionar o ID
                    'name' => $grade->assessment_name,
                    'grade' => $grade->grade,
                    'weight' => $grade->weight,
                    'subject' => $grade->subject->name
                ];
            })->toArray(),
            'third_trimester' => $grades->get('third_trimester', collect())->map(function($grade) {
                return [
                    'id' => $grade->id, // ← Adicionar o ID
                    'name' => $grade->assessment_name,
                    'grade' => $grade->grade,
                    'weight' => $grade->weight,
                    'subject' => $grade->subject->name
                ];
            })->toArray(),
        ];
    }

    public function showByClass($classId)
    {
        $schoolClass = SchoolClass::with(['students'])->findOrFail($classId);
        return view('teacher.students.by-class', compact('schoolClass'));
    }
}