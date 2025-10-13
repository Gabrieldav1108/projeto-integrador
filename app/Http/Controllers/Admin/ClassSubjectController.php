<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolClass;
use App\Models\Subject;
use Illuminate\Http\Request;

class ClassSubjectController extends Controller
{
    public function edit($classId)
    {
        $schoolClass = SchoolClass::with('subjects')->findOrFail($classId);
        $subjects = Subject::orderBy('name')->get();
        
        return view('admin.classes.subjects', compact('schoolClass', 'subjects'));
    }

    public function update(Request $request, $classId)
    {
        $schoolClass = SchoolClass::findOrFail($classId);
        
        $request->validate([
            'subjects' => 'nullable|array',
            'subjects.*' => 'exists:subjects,id'
        ]);

        // Sincronizar as matérias (se não vier subjects, será array vazio)
        $schoolClass->subjects()->sync($request->subjects ?? []);

        return redirect()->route('admin.classes.index')
            ->with('success', 'Matérias vinculadas à turma com sucesso!');
    }
}