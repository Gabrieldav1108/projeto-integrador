<?php

namespace App\Http\Controllers;

use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ClassInformation;
use App\Models\SchoolClass;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\FacadesFacadesStorage as FacadesFacadesStorage;
use Illuminate\Support\Facades\Storage;

class ClassInformationController extends Controller
{
    public function index($classId)
    {
        $user = Auth::user();
        $teacher = Teacher::where('user_id', $user->id)->first();
        
        if (!$teacher) {
            abort(403, 'Acesso negado. Usuário não é um professor.');
        }

        $schoolClass = SchoolClass::with(['students'])->findOrFail($classId);
        
        // Verificar se o professor tem acesso a esta turma
        $isTeacherInClass = $schoolClass->teachers->contains('id', $teacher->id);
        if (!$isTeacherInClass) {
            abort(403, 'Você não tem acesso a esta turma.');
        }
        
        // Buscar avisos APENAS da matéria do professor atual
        $informations = ClassInformation::where('class_id', $classId)
            ->where('subject_id', $teacher->subject_id) // ← FILTRAR PELA MATÉRIA DO PROFESSOR
            ->active() 
            ->latest()
            ->get();
        
        return view('teacher.class', compact('schoolClass', 'informations', 'teacher'));
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
    

}