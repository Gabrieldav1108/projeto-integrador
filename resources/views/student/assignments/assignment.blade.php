<x-app-layout>
    @slot('title', 'Meus Trabalhos')

    <x-student-header/>
    
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <!-- Header -->
                <div class="text-center mb-5">
                    <h1 class="display-6 fw-bold text-primary mb-3">
                        <i class="fas fa-tasks me-2"></i>
                        Meus Trabalhos
                    </h1>
                    <p class="text-muted fs-5">Trabalhos disponíveis para entrega</p>
                </div>

                @if($assignments->count() > 0)
                    <div class="row g-4">
                        @foreach($assignments as $assignment)
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="card shadow-sm border-0 h-100">
                                    <div class="card-header bg-{{ $assignment->can_submit ? 'primary' : 'secondary' }} text-white py-3">
                                        <h6 class="mb-0 text-truncate">{{ $assignment->title }}</h6>
                                    </div>
                                    <div class="card-body">
                                        <p class="text-muted small mb-3">
                                            {{ Str::limit($assignment->description, 100) }}
                                        </p>
                                        
                                        <div class="mb-3">
                                            <small class="text-muted d-block">
                                                <i class="fas fa-chalkboard me-1"></i>
                                                {{ $assignment->schoolClass->name }}
                                            </small>
                                            <small class="text-muted d-block">
                                                <i class="fas fa-book me-1"></i>
                                                {{ $assignment->subject->name }}
                                            </small>
                                            <small class="text-muted d-block">
                                                <i class="fas fa-chalkboard-teacher me-1"></i>
                                                {{ $assignment->teacher->user->name ?? $assignment->teacher->name }}
                                            </small>
                                        </div>

                                        <div class="d-flex flex-wrap gap-1 mb-3">
                                            <span class="badge bg-primary">
                                                <i class="fas fa-calendar me-1"></i>
                                                {{ $assignment->due_date->format('d/m/Y') }}
                                            </span>
                                            <span class="badge bg-info">
                                                <i class="fas fa-star me-1"></i>
                                                {{ $assignment->max_points }} pts
                                            </span>
                                        </div>

                                        @if($assignment->student_submission)
                                            <div class="alert alert-success py-2 mb-3">
                                                <small>
                                                    <i class="fas fa-check me-1"></i>
                                                    Entregue em: {{ $assignment->student_submission->submitted_at->format('d/m/Y H:i') }}
                                                </small>
                                                @if($assignment->student_submission->is_graded)
                                                    <br>
                                                    <small>
                                                        <strong>Nota: {{ $assignment->student_submission->points }}/{{ $assignment->max_points }}</strong>
                                                    </small>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer bg-light">
                                        <div class="d-grid gap-2">
                                            <a href="{{ route('student.assignment.show', $assignment->id) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>Ver Detalhes
                                            </a>
                                            
                                            @if($assignment->can_submit)
                                                <a href="{{ route('student.assignment.submit', $assignment->id) }}" 
                                                   class="btn btn-success btn-sm">
                                                    <i class="fas fa-paper-plane me-1"></i>Entregar
                                                </a>
                                            @elseif($assignment->isExpired())
                                                <button class="btn btn-danger btn-sm" disabled>
                                                    <i class="fas fa-clock me-1"></i>Expirado
                                                </button>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-clipboard-list fa-3x mb-3"></i>
                        <h5>Nenhum trabalho disponível</h5>
                        <p class="mb-0">Não há trabalhos ativos no momento.</p>
                    </div>
                @endif

                <!-- Botão Voltar -->
                <div class="text-center mt-4">
                    <a href="{{ route('student.home') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Voltar para o Início
                    </a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>