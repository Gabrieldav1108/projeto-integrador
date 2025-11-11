<?php

namespace App\Http\Controllers;

use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher; // ← Importar o model Teacher
use Illuminate\Http\Request;

class ClassController extends Controller
{
    public function index()
    {
        $classes = SchoolClass::with(['teachers', 'subjects'])->get();
        return view('admin.classes.manage', compact('classes'));
    }
    

    public function create()
    {
        $teachers = Teacher::all(); 
        $subjects = Subject::all();
        return view('admin.classes.create', compact('teachers', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'numberClass' => 'required|integer',
            'teachers' => 'array',
            'subjects' => 'array',
        ]);

        $class = SchoolClass::create([
            'name' => $request->name,
            'numberClass' => $request->numberClass,
        ]);

        // Salvar professores
        if ($request->has('teachers')) {
            $class->teachers()->attach($request->teachers);
        }

        if ($request->has('subjects')) {
            $class->subjects()->attach($request->subjects);
        }

        return redirect()->route('admin.classes.index')
            ->with('success', 'Turma criada com sucesso!');
    }

    public function show(string $id)
    {
        $class = SchoolClass::with('teachers')->findOrFail($id);
        return view('admin.classes.show', compact('class'));
    }

    public function edit(string $id)
    {
        $class = SchoolClass::with('teachers')->findOrFail($id);
        $teachers = Teacher::all(); // ← Buscar da tabela teachers

        return view('admin.classes.edit', compact('class', 'teachers'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'numberClass' => 'required|integer|min:1',
        ]);

        $class = SchoolClass::findOrFail($id);
        
        $class->update([
            'name' => $request->name,
            'numberClass' => $request->numberClass,
        ]);

        if ($request->filled('teachers_ids')) {
            $teacherIds = explode(',', $request->teachers_ids);
            $class->teachers()->sync($teacherIds);
        } else {
            $class->teachers()->detach();
        }

        return redirect()->route('admin.classes.index')
                         ->with('success', 'Turma atualizada com sucesso!');
    }

    public function destroy(string $id)
    {
        $class = SchoolClass::findOrFail($id);
        $class->delete();

        return redirect()->route('admin.classes.index')
                         ->with('success', 'Turma removida com sucesso!');
    }

}