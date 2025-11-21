@props([
    'schoolClass',
    'teacher'
])


@php
    // Buscar conteúdos desta turma apenas da matéria do professor
    $contents = \App\Models\ClassContent::where('class_id', $schoolClass->id)
    ->where('subject_id', $teacher->subject_id)
    ->with('subject')
    ->orderBy('created_at', 'desc')
    ->get();
    @endphp

<div class="col-12 col-lg-4 d-flex flex-column">
    <div class="card shadow-sm border-0 h-100">
        <div class="card-header bg-warning text-dark py-3">
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="mb-0">
                    <i class="fas fa-book me-2"></i>
                    Conteúdos - {{ $teacher->subject->name }}
                </h4>
                <button type="button" 
                        class="btn btn-dark btn-sm" 
                        data-bs-toggle="modal" 
                        data-bs-target="#addContentModal">
                    <i class="fas fa-plus me-1"></i>Novo
                </button>
            </div>
        </div>
        <div class="card-body p-0">
            <div class="p-3" style="max-height: 450px; overflow-y: auto;">
                @if($contents->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($contents as $content)
                            <div class="list-group-item py-3">
                                <div class="d-flex justify-content-between align-items-start mb-3">
                                    <div class="flex-grow-1 me-3">
                                        <div class="d-flex align-items-center mb-2">
                                            @switch($content->type)
                                                @case('pdf')
                                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                                    @break
                                                @case('text')
                                                    <i class="fas fa-file-alt text-primary me-2"></i>
                                                    @break
                                                @case('video')
                                                    <i class="fas fa-video text-success me-2"></i>
                                                    @break
                                                @case('link')
                                                    <i class="fas fa-link text-info me-2"></i>
                                                    @break
                                                @default
                                                    <i class="fas fa-file me-2"></i>
                                            @endswitch
                                            <h6 class="fw-bold text-dark mb-0">{{ $content->title }}</h6>
                                        </div>
                                        
                                        @if($content->description)
                                            <p class="text-muted mb-3 small">
                                                {{ Str::limit($content->description, 100) }}
                                            </p>
                                        @endif
                                        
                                        <div class="d-flex flex-wrap gap-2 mb-2">
                                            <span class="badge bg-secondary px-2 py-1">
                                                <i class="fas fa-book me-1"></i>
                                                {{ $content->subject->name }}
                                            </span>
                                            <span class="badge bg-warning px-2 py-1 text-dark">
                                                <i class="fas fa-tag me-1"></i>
                                                {{ ucfirst($content->type) }}
                                            </span>
                                            <span class="badge bg-light text-dark px-2 py-1">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $content->created_at->format('d/m/Y') }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="d-flex gap-2">
                                    <!-- Botão Visualizar (Página Detalhada) -->
                                    <a href="{{ route('teacher.content.view', $content->id) }}" 
                                       class="btn btn-outline-info btn-sm">
                                        <i class="fas fa-eye me-1"></i>Visualizar
                                    </a>
                                    
                                    <!-- Botão Editar -->
                                    <button type="button" 
                                            class="btn btn-outline-warning btn-sm"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editContentModal{{ $content->id }}">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </button>
                                    
                                    <!-- Botão Excluir -->
                                    <button type="button" 
                                            class="btn btn-outline-danger btn-sm"
                                            onclick="if(confirm('Tem certeza que deseja excluir este conteúdo?')) { document.getElementById('delete-content-form-{{ $content->id }}').submit(); }">
                                        <i class="fas fa-trash me-1"></i>Excluir
                                    </button>
                                </div>

                                <!-- Formulário de Exclusão -->
                                <form id="delete-content-form-{{ $content->id }}" 
                                      action="{{ route('teacher.content.destroy', $content->id) }}" 
                                      method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>

                                <!-- Modal de Edição -->
                                <div class="modal fade" id="editContentModal{{ $content->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <form action="{{ route('teacher.content.update', $content->id) }}" 
                                                  method="POST" 
                                                  enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Editar Conteúdo</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Título *</label>
                                                        <input type="text" 
                                                               class="form-control" 
                                                               name="title" 
                                                               value="{{ $content->title }}" 
                                                               required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Descrição</label>
                                                        <textarea class="form-control" 
                                                                  name="description" 
                                                                  rows="2">{{ $content->description }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Tipo de Conteúdo</label>
                                                        <select class="form-select" name="type" id="type-edit-{{ $content->id }}">
                                                            <option value="text" {{ $content->type == 'text' ? 'selected' : '' }}>Texto</option>
                                                            <option value="pdf" {{ $content->type == 'pdf' ? 'selected' : '' }}>PDF</option>
                                                            <option value="video" {{ $content->type == 'video' ? 'selected' : '' }}>Vídeo</option>
                                                            <option value="link" {{ $content->type == 'link' ? 'selected' : '' }}>Link</option>
                                                        </select>
                                                    </div>
                                                    <div class="mb-3" id="file-input-edit-{{ $content->id }}" style="{{ $content->type != 'pdf' ? 'display: none;' : '' }}">
                                                        <label class="form-label">Arquivo PDF</label>
                                                        <input type="file" 
                                                               class="form-control" 
                                                               name="file"
                                                               accept=".pdf">
                                                        @if($content->file_path)
                                                            <small class="text-muted">Arquivo atual: {{ basename($content->file_path) }}</small>
                                                        @endif
                                                    </div>
                                                    <div class="mb-3" id="content-input-edit-{{ $content->id }}" style="{{ $content->type != 'text' ? 'display: none;' : '' }}">
                                                        <label class="form-label">Conteúdo em Texto</label>
                                                        <textarea class="form-control" 
                                                                  name="content" 
                                                                  rows="4">{{ $content->content }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-warning">Atualizar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-book-open fa-3x mb-3"></i>
                        <p class="mb-2">Nenhum conteúdo adicionado</p>
                        <button type="button" 
                                class="btn btn-warning btn-sm" 
                                data-bs-toggle="modal" 
                                data-bs-target="#addContentModal">
                            Adicionar Primeiro Conteúdo
                        </button>
                    </div>
                @endif
            </div>
        </div>
        <div class="card-footer bg-light">
            <small class="text-muted">
                <i class="fas fa-info-circle me-1"></i>
                {{ $contents->count() }} conteúdos de {{ $teacher->subject->name }}
            </small>
        </div>
    </div>
</div>

<!-- Modal de Adição -->
<div class="modal fade" id="addContentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('teacher.content.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  id="addContentForm">
                @csrf
                <input type="hidden" name="class_id" value="{{ $schoolClass->id }}">
                <input type="hidden" name="subject_id" value="{{ $teacher->subject_id }}">
                <input type="hidden" name="teacher_id" value="{{ $teacher->id }}">
                
                <div class="modal-header">
                    <h5 class="modal-title">Adicionar Conteúdo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Título *</label>
                        <input type="text" 
                               class="form-control" 
                               name="title" 
                               id="title"
                               required
                               placeholder="Digite o título do conteúdo">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Descrição</label>
                        <textarea class="form-control" 
                                  name="description" 
                                  id="description"
                                  rows="2"
                                  placeholder="Descrição opcional do conteúdo"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tipo de Conteúdo *</label>
                        <select class="form-select" name="type" id="type-select" required>
                            <option value="">Selecione o tipo</option>
                            <option value="text">Texto</option>
                            <option value="pdf">PDF</option>
                            <option value="video">Vídeo</option>
                            <option value="link">Link</option>
                        </select>
                    </div>
                    
                    <!-- Campos para cada tipo -->
                    <div class="mb-3" id="file-input">
                        <label class="form-label">Arquivo PDF *</label>
                        <input type="file" 
                               class="form-control" 
                               name="file"
                               id="file"
                               accept=".pdf">
                        <small class="text-muted">Tamanho máximo: 10MB</small>
                    </div>
                    
                    <div class="mb-3" id="content-input">
                        <label class="form-label">Conteúdo em Texto *</label>
                        <textarea class="form-control" 
                                  name="content" 
                                  id="content"
                                  rows="4"
                                  placeholder="Digite o conteúdo textual aqui"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-warning" id="submit-btn">Adicionar</button>
                </div>
            </form>
        </div>
    </div>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

@if($errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elementos do modal de adição
    const typeSelect = document.getElementById('type-select');
    const fileInput = document.getElementById('file-input');
    const contentInput = document.getElementById('content-input');
    
    // Função para atualizar a visibilidade dos campos
    function updateInputVisibility() {
        const type = typeSelect.value;
        
        if (type === 'pdf') {
            fileInput.style.display = 'block';
            contentInput.style.display = 'none';
            document.getElementById('file').required = true;
            document.getElementById('content').required = false;
        } else if (type === 'text' || type === 'video' || type === 'link') {
            fileInput.style.display = 'none';
            contentInput.style.display = 'block';
            document.getElementById('file').required = false;
            document.getElementById('content').required = true;
        } else {
            fileInput.style.display = 'none';
            contentInput.style.display = 'none';
            document.getElementById('file').required = false;
            document.getElementById('content').required = false;
        }
    }
    
    // Event listener para mudança no select
    if (typeSelect) {
        typeSelect.addEventListener('change', updateInputVisibility);
        updateInputVisibility();
    }
    
    // Controle dos modais de edição
    document.querySelectorAll('[id^="type-edit-"]').forEach(select => {
        const contentId = select.id.replace('type-edit-', '');
        const fileInputEdit = document.getElementById('file-input-edit-' + contentId);
        const contentInputEdit = document.getElementById('content-input-edit-' + contentId);
        
        if (select && fileInputEdit && contentInputEdit) {
            select.addEventListener('change', function() {
                if (this.value === 'pdf') {
                    fileInputEdit.style.display = 'block';
                    contentInputEdit.style.display = 'none';
                } else {
                    fileInputEdit.style.display = 'none';
                    contentInputEdit.style.display = 'block';
                }
            });
        }
    });
    
    const addContentModal = document.getElementById('addContentModal');
    if (addContentModal) {
        addContentModal.addEventListener('show.bs.modal', function() {
            setTimeout(updateInputVisibility, 100);
        });
    }
});
</script>

<style>
.content-text {
    line-height: 1.6;
    white-space: pre-wrap;
}
</style>