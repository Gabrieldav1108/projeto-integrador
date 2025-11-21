<?php

namespace App\Http\Controllers;

use App\Models\ClassContent;
use App\Models\SchoolClass;
use App\Models\Subject;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ClassContentController extends Controller
{
    public function view(ClassContent $content)
    {
        $teacher = Teacher::where('user_id', Auth::id())->first();
        
        // Verificar se o conteúdo pertence à matéria do professor
        if ($content->subject_id != $teacher->subject_id) {
            abort(403, 'Acesso não autorizado.');
        }

        $schoolClass = $content->schoolClass;

        return view('teacher.contents.view', compact('content', 'schoolClass'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validationRules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:text,pdf,video,link',
            'class_id' => 'required|exists:classes,id',
            'subject_id' => 'required|exists:subjects,id',
            'teacher_id' => 'required|exists:teachers,id',
            'content' => 'nullable|string', 
        ];

        if ($request->type === 'pdf') {
            $validationRules['file'] = 'required|file|mimes:pdf|max:102400'; // 100MB
        }

        $request->validate($validationRules);

        try {
            $filePath = null;
            $contentText = null;
            
            switch ($request->type) {
                case 'pdf':
                    if ($request->hasFile('file')) {
                        $file = $request->file('file');
                        
                        // Manter só as primeiras 20 letras do nome original + timestamp
                        $cleanName = substr(preg_replace('/[^A-Za-z0-9]/', '_', pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)), 0, 20);
                        $fileName = 'content_' . time() . '_' . $cleanName . '.pdf';
                        $filePath = $file->storeAs('class_contents', $fileName, 'public');
                    }
                    $contentText = null;
                    break;
                case 'text':
                case 'video':
                case 'link':
                    $contentText = $request->content;
                    break;
            }

            ClassContent::create([
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $filePath,
                'content' => $contentText,
                'type' => $request->type,
                'class_id' => $request->class_id,
                'subject_id' => $request->subject_id,
                'teacher_id' => $request->teacher_id,
            ]);

            return redirect()->back()->with('success', 'Conteúdo adicionado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao adicionar conteúdo: ' . $e->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $content = ClassContent::findOrFail($id);

        // Verificar se o professor é o dono do conteúdo
        $teacher = Teacher::where('user_id', Auth::id())->first();
        if ($content->teacher_id !== $teacher->id) {
            return redirect()->back()->with('error', 'Você não tem permissão para editar este conteúdo.');
        }

        $validationRules = [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:text,pdf,video,link',
        ];

        // Adicionar regras condicionais
        if ($request->type === 'pdf') {
            $validationRules['file'] = 'nullable|file|mimes:pdf|max:10240';
        } elseif (in_array($request->type, ['text', 'video', 'link'])) {
            $validationRules['content'] = 'required|string';
        }

        $request->validate($validationRules);

        try {
            $filePath = $content->file_path;
            $contentText = $content->content;
            
            // Processar baseado no tipo
            if ($request->type === 'pdf') {
                if ($request->hasFile('file')) {
                    // Deletar arquivo antigo se existir
                    if ($filePath && Storage::disk('public')->exists($filePath)) {
                        Storage::disk('public')->delete($filePath);
                    }
                    
                    $file = $request->file('file');
                    $fileName = 'content_' . time() . '_' . $file->getClientOriginalName();
                    $filePath = $file->storeAs('class_contents', $fileName, 'public');
                }
                $contentText = null; // Limpar conteúdo textual para PDF
            } else {
                // Se mudou de PDF para outro tipo, deletar arquivo
                if ($filePath && Storage::disk('public')->exists($filePath)) {
                    Storage::disk('public')->delete($filePath);
                }
                $filePath = null;
                $contentText = $request->content; // Salvar conteúdo textual
            }

            // Atualizar o conteúdo
            $content->update([
                'title' => $request->title,
                'description' => $request->description,
                'file_path' => $filePath,
                'content' => $contentText,
                'type' => $request->type,
            ]);

            return redirect()->back()->with('success', 'Conteúdo atualizado com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar conteúdo: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $content = ClassContent::findOrFail($id);

        // Verificar se o professor é o dono do conteúdo
        $teacher = Teacher::where('user_id', Auth::id())->first();
        if ($content->teacher_id !== $teacher->id) {
            return redirect()->back()->with('error', 'Você não tem permissão para excluir este conteúdo.');
        }

        try {
            // Deletar arquivo se existir
            if ($content->file_path && Storage::disk('public')->exists($content->file_path)) {
                Storage::disk('public')->delete($content->file_path);
            }

            $content->delete();

            return redirect()->back()->with('success', 'Conteúdo excluído com sucesso!');

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao excluir conteúdo: ' . $e->getMessage());
        }
    }

    /**
     * Download do arquivo
     */
    public function download($id)
    {
        $content = ClassContent::findOrFail($id);

        if (!$content->file_path || !Storage::disk('public')->exists($content->file_path)) {
            return redirect()->back()->with('error', 'Arquivo não encontrado.');
        }

        return Storage::disk('public')->download($content->file_path);
    }
}