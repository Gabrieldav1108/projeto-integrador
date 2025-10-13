<x-app-layout>
    @slot('title', 'Editar Professor')
    <x-admin-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2 class="fw-bold mb-4">Editar Professor</h2>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                <div class="col-md-6">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome Completo *</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $teacher->name) }}" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail *</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email', $teacher->email) }}" required>
                    </div>
                    
                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Nova Senha (deixe em branco para manter a atual)</label>
                        <input type="password" name="password" id="password" class="form-control" placeholder="Digite apenas se quiser alterar">
                        <small class="text-muted">Mínimo 6 caracteres</small>
                    </div>
                </div>

                <div class="col-md-6">

                    <!-- Subject -->
                    <div class="mb-3">
                        <label for="subject_id" class="form-label">Matéria Principal *</label>
                        <select name="subject_id" id="subject_id" class="form-select" required>
                            <option value="">Selecione uma matéria</option>
                            @foreach($subjects as $subject)
                                <option value="{{ $subject->id }}" 
                                    {{ old('subject_id', $teacher->subject_id) == $subject->id ? 'selected' : '' }}>
                                    {{ $subject->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefone</label>
                        <input type="text" name="phone" id="phone" class="form-control" 
                               value="{{ old('phone', $teacher->phone) }}" placeholder="(00) 00000-0000">
                    </div>

                    <!-- Hire Date -->
                    <div class="mb-3">
                        <label for="hire_date" class="form-label">Data de Contratação *</label>
                        <input type="date" name="hire_date" id="hire_date" class="form-control" 
                               value="{{ old('hire_date', $teacher->hire_date ? $teacher->hire_date->format('Y-m-d') : '') }}" required>
                    </div>

                    <!-- Status -->
                    <div class="mb-3 form-check form-switch">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
                               {{ old('is_active', $teacher->is_active ?? true) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Professor Ativo</label>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="d-flex gap-2 mt-4">
                <button type="submit" class="btn btn-primary fw-bold">
                    <i class="fas fa-save me-2"></i>Atualizar Professor
                </button>
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>Cancelar
                </a>
            </div>
        </form>
    </section>
</x-app-layout>