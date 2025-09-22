<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Primeiro, tenta autenticar o usuário
        $request->authenticate();

        // Regenera a sessão para prevenir fixation attacks
        $request->session()->regenerate();

        // Agora pega o usuário autenticado
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors([
                'email' => 'Falha ao autenticar. Verifique suas credenciais.',
            ]);
        }

        // Redireciona baseado no role
        if ($user->role === 'admin') {
            return redirect()->route('admin.home');
        } elseif ($user->role === 'teacher') {
            return redirect()->route('teacher.home');
        } else {
            return redirect()->route('student.home');
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}