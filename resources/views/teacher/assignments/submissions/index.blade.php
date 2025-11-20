<x-app-layout>
    @slot('title', "Entregas - {$assignment->title}")

    <x-teacher-header/>
    
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <!-- Header -->
                <div class="text-center mb-5">
                    <h1 class="display-6 fw-bold text-primary mb-3">
                        <i class="fas fa-inbox me-2"></i>
                        Entregas do Trabalho
                    </h1>
                    <h2 class="h4 text-muted mb-4">{{ $assignment->title }}</h2>
                </div>

                <!-- Informações do Trabalho -->
                <div class="card shadow-sm mb-5">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="fas fa-info-circle me-2 text-primary"></i>
                            Informações do Trabalho
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <p class="mb-3"><strong>Descrição:</strong> {{ $assignment->description }}</p>
                                <div class="d-flex flex-wrap gap-4">
                                    <span class="badge bg-primary fs-6 px-3 py-2">
                                        <i class="fas fa-calendar me-1"></i>
                                        Entrega: {{ $assignment->due_date->format('d/m/Y') }}
                                        @if($assignment->due_time)
                                            às {{ $assignment->due_time }}
                                        @endif
                                    </span>
                                    <span class="badge bg-info fs-6 px-3 py-2">
                                        <i class="fas fa-star me-1"></i>
                                        {{ $assignment->max_points }} pontos
                                    </span>
                                    @if($assignment->is_expired)
                                        <span class="badge bg-danger fs-6 px-3 py-2">
                                            <i class="fas fa-clock me-1"></i>Expirado
                                        </span>
                                    @else
                                        <span class="badge bg-success fs-6 px-3 py-2">
                                            <i class="fas fa-check me-1"></i>Ativo
                                        </span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4 text-md-end">
                                <div class="mt-3 mt-md-0">
                                    <a href="{{ route('teacher.class.informations', $schoolClass->id) }}" 
                                    class="btn btn-outline-secondary me-2">
                                        <i class="fas fa-arrow-left me-1"></i>Voltar
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Lista de Entregas -->
                <div class="card shadow-sm">
                    <div class="card-header bg-white">
                        <h5 class="mb-0">
                            <i class="fas fa-list-check me-2 text-success"></i>
                            Entregas dos Alunos
                        </h5>
                    </div>
                    <div class="card-body p-0">
                        @if($assignment->submissions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover mb-0">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="ps-4">Aluno</th>
                                            <th>Data de Entrega</th>
                                            <th>Comentários</th>
                                            <th class="text-center">Nota</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Ações</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($assignment->submissions as $submission)
                                            <tr>
                                                <td class="ps-4">
                                                    <div class="d-flex align-items-center">
                                                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                                             style="width: 40px; height: 40px;">
                                                            <i class="fas fa-user text-white"></i>
                                                        </div>
                                                        <div>
                                                            <strong class="d-block">{{ $submission->student->name }}</strong>
                                                            <small class="text-muted">{{ $submission->student->email }}</small>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <small class="text-muted">
                                                        {{ $submission->submitted_at->format('d/m/Y H:i') }}
                                                    </small>
                                                    <br>
                                                    <small class="text-muted">
                                                        {{ $submission->submitted_at->diffForHumans() }}
                                                    </small>
                                                </td>
                                                <td>
                                                    @if($submission->comments)
                                                        <span class="text-muted small">
                                                            {{ Str::limit($submission->comments, 50) }}
                                                        </span>
                                                    @else
                                                        <span class="text-muted small">Sem comentários</span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($submission->is_graded)
                                                        <span class="badge bg-success fs-6 px-3 py-2">
                                                            {{ $submission->points }}/{{ $assignment->max_points }}
                                                        </span>
                                                        <br>
                                                        <small class="text-muted">
                                                            {{ number_format($submission->grade_percentage, 1) }}%
                                                        </small>
                                                    @else
                                                        <span class="badge bg-secondary fs-6 px-3 py-2">
                                                            Não avaliado
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if($submission->is_graded)
                                                        <span class="badge bg-success">
                                                            <i class="fas fa-check me-1"></i>Avaliado
                                                        </span>
                                                    @else
                                                        <span class="badge bg-warning text-dark">
                                                            <i class="fas fa-clock me-1"></i>Pendente
                                                        </span>
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    <div class="btn-group" role="group">
                                                        <!-- Botão Avaliar/Ver Detalhes -->
                                                        <button type="button" 
                                                                class="btn btn-outline-primary btn-sm"
                                                                data-bs-toggle="modal" 
                                                                data-bs-target="#submissionModal{{ $submission->id }}">
                                                            <i class="fas fa-{{ $submission->is_graded ? 'eye' : 'edit' }} me-1"></i>
                                                            {{ $submission->is_graded ? 'Ver' : 'Avaliar' }}
                                                        </button>
                                                        
                                                        <!-- NOVO BOTÃO: Ir para tela de notas do aluno -->
                                                        <a href="{{ route('teacher.students.show', $submission->student->id) }}?assignment_id={{ $assignment->id }}"
                                                        class="btn btn-outline-info btn-sm"
                                                        title="Ver perfil completo do aluno e adicionar notas"
                                                        data-bs-toggle="tooltip">
                                                            <i class="fas fa-star me-1"></i>Notas
                                                        </a>
                                                        
                                                        @if($submission->file_path)
                                                            <a href="{{ route('assignment.submission.download', [
                                                                'classId' => $schoolClass->id, 
                                                                'assignment' => $assignment->id, 
                                                                'submission' => $submission->id
                                                            ]) }}" 
                                                            class="btn btn-outline-success btn-sm"
                                                            title="Download do arquivo">
                                                                <i class="fas fa-download">Download</i>
                                                            </a>
                                                        @else
                                                            <button class="btn btn-outline-secondary btn-sm" disabled
                                                                    title="Sem arquivo para download">
                                                                <i class="fas fa-download"></i>
                                                            </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>

                                            <!-- Modal de Avaliação -->
                                            <div class="modal fade" id="submissionModal{{ $submission->id }}" tabindex="-1">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title">
                                                                Avaliar Entrega - {{ $submission->student->name }}
                                                            </h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                        </div>
                                                        <form action="{{ route('assignment.submission.grade', [
                                                                        'classId' => $schoolClass->id, 
                                                                        'assignment' => $assignment->id, 
                                                                        'submission' => $submission->id
                                                                        ]) }}" 
                                                              method="POST">
                                                            @csrf
                                                            <div class="modal-body">
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Aluno</label>
                                                                    <p class="form-control-plaintext">{{ $submission->student->name }} ({{ $submission->student->email }})</p>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Data de Entrega</label>
                                                                    <p class="form-control-plaintext">
                                                                        {{ $submission->submitted_at->format('d/m/Y H:i') }}
                                                                        ({{ $submission->submitted_at->diffForHumans() }})
                                                                    </p>
                                                                </div>
                                                                
                                                                @if($submission->comments)
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Comentários do Aluno</label>
                                                                    <p class="form-control-plaintext border rounded p-2 bg-light">
                                                                        {{ $submission->comments }}
                                                                    </p>
                                                                </div>
                                                                @endif
                                                                
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Nota</label>
                                                                    <input type="number" 
                                                                           class="form-control" 
                                                                           name="points" 
                                                                           value="{{ $submission->points ?? 0 }}"
                                                                           min="0" 
                                                                           max="{{ $assignment->max_points }}"
                                                                           step="0.1"
                                                                           required>
                                                                    <small class="text-muted">
                                                                        Pontuação máxima: {{ $assignment->max_points }} pontos
                                                                    </small>
                                                                </div>
                                                                
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Feedback</label>
                                                                    <textarea class="form-control" 
                                                                              name="feedback" 
                                                                              rows="4"
                                                                              placeholder="Digite seu feedback para o aluno...">{{ $submission->feedback ?? '' }}</textarea>
                                                                </div>

                                                                <!-- Informações do arquivo -->
                                                                @if($submission->file_path)
                                                                <div class="mb-3">
                                                                    <label class="form-label fw-bold">Arquivo Entregue</label>
                                                                    <div class="d-flex align-items-center">
                                                                        <a href="{{ route('assignment.submission.download', [
                                                                            'classId' => $schoolClass->id, 
                                                                            'assignment' => $assignment->id, 
                                                                            'submission' => $submission->id
                                                                        ]) }}" 
                                                                           class="btn btn-outline-primary btn-sm me-2">
                                                                            <i class="fas fa-download me-1"></i>
                                                                            Baixar Arquivo
                                                                        </a>
                                                                        <small class="text-muted">
                                                                            {{ basename($submission->file_path) }}
                                                                        </small>
                                                                    </div>
                                                                </div>
                                                                @endif
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                                                <button type="submit" class="btn btn-success">
                                                                    <i class="fas fa-save me-1"></i>
                                                                    {{ $submission->is_graded ? 'Atualizar Avaliação' : 'Salvar Avaliação' }}
                                                                </button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5 text-muted">
                                <i class="fas fa-inbox fa-3x mb-3"></i>
                                <h5>Nenhuma entrega ainda</h5>
                                <p class="mb-0">Os alunos ainda não enviaram trabalhos para esta atividade.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Alunos que não entregaram -->
                @if($submittedCount < $totalStudents)
                    <div class="card shadow-sm mt-4 border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fas fa-user-clock me-2"></i>
                                Alunos Pendentes ({{ $totalStudents - $submittedCount }})
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @php
                                    $submittedStudentIds = $assignment->submissions->pluck('student_id')->toArray();
                                    $pendingStudents = $schoolClass->students->whereNotIn('id', $submittedStudentIds);
                                @endphp
                                
                                @foreach($pendingStudents as $student)
                                    <div class="col-md-6 col-lg-4 mb-2">
                                        <div class="d-flex align-items-center p-2 border rounded">
                                            <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-2" 
                                                 style="width: 35px; height: 35px;">
                                                <i class="fas fa-user text-white"></i>
                                            </div>
                                            <div class="flex-grow-1">
                                                <strong class="d-block small">{{ $student->name }}</strong>
                                            </div>
                                            <span class="badge bg-danger">Pendente</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <style>
        .table th {
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }
        .badge {
            border-radius: 0.5rem;
        }
        .card {
            border-radius: 1rem;
        }
    </style>
</x-app-layout>