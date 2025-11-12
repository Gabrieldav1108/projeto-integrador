<x-app-layout>
    @slot('title', 'Entregar Trabalho - ' . $assignment->title)

    <x-student-header/>
    
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <!-- Header -->
                <div class="text-center mb-5">
                    <h1 class="display-6 fw-bold text-primary mb-3">
                        <i class="fas fa-paper-plane me-2"></i>
                        Entregar Trabalho
                    </h1>
                    <h2 class="h4 text-muted">{{ $assignment->title }}</h2>
                </div>

                <!-- Informações do Trabalho -->
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">Informações do Trabalho</h5>
                    </div>
                    <div class="card-body">
                        <p><strong>Descrição:</strong> {{ $assignment->description }}</p>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Data de Entrega:</strong> {{ $assignment->due_date->format('d/m/Y') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Pontuação:</strong> {{ $assignment->max_points }} pontos</p>
                            </div>
                        </div>
                        <div class="alert alert-info">
                            <i class="fas fa-info-circle me-2"></i>
                            Formatos aceitos: PDF, Word, TXT, ZIP, RAR, JPG, PNG (até 10MB)
                        </div>
                    </div>
                </div>

                <!-- Formulário de Entrega -->
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">Formulário de Entrega</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('student.assignment.submit.store', $assignment->id) }}" 
                              enctype="multipart/form-data">
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

                            <div class="mb-4">
                                <label class="form-label fw-bold">Arquivo do Trabalho *</label>
                                <input type="file" class="form-control" name="assignment_file" required>
                                <small class="text-muted">Selecione o arquivo do seu trabalho</small>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold">Comentários (opcional)</label>
                                <textarea class="form-control" name="comments" rows="4" 
                                          placeholder="Digite algum comentário sobre sua entrega (opcional)"></textarea>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('student.assignment.show', $assignment->id) }}" 
                                   class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-2"></i>
                                    Cancelar
                                </a>
                                <button type="submit" class="btn btn-success">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    Entregar Trabalho
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>