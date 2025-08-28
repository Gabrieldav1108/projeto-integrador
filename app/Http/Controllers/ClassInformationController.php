<?php

namespace App\Http\Controllers;

use App\Models\ClassInformation as ModelsClassInformation;
use App\Models\SchoolClass;
use COM;
use Illuminate\Http\Request;

class ClassInformationController extends Controller
{
    public function index($classId)
    {
        $schoolClass = SchoolClass::findOrFail($classId);
        
        $informations = ModelsClassInformation::where('class_id', $classId)
            ->orderBy('created_at', 'desc')
            ->get();
            
        // Verifique se há informações
        if ($informations->isEmpty()) {
            // Se não houver informações, passe um array vazio
            return view('teacher.class', compact('schoolClass', 'informations'));
        }
        
        $informations = \App\Models\ClassInformation::where('class_id', $classId)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('teacher.class', compact('informations', 'schoolClass'));
    }

    public function show($classId)
    {
        $schoolClass = SchoolClass::findOrFail($classId);
        $informations = ModelsClassInformation::where('class_id', $classId)->get();


        if (!$informations) {
            return redirect()->route('class.informations', $classId)
                             ->with('error', 'No information available for this class.');
        }

        return view('teacher.class', [
            'schoolClass' => $schoolClass,
            'informations' => $informations,
        ]);
    }

    public function create($classId)
    {
        $schoolClass = SchoolClass::findOrFail($classId);
        return view('teacher.addClassInformation', compact('schoolClass'));
    }

    public function store(Request $request, $classId)
    {
        $request->validate([
            'content' => 'required|string',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
        ]);

            ModelsClassInformation::create([
            'class_id' => $classId,
            'content' => $request->input('content'),
            'date' => $request->input('date'),
            'time' => $request->input('time'),
        ]);

        return redirect()->route('class.information.show', $classId)
                ->with('success', 'Class information added successfully.');
    }

    public function edit($classId, $id)
    {
        $schoolClass = SchoolClass::findOrFail($classId);
        $information = \App\Models\ClassInformation::where('class_id', $classId)
            ->findOrFail($id);
        return view('teacher.editClassInformation', compact('schoolClass', 'information'));
    }

    public function update(Request $request, $classId, $id)
    {
        $request->validate([
            'content' => 'required|string',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
        ]);

        $information = \App\Models\ClassInformation::where('class_id', $classId)
            ->findOrFail($id);

        $information->update([
            'content' => $request->input('content'),
            'date' => $request->input('date'),
            'time' => $request->input('time'),
        ]);

        return redirect()->route('class.information.show', ['classId' => $classId])
                         ->with('success', 'Class information updated successfully.');
    }

    public function destroy($classId, $id)
    {
        $information = \App\Models\ClassInformation::where('class_id', $classId)
            ->findOrFail($id);
        $information->delete();

        return redirect()->route('class.information.show', ['classId' => $classId])
                         ->with('success', 'Class information deleted successfully.');
    }

}
