<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:student',
            'age' => 'required|integer|min:1|max:25',
            'password' => 'required|string|min:6|confirmed',
            'class_id' => 'required|exists:classes,id',
        ]);

        // Criar usuário para login - ADICIONE class_id AQUI
        $user = \App\Models\User::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'role' => 'student',
            'class_id' => $validatedData['class_id'], // ← ESTÁ FALTANDO ESTA LINHA!
        ]);

        // Criar estudante na tabela student
        $student = Student::create([
            'name' => $validatedData['name'],
            'email' => $validatedData['email'],
            'age' => $validatedData['age'],
            'password' => Hash::make($validatedData['password']),
            'class_id' => $validatedData['class_id'],
            'user_id' => $user->id, 
        ]);

        return redirect()->route('admin.students.index')->with('success', 'Estudante criado com sucesso!');
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

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:student,email,' . $student->id,
            'age' => 'required|integer|min:1|max:25',
            'password' => 'nullable|string|min:6',
            'class_id' => 'required|exists:classes,id',
        ]);

        // Atualizar estudante
        $student->name = $validatedData['name'];
        $student->email = $validatedData['email'];
        $student->age = $validatedData['age'];
        if (!empty($validatedData['password'])) {
            $student->password = Hash::make($validatedData['password']);
        }
        $student->class_id = $validatedData['class_id'];
        $student->save();

        // Atualizar usuário correspondente - ADICIONE class_id AQUI
        $user = \App\Models\User::where('email', $student->email)->first();
        if ($user) {
            $user->name = $validatedData['name'];
            $user->class_id = $validatedData['class_id']; // ← ESTÁ FALTANDO ESTA LINHA!
            if (!empty($validatedData['password'])) {
                $user->password = Hash::make($validatedData['password']);
            }
            $user->save();
        }

        return redirect()->route('admin.students.index')->with('success', 'Estudante atualizado com sucesso!');
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        
        $user = \App\Models\User::where('email', $student->email)->first();
        if ($user) {
            $user->delete();
        }
        
        $student->delete();

        return redirect()->route('admin.students.index')->with('success', 'Estudante deletado com sucesso!');
    }
}