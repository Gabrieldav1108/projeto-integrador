<x-app-layout>
    @slot('title', $subject->name)
    <x-student-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Matéria: {{ $subject->name }}</h2>
            <a href="{{ route('student.home') }}" class="btn btn-secondary">
                ← Voltar
            </a>
        </div>

        <div class="row rounded p-4 align-items-stretch mt-3">
            <!-- Informações sobre a matéria -->
            <div class="col-12 col-md-6 mb-4 mb-md-0 d-flex flex-column">
                <h3 class="mb-3">Informações sobre a matéria</h3>

                <div class="border rounded p-4 bg-white" style="min-height: 300px;">
                    @if($mainTeacher)
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="fas fa-chalkboard-teacher fa-3x text-primary"></i>
                            </div>
                            <strong class="fs-5">Professor: {{ $mainTeacher->name }}</strong>
                        </div>
                        
                        <div class="mb-3">
                            <strong>📧 Email:</strong> 
                            <span class="ms-2">{{ $mainTeacher->email }}</span>
                        </div>
                        
                        @if($mainTeacher->phone)
                        <div class="mb-3">
                            <strong>📞 Telefone:</strong> 
                            <span class="ms-2">{{ $mainTeacher->phone }}</span>
                        </div>
                        @endif
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-user-slash fa-3x mb-3"></i>
                            <p>Nenhum professor vinculado a esta matéria.</p>
                        </div>
                    @endif

                    <!-- Descrição da matéria -->
                    <div class="mt-4 pt-3 border-top">
                        <strong>📝 Descrição:</strong>
                        <p class="mt-2">{{ $subject->description ?? 'Sem descrição disponível.' }}</p>
                    </div>
                </div>
            </div>

            <!-- Avisos do professor -->
            <div class="col-12 col-md-6 d-flex flex-column">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                    <h3 class="mb-2 mb-md-0">
                        Avisos do professor 
                    </h3>
                    <a href="{{ route('grades.subject', $subject->id) }}" class="btn btn-primary w-md-auto">Notas</a>
                </div>

                <div class="border rounded p-3 bg-light h-100">

                    @if($classInformations->count() > 0)
                        <ul class="list-group">
                            @foreach($classInformations as $info)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="flex-grow-1">
                                        <strong>{{ $info->content }}</strong>
                                        @if($info->date || $info->time)
                                            <br>
                                            <small class="text-muted">
                                                @if($info->date)
                                                    📅 {{ \Carbon\Carbon::parse($info->date)->format('d/m/Y') }}
                                                @endif
                                                @if($info->time)
                                                    ⏰ {{ \Carbon\Carbon::parse($info->time)->format('H:i') }}
                                                @endif
                                            </small>
                                        @endif
                                        @if($info->schoolClass)
                                            <br>
                                            <small class="text-muted">
                                                Turma: {{ $info->schoolClass->name }}
                                            </small>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-bell-slash fa-2x mb-3"></i>
                            <p>Nenhum aviso disponível para esta matéria.</p>
                        </div>
                    @endif
                </div>
            </div>

        <!-- Trabalhos Disponíveis -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-success text-white py-3">
                <h4 class="mb-0">
                    <i class="fas fa-tasks me-2"></i>
                    Trabalhos Disponíveis para Entrega
                </h4>
            </div>
            <div class="card-body p-0">
                <div class="p-3">
                    @php
                        // Buscar trabalhos ativos das turmas do aluno nesta matéria
                        $user = Auth::user();
                        $classIds = $user->schoolClasses->pluck('id');
                        
                        
                        $assignments = \App\Models\Assignment::whereIn('class_id', $classIds)
                            ->where('subject_id', $subject->id)
                            ->with(['schoolClass', 'teacher.user'])
                            ->active()
                            ->orderBy('due_date', 'asc')
                            ->get();

                        foreach ($assignments as $assignment) {
                            logger(' - ' . $assignment->title . ' (Turma: ' . $assignment->class_id . ', Matéria: ' . $assignment->subject_id . ')');
                        }

                        $assignments = $assignments->map(function($assignment) use ($user) {
                            $assignment->student_submission = $assignment->getStudentSubmission($user->id);
                            $assignment->can_submit = !$assignment->is_expired && !$assignment->hasStudentSubmission($user->id);
                            return $assignment;
                        });
                    @endphp

                    @if($assignments->count() > 0)
                        <div class="row g-3">
                            @foreach($assignments as $assignment)
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="card-header bg-light py-3">
                                            <h6 class="fw-bold mb-0 text-truncate">{{ $assignment->title }}</h6>
                                            <small class="text-muted">Turma: {{ $assignment->schoolClass->name }}</small>
                                        </div>
                                        <div class="card-body">
                                            <p class="card-text small text-muted mb-3">
                                                {{ Str::limit($assignment->description, 100) }}
                                            </p>
                                            
                                            <div class="mb-3">
                                                <span class="badge bg-primary px-3 py-2 mb-2 d-inline-block">
                                                    <i class="fas fa-calendar me-1"></i>
                                                    {{ $assignment->due_date->format('d/m/Y') }}
                                                    @if($assignment->due_time)
                                                        às {{ $assignment->due_time }}
                                                    @endif
                                                </span>
                                                <span class="badge bg-info px-3 py-2 mb-2 d-inline-block">
                                                    <i class="fas fa-star me-1"></i>
                                                    {{ $assignment->max_points }} pts
                                                </span>
                                            </div>

                                            <!-- Status da entrega -->
                                            @if($assignment->student_submission)
                                                <div class="alert alert-success py-2 mb-3">
                                                    <i class="fas fa-check-circle me-2"></i>
                                                    <strong>Entregue em:</strong> 
                                                    {{ \Carbon\Carbon::parse($assignment->student_submission->submitted_at)->format('d/m/Y H:i') }}
                                                </div>
                                            @elseif($assignment->is_expired)
                                                <div class="alert alert-danger py-2 mb-3">
                                                    <i class="fas fa-clock me-2"></i>
                                                    <strong>Prazo expirado</strong>
                                                </div>
                                            @else
                                                <div class="alert alert-warning py-2 mb-3">
                                                    <i class="fas fa-exclamation-circle me-2"></i>
                                                    <strong>Aguardando entrega</strong>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="card-footer bg-white border-0 pt-0">
                                            <div class="d-grid gap-2">
                                                @if($assignment->can_submit)
                                                    <a href="{{ route('student.assignment.submit', $assignment->id) }}" 
                                                       class="btn btn-success btn-sm">
                                                        <i class="fas fa-paper-plane me-1"></i>
                                                        Entregar Trabalho
                                                    </a>
                                                @endif
                                                
                                                <a href="{{ route('student.assignment.show', $assignment->id) }}" 
                                                   class="btn btn-outline-primary btn-sm">
                                                    <i class="fas fa-eye me-1"></i>
                                                    Ver Detalhes
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                            <p class="mb-2">Nenhum trabalho disponível no momento</p>
                            <p class="small">Novos trabalhos aparecerão aqui quando forem criados pelo professor.</p>
                        </div>
                    @endif
                </div>
            </div>
            <div class="card-footer bg-light">
                @php
                    $pendingAssignments = $assignments->where('can_submit', true)->count();
                    $submittedAssignments = $assignments->where('student_submission', '!=', null)->count();
                    $expiredAssignments = $assignments->where('is_expired', true)->where('student_submission', null)->count();
                @endphp
                <small class="text-muted">
                    <i class="fas fa-info-circle me-1"></i>
                    Resumo: {{ $pendingAssignments }} pendentes • 
                    {{ $submittedAssignments }} entregues • 
                    {{ $expiredAssignments }} expirados
                </small>
            </div>
        </div>
    </div>
</div>

        <!-- Informações adicionais -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card bg-light">
                    <div class="card-body">
                        <h5 class="card-title">📊 Resumo</h5>
                        <div class="row">
                            <div class="col-md-3">
                                <strong>🏫 Suas Turmas:</strong> 
                                {{ $userClasses->count() }}
                            </div>
                            <div class="col-md-3">
                                <strong>👨‍🏫 Professor:</strong> 
                                {{ $mainTeacher ? $mainTeacher->name : 'Não atribuído' }}
                            </div>
                            <div class="col-md-3">
                                <strong>📢 Avisos:</strong> 
                                {{ $classInformations->count() }}
                            </div>
                            <div class="col-md-3">
                                <strong>📝 Trabalhos:</strong> 
                                {{ $assignments->count() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <style>
        .card {
            border-radius: 1rem;
        }
        .card-header {
            border-radius: 1rem 1rem 0 0 !important;
        }
        .badge {
            font-size: 0.75em;
            border-radius: 0.5rem;
        }
        .btn-sm {
            border-radius: 0.5rem;
        }
        .alert {
            border-radius: 0.5rem;
            margin-bottom: 0;
        }
    </style>
</x-app-layout>