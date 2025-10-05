<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Container\Attributes\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log as FacadesLog;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Carrega dados específicos baseados no role
        if ($user->role === 'teacher' || $user->role === 'student') {
            $user->load('classes');
        }
        
        // Estatísticas para admin
        $stats = [];
        if ($user->role === 'admin') {
            $stats = [
                'total_users' => User::count(),
                'total_teachers' => User::where('role', 'teacher')->count(),
                'total_students' => User::where('role', 'student')->count(),
                'total_classes' => SchoolClass::count(),
            ];
        }

        return view('user.profile', compact('user', 'stats'));
    }

    public function edit()
    {
        /** @var User $user */
        $user = Auth::user();
        return view('user.editProfile', compact('user'));
    }

    public function update(Request $request)
{
    /** @var User $user */
    $user = Auth::user();

    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users,email,' . $user->id,
        'password' => 'nullable|min:8|confirmed',
        'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    try {
        // Atualizar dados básicos
        $user->name = $request->name;
        $user->email = $request->email;

        // Atualizar senha se fornecida
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Processar upload da foto - SALVAR NA PASTA PUBLIC
        if ($request->hasFile('foto') && $request->file('foto')->isValid()) {
            
            // Criar pasta se não existir
            $pastaDestino = public_path('images/profiles');
            if (!file_exists($pastaDestino)) {
                mkdir($pastaDestino, 0755, true);
            }

            // Deletar foto antiga se existir
            if ($user->foto && file_exists($pastaDestino . '/' . $user->foto)) {
                unlink($pastaDestino . '/' . $user->foto);
            }

            // Gerar nome único para a nova foto
            $extension = $request->file('foto')->getClientOriginalExtension();
            $fotoName = 'user_' . $user->id . '_' . time() . '.' . $extension;
            
            // Mover a foto para a pasta public/images/profiles
            $request->file('foto')->move($pastaDestino, $fotoName);
            
            $user->foto = $fotoName;
        }

        // Salvar usuário
        $user->save();

        return redirect()->route('profile')->with('success', 'Perfil atualizado com sucesso!');

    } catch (\Exception $e) {
        FacadesLog::error('Error updating profile', ['error' => $e->getMessage()]);
        return redirect()->back()->with('error', 'Erro ao atualizar perfil: ' . $e->getMessage());
    }
}

    
}