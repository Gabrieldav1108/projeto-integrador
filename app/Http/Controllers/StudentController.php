<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = Student::with('schoolClass')->get();

        return view('admin.students.manage', compact('students'));
    }

    public function create()
    {
        $schoolClasses = \App\Models\SchoolClass::all();
        return view('admin.students.create', compact('schoolClasses'));
    }
    
    public function store(Request $request)
    {
        // Validação dos dados recebidos do formulário
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:student',
            'age' => 'required|integer|min:1|max:25',
            'password' => 'required|string|min:6',
            'class_id' => 'required|exists:classes,id',
        ]);

        Student::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'age' => $validatedData['age'],
            'password' => bcrypt($validatedData['password']),
            'class_id' => $validatedData['class_id'],
        ]);

        // Redirecionamento após a criação
        return redirect()->route('admin.index')->with('success', 'Estudante criado com sucesso!');
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $schoolClasses = \App\Models\SchoolClass::all();
        return view('admin.students.edit', compact('student', 'schoolClasses'));
    }

    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);
        //dd($student);

        // Validação dos dados recebidos do formulário
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:student,email,' . $student->id,
            'age' => 'required|integer|min:1|max:25',
            'password' => 'nullable|string|min:6',
            'class_id' => 'required|exists:classes,id',
        ]);

        $student->name = $validatedData['name'];
        $student->email = $validatedData['email'];
        $student->age = $validatedData['age'];
        if (!empty($validatedData['password'])) {
            $student->password = bcrypt($validatedData['password']);
        }
        $student->class_id = $validatedData['class_id'];
        $student->save();

        // Redirecionamento após a atualização
        return redirect()->route('admin.index')->with('success', 'Estudante atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('admin.index')->with('success', 'Estudante deletado com sucesso!');
    }
}
