<x-app-layout>
    @slot('title', $content->title)
    
    <x-student-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <!-- Cabeçalho -->
        <div class="d-flex justify-content-between align-items-start mb-4">
            <div class="flex-grow-1">
                <div class="d-flex align-items-center mb-3">
                    @switch($content->type)
                        @case('pdf')
                            <i class="fas fa-file-pdf text-danger fa-2x me-3"></i>
                            @break
                        @case('text')
                            <i class="fas fa-file-alt text-primary fa-2x me-3"></i>
                            @break
                        @case('video')
                            <i class="fas fa-video text-success fa-2x me-3"></i>
                            @break
                        @case('link')
                            <i class="fas fa-link text-info fa-2x me-3"></i>
                            @break
                    @endswitch
                    <div>
                        <h1 class="fw-bold text-primary mb-1">{{ $content->title }}</h1>
                        <div class="d-flex flex-wrap gap-2 align-items-center">
                            <span class="badge bg-secondary">
                                <i class="fas fa-book me-1"></i>
                                {{ $content->subject->name }}
                            </span>
                            <span class="badge bg-warning text-dark">
                                <i class="fas fa-tag me-1"></i>
                                {{ ucfirst($content->type) }}
                            </span>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-calendar me-1"></i>
                                {{ $content->created_at->format('d/m/Y H:i') }}
                            </span>
                            <span class="badge bg-info">
                                <i class="fas fa-users me-1"></i>
                                {{ $schoolClass->name }}
                            </span>
                        </div>
                    </div>
                </div>
                
                @if($content->description)
                <div class="alert alert-info">
                    <strong><i class="fas fa-info-circle me-2"></i>Descrição:</strong>
                    <p class="mb-0 mt-2">{{ $content->description }}</p>
                </div>
                @endif
            </div>
            
            <div class="d-flex gap-2">
                <a href="{{ url()->previous() }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Voltar
                </a>
            </div>
        </div>

        <!-- Conteúdo Principal -->
        <div class="row g-4">
            <!-- Conteúdo do Material -->
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h4 class="mb-0 text-dark">
                            <i class="fas fa-eye me-2"></i>
                            Visualização do Conteúdo
                        </h4>
                    </div>
                    <div class="card-body p-4">
                        @switch($content->type)
                            @case('pdf')
                                @if($content->file_path && Storage::disk('public')->exists($content->file_path))
                                <div class="text-center">
                                    <div class="mb-4">
                                        <i class="fas fa-file-pdf text-danger fa-5x mb-3"></i>
                                        <h4 class="text-dark">Documento PDF</h4>
                                        <p class="text-muted">Clique no botão abaixo para visualizar o arquivo</p>
                                    </div>
                                    <div class="d-flex justify-content-center gap-3 flex-wrap">
                                        <!-- Botão Abrir PDF -->
                                        <a href="{{ asset('storage/' . $content->file_path) }}" 
                                           target="_blank"
                                           class="btn btn-primary btn-lg">
                                            <i class="fas fa-external-link-alt me-2"></i>
                                            Abrir PDF
                                        </a>
                                        
                                        <!-- Botão Baixar PDF -->
                                        <a href="{{ route('student.contents.download', $content->id) }}" 
                                           class="btn btn-success btn-lg">
                                            <i class="fas fa-download me-2"></i>
                                            Baixar PDF
                                        </a>
                                    </div>
                                </div>
                                @else
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                    <h5>Arquivo não encontrado</h5>
                                    <p>O arquivo PDF não está disponível para visualização.</p>
                                </div>
                                @endif
                                @break
                                
                            @case('text')
                                @if($content->content)
                                <div class="content-text">
                                    <div class="bg-light p-4 rounded mb-4">
                                        <h5 class="text-dark mb-3">Conteúdo em Texto</h5>
                                        <div class="text-content" style="line-height: 1.8; font-size: 1.1em;">
                                            {!! nl2br(e($content->content)) !!}
                                        </div>
                                    </div>
                                </div>
                                @else
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                                    <h5>Conteúdo não disponível</h5>
                                    <p>O conteúdo em texto não está disponível.</p>
                                </div>
                                @endif
                                @break
                                
                            @case('video')
                                @if($content->content)
                                <div class="text-center">
                                    <div class="mb-4">
                                        <i class="fas fa-video text-success fa-5x mb-3"></i>
                                        <h4 class="text-dark">Conteúdo em Vídeo</h4>
                                        <p class="text-muted">Link do vídeo</p>
                                    </div>
                                    <div class="bg-light p-4 rounded mb-4">
                                        <a href="{{ $content->content }}" 
                                           target="_blank"
                                           class="btn btn-primary btn-lg mb-3">
                                            <i class="fas fa-external-link-alt me-2"></i>
                                            Assistir Vídeo
                                        </a>
                                        <div class="mt-3">
                                            <strong>URL:</strong>
                                            <a href="{{ $content->content }}" target="_blank" class="text-break">
                                                {{ $content->content }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @break
                                
                            @case('link')
                                @if($content->content)
                                <div class="text-center">
                                    <div class="mb-4">
                                        <i class="fas fa-link text-info fa-5x mb-3"></i>
                                        <h4 class="text-dark">Link Externo</h4>
                                        <p class="text-muted">Recurso online</p>
                                    </div>
                                    <div class="bg-light p-4 rounded">
                                        <a href="{{ $content->content }}" 
                                           target="_blank"
                                           class="btn btn-info btn-lg mb-3">
                                            <i class="fas fa-external-link-alt me-2"></i>
                                            Acessar Link
                                        </a>
                                        <div class="mt-3">
                                            <strong>URL:</strong>
                                            <a href="{{ $content->content }}" target="_blank" class="text-break">
                                                {{ $content->content }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                @break
                        @endswitch
                    </div>
                </div>
            </div>

            <!-- Informações Adicionais -->
            <div class="col-12 col-lg-4">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0 text-dark">
                            <i class="fas fa-info-circle me-2"></i>
                            Informações
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <strong><i class="fas fa-user-tie me-2 text-primary"></i>Professor:</strong>
                            <p class="mb-0">{{ $content->teacher->user->name ?? 'N/A' }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <strong><i class="fas fa-book me-2 text-primary"></i>Matéria:</strong>
                            <p class="mb-0">{{ $content->subject->name }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <strong><i class="fas fa-users me-2 text-primary"></i>Turma:</strong>
                            <p class="mb-0">{{ $schoolClass->name }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <strong><i class="fas fa-calendar me-2 text-primary"></i>Criado em:</strong>
                            <p class="mb-0">{{ $content->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
    .content-text {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    .text-content {
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    .card {
        border-radius: 1rem;
    }
    .btn {
        border-radius: 0.5rem;
    }
    </style>
</x-app-layout>