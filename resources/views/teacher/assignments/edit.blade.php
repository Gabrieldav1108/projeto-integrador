<x-app-layout>
    @slot('title', "Editar Trabalho - {$assignment->title}")

    <x-teacher-header/>
    
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-warning text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-edit me-2"></i>
                            Editar Trabalho
                        </h4>
                    </div>
                    <div class="card-body">
                        <form action="{{ route('assignment.update', ['classId' => $schoolClass->id, 'assignment' => $assignment->id]) }}" 
                              method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="title" class="form-label">Título do Trabalho *</label>
                                <input type="text" class="form-control" id="title" name="title" 
                                       value="{{ old('title', $assignment->title) }}" required>
                            </div>

                            <div class="mb-3">
                                <label for="description" class="form-label">Descrição *</label>
                                <textarea class="form-control" id="description" name="description" 
                                          rows="4" required>{{ old('description', $assignment->description) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="due_date" class="form-label">Data de Entrega *</label>
                                    <input type="date" class="form-control" id="due_date" name="due_date" 
                                           value="{{ old('due_date', $assignment->due_date->format('Y-m-d')) }}" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="due_time" class="form-label">Horário de Entrega (opcional)</label>
                                    <input type="time" class="form-control" id="due_time" name="due_time" 
                                           value="{{ old('due_time', $assignment->due_time) }}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="max_points" class="form-label">Pontuação Máxima *</label>
                                <input type="number" class="form-control" id="max_points" name="max_points" 
                                       value="{{ old('max_points', $assignment->max_points) }}" 
                                       min="0" step="0.1" required>
                            </div>

                            <div class="d-flex justify-content-between">
                                <a href="{{ route('teacher.class.informations', $schoolClass->id) }}" 
                                   class="btn btn-secondary">
                                    <i class="fas fa-arrow-left me-1"></i>Cancelar
                                </a>
                                <button type="submit" class="btn btn-warning">
                                    <i class="fas fa-save me-1"></i>Atualizar Trabalho
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>