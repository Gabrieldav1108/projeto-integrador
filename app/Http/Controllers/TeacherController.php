<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use App\Models\User;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::with('subject')->get();
        return view('admin.teachers.manage', compact('teachers'));
    }

    public function create()
    {
        $subjects = Subject::all();
        return view('admin.teachers.create', compact('subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'subject_id' => 'required|exists:subjects,id',
            'phone' => 'nullable|string|max:20',
            'hire_date' => 'required|date',
        ]);

        DB::transaction(function () use ($validated) {
            // 1. Criar usuário para login na tabela users
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'teacher',
            ]);

            // 2. Criar registro na tabela teachers COM user_id e subject_id
            Teacher::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'subject_id' => $validated['subject_id'],
                'phone' => $validated['phone'],
                'hire_date' => $validated['hire_date'],
                'user_id' => $user->id,
            ]);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Professor criado com sucesso!');
    }

    public function show(Teacher $teacher)
    {
        return view('admin.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $subjects = Subject::all();
        return view('admin.teachers.edit', compact('teacher', 'subjects'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        // Validar formato do email; lógica de existência/uniqueness é tratada abaixo
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'password' => 'nullable|min:6',
            'subject_id' => 'required|exists:subjects,id',
            'phone' => 'nullable|string|max:20',
            'hire_date' => 'required|date',
            'is_active' => 'boolean'
        ]);

        DB::transaction(function () use ($teacher, $validated, $request) {
            // 1. Verificar se já existe um User com esse email
            $user = User::where('email', $validated['email'])->first();

            if ($user) {
                // Se existir e for diferente do user atual, associar
                if (empty($teacher->user_id) || $teacher->user_id != $user->id) {
                    if (Schema::hasColumn($teacher->getTable(), 'user_id')) {
                        $teacher->user_id = $user->id;
                    }
                }
            } else {
                // Não existe: criar novo usuário
                $user = User::create([
                    'name' => $validated['name'],
                    'email' => $validated['email'],
                    'password' => !empty($validated['password']) ? Hash::make($validated['password']) : Hash::make('password123'),
                    'role' => 'teacher',
                ]);

                if (Schema::hasColumn($teacher->getTable(), 'user_id')) {
                    $teacher->user_id = $user->id;
                }
            }

            // Atualizar dados do usuário encontrado/criado
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
            ];
            if (!empty($validated['password'])) {
                $userData['password'] = Hash::make($validated['password']);
            }
            $user->update($userData);

            // 2. Atualizar registro na tabela teachers
            $teacherData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'subject_id' => $validated['subject_id'],
                'phone' => $validated['phone'],
                'hire_date' => $validated['hire_date'],
                'is_active' => $request->has('is_active')
            ];

            if (!empty($validated['password'])) {
                $teacherData['password'] = Hash::make($validated['password']);
            }

            // Se fizemos atribuição direta em $teacher->user_id acima, persista antes do update
            if (isset($teacher->user_id)) {
                $teacher->save();
            }

            $teacher->update($teacherData);
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Professor atualizado com sucesso!');
    }

    public function destroy(Teacher $teacher)
    {
        DB::transaction(function () use ($teacher) {
            // Deletar usuário associado
            $user = User::find($teacher->user_id);
            if ($user) {
                $user->delete();
            }
            
            $teacher->delete();
        });

        return redirect()->route('admin.teachers.index')->with('success', 'Professor excluído com sucesso!');
    }
}