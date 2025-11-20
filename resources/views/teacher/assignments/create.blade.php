<x-app-layout>
    @slot('title', 'Criar Trabalho - ' . $schoolClass->name)

    <x-teacher-header/>
    
    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2>Criar Trabalho - Turma: {{ $schoolClass->name }}</h2>
        
        <div class="row d-flex gap-4 p-4">
            <!-- Formulário de Criar Trabalho -->
            <div class="col-12 col-md-5">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-plus-circle me-2"></i>Novo Trabalho</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('assignment.store', $schoolClass->id) }}">
                            @csrf
                            
                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="mb-3">
                                <label class="form-label fw-bold">Título do Trabalho</label>
                                <input type="text" class="form-control" name="title" 
                                       value="{{ old('title') }}" placeholder="Ex: Trabalho de Matemática - Álgebra" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Descrição</label>
                                <textarea class="form-control" name="description" rows="4" 
                                          placeholder="Descreva o trabalho, requisitos, formato de entrega..." required>{{ old('description') }}</textarea>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Data de Entrega</label>
                                    <input type="date" class="form-control" name="due_date" 
                                           value="{{ old('due_date') }}" min="{{ date('Y-m-d') }}" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-bold">Horário</label>
                                    <input type="time" class="form-control" name="due_time" 
                                           value="{{ old('due_time', '23:59') }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-bold">Pontuação Máxima</label>
                                <input type="number" class="form-control" name="max_points" 
                                       value="{{ old('max_points', 10) }}" step="0.1" min="0" max="1000" required>
                                <small class="text-muted">Pontos que o trabalho vale</small>
                            </div>

                            <div class="d-flex gap-2 justify-content-between mt-4">
                                <a href="#" class="btn btn-secondary" onclick="event.preventDefault(); history.back();">
                                    <i class="fas fa-arrow-left me-2"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-save me-2"></i>Criar Trabalho
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Trabalhos Atuais -->
            <div class="col-12 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-info text-white">
                        <h5 class="mb-0"><i class="fas fa-tasks me-2"></i>Trabalhos Ativos</h5>
                    </div>
                    <div class="card-body">
                        @if($currentAssignments->count() > 0)
                            <div class="list-group">
                                @foreach($currentAssignments as $assignment)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <h6 class="mb-1">{{ $assignment->title }}</h6>
                                                <p class="mb-1 text-muted small">{{ Str::limit($assignment->description, 100) }}</p>
                                                <div class="d-flex gap-3">
                                                    <small class="text-muted">
                                                        <i class="fas fa-calendar me-1"></i>
                                                        Entrega: {{ $assignment->due_date->format('d/m/Y') }}
                                                        @if($assignment->due_time)
                                                            às {{ $assignment->due_time }}
                                                        @endif
                                                    </small>
                                                    <small class="text-muted">
                                                        <i class="fas fa-star me-1"></i>
                                                        {{ $assignment->max_points }} pts
                                                    </small>
                                                </div>
                                                @if($assignment->is_expired)
                                                    <span class="badge bg-danger mt-1">Expirado</span>
                                                @else
                                                    <span class="badge bg-success mt-1">Ativo</span>
                                                @endif
                                            </div>
                                            <div class="dropdown">
                                                <button class="btn btn-sm btn-outline-secondary dropdown-toggle" 
                                                        type="button" data-bs-toggle="dropdown">
                                                    <i class="fas fa-ellipsis-v"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <a class="dropdown-item" 
                                                        href="{{ route('assignment.submissions', ['classId' => $schoolClass->id, 'assignment' => $assignment->id]) }}">
                                                            <i class="fas fa-eye me-2"></i>Ver Entregas
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4 text-muted">
                                <i class="fas fa-clipboard-list fa-2x mb-3"></i>
                                <p>Nenhum trabalho ativo no momento.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>