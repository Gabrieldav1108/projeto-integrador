<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\SchoolClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function show()
    {
        /** @var User $user */
        $user = Auth::user();
        
        // Carrega dados específicos baseados no role
        if ($user->role === 'teacher') {
            // Carrega o perfil do professor com a matéria
            $user->load(['teacherProfile.subject']);
            
            // Não usa mais o carregamento eager de teacherClasses pois agora é complexo
            // Os dados serão carregados pelos métodos personalizados
        } elseif ($user->role === 'student') {
            $user->load(['studentClasses']);
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

    // ... resto do código permanece igual ...
}