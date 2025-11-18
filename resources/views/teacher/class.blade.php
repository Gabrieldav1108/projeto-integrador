<x-app-layout>
    @slot('title', "Turma - {$schoolClass->name}")
    
    <x-teacher-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <div class="text-center mb-4">
            <h1 class="fw-bold text-primary">Turma: {{ $schoolClass->name }}</h1>
            <p class="text-muted">Gerencie alunos, avisos e trabalhos da turma</p>
        </div>

        <div class="row rounded p-4 align-items-stretch g-4">
            
            <!-- Alunos matriculados -->
            <div class="col-12 col-lg-4 d-flex flex-column">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0">
                            <i class="fas fa-users me-2"></i>
                            Alunos Matriculados
                        </h4>
                    </div>
                    <div class="card-body p-0">
                        <div class="p-3" style="max-height: 450px; overflow-y: auto;">
                            @if($schoolClass->students->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($schoolClass->students as $userStudent)
                                        <div class="list-group-item d-flex justify-content-between align-items-center py-3">
                                            <div class="d-flex align-items-center">
                                                <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                     style="width: 40px; height: 40px;">
                                                    <i class="fas fa-user text-white"></i>
                                                </div>
                                                <div>
                                                    <strong class="d-block">{{ $userStudent->name }}</strong>
                                                    <small class="text-muted">{{ $userStudent->email }}</small>
                                                </div>
                                            </div>
                                            <a href="{{ route('teacher.students.show', $userStudent->id) }}" 
                                            class="btn btn-outline-primary btn-sm">
                                                Ver
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-user-slash fa-3x mb-3"></i>
                                    <p class="mb-0">Nenhum aluno matriculado</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Total: {{ $schoolClass->students->count() }} alunos
                        </small>
                    </div>
                </div>
            </div>

            <!-- Avisos -->
            <div class="col-12 col-lg-4 d-flex flex-column">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-info text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-bullhorn me-2"></i>
                                Avisos
                            </h4>
                            <a href="{{ route('teacher.class.information.add', $schoolClass->id) }}" 
                               class="btn btn-light btn-sm">
                                <i class="fas fa-plus me-1"></i>Novo
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="p-3" style="max-height: 450px; overflow-y: auto;">
                            @if($informations->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($informations as $info)
                                        <div class="list-group-item py-3">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <div class="flex-grow-1 me-3">
                                                    <h6 class="fw-bold text-dark mb-2">{{ $info->content ?? 'Sem conteúdo' }}</h6>
                                                    <div class="d-flex flex-wrap gap-3">
                                                        @if($info->date)
                                                            <small class="text-muted">
                                                                <i class="fas fa-calendar me-1"></i>
                                                                {{ \Carbon\Carbon::parse($info->date)->format('d/m/Y') }}
                                                            </small>
                                                        @endif
                                                        @if($info->time)
                                                            <small class="text-muted">
                                                                <i class="fas fa-clock me-1"></i>
                                                                {{ \Carbon\Carbon::parse($info->time)->format('H:i') }}
                                                            </small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('teacher.class.information.edit', ['classId' => $schoolClass->id, 'information' => $info->id]) }}" 
                                                class="btn btn-outline-primary btn-sm w-50 text-center">
                                                    <i class="fas fa-edit me-1"></i>Editar
                                                </a>
                                                <button type="button" 
                                                        class="btn btn-outline-danger btn-sm w-50 text-center"
                                                        onclick="if(confirm('Tem certeza que deseja excluir este aviso?')) { document.getElementById('delete-form-{{ $info->id }}').submit(); }">
                                                    <i class="fas fa-trash me-1"></i>Excluir
                                                </button>
                                            </div>

                                            <form id="delete-form-{{ $info->id }}" 
                                                action="{{ route('teacher.class.information.destroy', ['classId' => $schoolClass->id, 'information' => $info->id]) }}" 
                                                method="POST" class="d-none">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-bell-slash fa-3x mb-3"></i>
                                    <p class="mb-2">Nenhum aviso cadastrado</p>
                                    <a href="{{ route('teacher.class.information.add', $schoolClass->id) }}" 
                                       class="btn btn-info btn-sm">
                                        Criar Primeiro Aviso
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            {{ $informations->count() }} avisos ativos
                        </small>
                    </div>
                </div>
            </div>

            <!-- Trabalhos Entregáveis -->
            <div class="col-12 col-md-4 d-flex flex-column">
                <div class="card shadow-sm border-0 h-100">
                    <div class="card-header bg-success text-white py-3">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4 class="mb-0">
                                <i class="fas fa-tasks me-2"></i>
                                Trabalhos - {{ $teacher->subject->name ?? 'Minha Matéria' }}
                            </h4>
                            <a href="{{ route('assignment.create', $schoolClass->id) }}" 
                            class="btn btn-light btn-sm">
                                <i class="fas fa-plus me-1"></i>Novo
                            </a>
                        </div>
                    </div>
                    <div class="card-body p-0">
                        <div class="p-3" style="max-height: 450px; overflow-y: auto;">
                            @php
                                // Buscar trabalhos ativos desta turma APENAS da matéria do professor
                                $user = Auth::user();
                                $teacher = \App\Models\Teacher::where('user_id', $user->id)->first();
                                
                                $assignments = \App\Models\Assignment::where('class_id', $schoolClass->id)
                                    ->where('subject_id', $teacher->subject_id) // ← FILTRAR PELA MATÉRIA DO PROFESSOR
                                    ->active()
                                    ->withCount('submissions')
                                    ->orderBy('due_date', 'asc')
                                    ->get();
                            @endphp

                            @if($assignments->count() > 0)
                                <div class="list-group list-group-flush">
                                    @foreach($assignments as $assignment)
                                        <div class="list-group-item py-3">
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="flex-grow-1 me-3">
                                                    <h6 class="fw-bold text-dark mb-2">{{ $assignment->title }}</h6>
                                                    <p class="text-muted mb-3 small">
                                                        {{ Str::limit($assignment->description, 120) }}
                                                    </p>
                                                    <div class="d-flex flex-wrap gap-2 mb-2">
                                                        <span class="badge bg-primary px-3 py-2">
                                                            <i class="fas fa-calendar me-1"></i>
                                                            {{ $assignment->due_date->format('d/m/Y') }}
                                                            @if($assignment->due_time)
                                                                às {{ $assignment->due_time }}
                                                            @endif
                                                        </span>
                                                        <span class="badge bg-info px-3 py-2">
                                                            <i class="fas fa-star me-1"></i>
                                                            {{ $assignment->max_points }} pts
                                                        </span>
                                                        <span class="badge bg-{{ $assignment->submissions_count > 0 ? 'success' : 'secondary' }} px-3 py-2">
                                                            <i class="fas fa-paper-plane me-1"></i>
                                                            {{ $assignment->submissions_count }} entregas
                                                        </span>
                                                    </div>
                                                    <!-- Mostrar a matéria do trabalho -->
                                                    <small class="text-muted d-block mb-2">
                                                        <i class="fas fa-book me-1"></i>
                                                        {{ $assignment->subject->name ?? 'Matéria' }}
                                                    </small>
                                                    @if($assignment->is_expired)
                                                        <span class="badge bg-danger px-3 py-2">
                                                            <i class="fas fa-clock me-1"></i>Expirado
                                                        </span>
                                                    @else
                                                        <span class="badge bg-success px-3 py-2">
                                                            <i class="fas fa-check me-1"></i>Ativo
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="d-flex gap-2">
                                                <a href="{{ route('assignment.submissions', ['classId' => $schoolClass->id, 'assignmentId' => $assignment->id]) }}" 
                                                class="btn btn-outline-primary btn-sm flex-fill">
                                                    <i class="fas fa-eye me-1"></i>Ver Entregas
                                                </a>
                                                <button class="btn btn-outline-secondary btn-sm" 
                                                        data-bs-toggle="tooltip" 
                                                        title="Total de alunos: {{ $schoolClass->students->count() }} | Entregas: {{ $assignment->submissions_count }} | Matéria: {{ $assignment->subject->name ?? 'Matéria' }}">
                                                    <i class="fas fa-chart-bar"></i>
                                                </button>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="text-center py-5 text-muted">
                                    <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                                    <p class="mb-2">Nenhum trabalho criado para {{ $teacher->subject->name ?? 'sua matéria' }}</p>
                                    <a href="{{ route('assignment.create', $schoolClass->id) }}" 
                                    class="btn btn-success btn-sm">
                                        Criar Primeiro Trabalho
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="card-footer bg-light">
                        @php
                            $activeAssignments = $assignments->where('is_expired', false)->count();
                            $totalSubmissions = $assignments->sum('submissions_count');
                        @endphp
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            {{ $activeAssignments }} trabalhos de {{ $teacher->subject->name ?? 'sua matéria' }} • {{ $totalSubmissions }} entregas
                        </small>
                    </div>
                </div>
            </div>

        <!-- Botão Voltar -->
        <div class="text-center mt-4">
            <a href="{{ route('teacher.home') }}" class="btn btn-secondary btn-lg">
                <i class="fas fa-arrow-left me-2"></i>
                Voltar para Dashboard
            </a>
        </div>
    </section>

    <style>
        .card {
            border-radius: 1rem;
        }
        .card-header {
            border-radius: 1rem 1rem 0 0 !important;
        }
        .list-group-item {
            border: none;
            border-bottom: 1px solid #e9ecef;
        }
        .list-group-item:last-child {
            border-bottom: none;
        }
        .badge {
            font-size: 0.75em;
            border-radius: 0.5rem;
        }
        .btn-sm {
            border-radius: 0.5rem;
        }
    </style>

    <script>
        // Inicializar tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            })
        });
    </script>
</x-app-layout>