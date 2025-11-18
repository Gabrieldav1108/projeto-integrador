<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        // Buscar o professor logado
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            abort(403, 'Usuário não é um professor.');
        }

        // Buscar a matéria do professor
        $subject = $teacher->subject;
        
        if (!$subject) {
            // Se o professor não tem matéria, buscar a primeira matéria das turmas dele
            $teacherClasses = $teacher->schoolClasses()->with('subjects')->first();
            if ($teacherClasses && $teacherClasses->subjects->count() > 0) {
                $subject = $teacherClasses->subjects->first();
            } else {
                abort(404, 'Professor não tem matéria atribuída.');
            }
        }

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

        // Buscar as notas APENAS da matéria do professor
        $grades = $this->getStudentGrades($student->id, $subject->id);

        return view('teacher.studentInformation', compact('student', 'grades', 'subject'));
    }

    // Método atualizado para filtrar por matéria
    private function getStudentGrades($studentId, $subjectId)
    {
        $grades = Grade::where('student_id', $studentId)
            ->where('subject_id', $subjectId)
            ->with('subject')
            ->get()
            ->groupBy('trimester');

        return [
            'first_trimester' => $grades->get('first_trimester', collect())->map(function($grade) {
                return [
                    'id' => $grade->id,
                    'name' => $grade->assessment_name,
                    'grade' => $grade->grade,
                    'weight' => $grade->weight,
                    'subject' => $grade->subject->name,
                    'subject_id' => $grade->subject_id
                ];
            })->toArray(),
            'second_trimester' => $grades->get('second_trimester', collect())->map(function($grade) {
                return [
                    'id' => $grade->id,
                    'name' => $grade->assessment_name,
                    'grade' => $grade->grade,
                    'weight' => $grade->weight,
                    'subject' => $grade->subject->name,
                    'subject_id' => $grade->subject_id
                ];
            })->toArray(),
            'third_trimester' => $grades->get('third_trimester', collect())->map(function($grade) {
                return [
                    'id' => $grade->id,
                    'name' => $grade->assessment_name,
                    'grade' => $grade->grade,
                    'weight' => $grade->weight,
                    'subject' => $grade->subject->name,
                    'subject_id' => $grade->subject_id
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