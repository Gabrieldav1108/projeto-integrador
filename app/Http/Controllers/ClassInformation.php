<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use Illuminate\Http\Request;

class ClassInformation extends Controller
{
    public function index($classId)
    {
        $class = SchoolClass::findOrFail($classId);
        
        $informations = \App\Models\ClassInformation::where('class_id', $classId)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('teacher.classInformation');
    }

    public function create($classId)
    {
        $class = SchoolClass::findOrFail($classId);
        return view('teacher.addClassInformation', compact('class'));
    }

    public function store(Request $request, $classId)
    {
        $request->validate([
            'content' => 'required|string',
            'date' => 'nullable|date',
            'time' => 'nullable|date_format:H:i',
        ]);

        ClassInformation::create([
            'class_id' => $classId,
            'content' => $request->input('content'),
            'date' => $request->input('date'),
            'time' => $request->input('time'),
        ]);

        return redirect()->route('class', ['classId' => $classId])
                         ->with('success', 'Class information added successfully.');
    }

    public function edit($classId, $id)
    {
        $class = SchoolClass::findOrFail($classId);
        $information = \App\Models\ClassInformation::where('class_id', $classId)
            ->findOrFail($id);
        return view('teacher.editClassInformation', compact('class', 'information'));
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

        return redirect()->route('class', ['classId' => $classId])
                         ->with('success', 'Class information updated successfully.');
    }

    public function destroy($classId, $id)
    {
        $information = \App\Models\ClassInformation::where('class_id', $classId)
            ->findOrFail($id);
        $information->delete();

        return redirect()->route('class', ['classId' => $classId])
                         ->with('success', 'Class information deleted successfully.');
    }

}
