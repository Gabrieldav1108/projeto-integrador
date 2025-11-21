<?php

namespace App\Http\Controllers;

use App\Models\ClassContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StudentContentController extends Controller
{
    public function view(ClassContent $content)
    {
        $user = Auth::user();
        
        // Verificar se o aluno tem acesso a este conteúdo (está na turma)
        $userClassIds = $user->schoolClasses->pluck('id');
        if (!$userClassIds->contains($content->class_id)) {
            abort(403, 'Acesso não autorizado.');
        }

        $schoolClass = $content->schoolClass;

        return view('student.contents.view', compact('content', 'schoolClass'));
    }

    public function download(ClassContent $content)
    {
        $user = Auth::user();
        
        // Verificar se o aluno tem acesso a este conteúdo (está na turma)
        $userClassIds = $user->schoolClasses->pluck('id');
        if (!$userClassIds->contains($content->class_id)) {
            abort(403, 'Acesso não autorizado.');
        }

        // Verificar se o conteúdo é PDF e tem arquivo
        if ($content->type !== 'pdf' || !$content->file_path) {
            abort(404, 'Arquivo não encontrado.');
        }

        // Verificar se o arquivo existe no storage
        if (!Storage::disk('public')->exists($content->file_path)) {
            abort(404, 'Arquivo não encontrado no servidor.');
        }

        // Fazer o download do arquivo
        $fileName = $content->title . '.pdf';
        
        return Storage::disk('public')->download($content->file_path, $fileName);
    }
}