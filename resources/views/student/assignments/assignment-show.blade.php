<x-app-layout>
    @slot('title', $assignment->title)

    <x-student-header/>
    
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <!-- Header -->
                <div class="text-center mb-5">
                    <h1 class="display-6 fw-bold text-primary mb-3">{{ $assignment->title }}</h1>
                    <div class="d-flex flex-wrap justify-content-center gap-3">
                        <span class="badge bg-primary fs-6">
                            <i class="fas fa-chalkboard me-1"></i>
                            {{ $assignment->schoolClass->name }}
                        </span>
                        <span class="badge bg-info fs-6">
                            <i class="fas fa-book me-1"></i>
                            {{ $assignment->subject->name }}
                        </span>
                        <span class="badge bg-secondary fs-6">
                            <i class="fas fa-chalkboard-teacher me-1"></i>
                            {{ $assignment->teacher->user->name ?? $assignment->teacher->name }}
                        </span>
                    </div>
                </div>

                <!-- Card de Informações -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Informações do Trabalho
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-4">{{ $assignment->description }}</p>
                        
                        <div class="row text-center">
                            <div class="col-md-4 mb-3">
                                <div class="fw-bold text-primary fs-4">
                                    {{ $assignment->due_date->format('d/m/Y') }}
                                </div>
                                <small class="text-muted">Data de Entrega</small>
                                @if($assignment->due_time)
                                    <br>
                                    <small class="text-muted">até {{ $assignment->due_time }}</small>
                                @endif
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="fw-bold text-info fs-4">{{ $assignment->max_points }}</div>
                                <small class="text-muted">Pontuação Máxima</small>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="fw-bold text-{{ $assignment->is_expired ? 'danger' : 'success' }} fs-4">
                                    {{ $assignment->is_expired ? 'Expirado' : 'Ativo' }}
                                </div>
                                <small class="text-muted">Status</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Status da Entrega -->
                @if($studentSubmission)
                    <div class="card shadow-sm border-success mb-4">
                        <div class="card-header bg-success text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-check-circle me-2"></i>
                                Trabalho Entregue
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-2">
                                        <strong>Data de Entrega:</strong><br>
                                        {{ $studentSubmission->submitted_at->format('d/m/Y H:i') }}
                                    </p>
                                    @if($studentSubmission->comments)
                                        <p class="mb-2">
                                            <strong>Seus Comentários:</strong><br>
                                            {{ $studentSubmission->comments }}
                                        </p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    @if($studentSubmission->is_graded)
                                        <div class="alert alert-info">
                                            <h6 class="alert-heading">
                                                <i class="fas fa-star me-1"></i>
                                                Avaliado
                                            </h6>
                                            <p class="mb-1">
                                                <strong>Nota:</strong> 
                                                {{ $studentSubmission->points }}/{{ $assignment->max_points }}
                                            </p>
                                            <p class="mb-0">
                                                <strong>Porcentagem:</strong> 
                                                {{ number_format($studentSubmission->grade_percentage, 1) }}%
                                            </p>
                                            @if($studentSubmission->feedback)
                                                <hr>
                                                <p class="mb-0">
                                                    <strong>Feedback do Professor:</strong><br>
                                                    {{ $studentSubmission->feedback }}
                                                </p>
                                            @endif
                                        </div>
                                    @else
                                        <div class="alert alert-warning">
                                            <i class="fas fa-clock me-1"></i>
                                            Aguardando avaliação do professor
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @elseif($canSubmit)
                    <div class="card shadow-sm border-primary">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-paper-plane me-2"></i>
                                Entregar Trabalho
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <p class="mb-4">Você ainda não entregou este trabalho.</p>
                            <a href="{{ route('student.assignment.submit', $assignment->id) }}" 
                               class="btn btn-success btn-lg">
                                <i class="fas fa-upload me-2"></i>
                                Fazer Entrega
                            </a>
                        </div>
                    </div>
                @else
                    <div class="card shadow-sm border-danger">
                        <div class="card-header bg-danger text-white">
                            <h5 class="mb-0">
                                <i class="fas fa-times-circle me-2"></i>
                                Prazo Expirado
                            </h5>
                        </div>
                        <div class="card-body text-center">
                            <p class="mb-0">O prazo para entrega deste trabalho expirou.</p>
                        </div>
                    </div>
                @endif

                <!-- Botões de Navegação -->
                <div class="d-flex justify-content-between mt-4">
                    <a href="{{ route('student.assignments') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        Voltar para Trabalhos
                    </a>
                    
                    @if($studentSubmission && $studentSubmission->file_path)
                        <a href="#" class="btn btn-outline-primary">
                            <i class="fas fa-download me-2"></i>
                            Baixar Arquivo
                        </a>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-app-layout>