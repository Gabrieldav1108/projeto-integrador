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
                        <input type="password" name="password" id="password" class="form-control">
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Specialty -->
                    <div class="mb-3">
                        <label for="specialty" class="form-label">Especialidade/Matéria</label>
                        <input type="text" name="specialty" id="specialty" class="form-control" 
                               value="{{ old('specialty', $teacher->specialty) }}" placeholder="Ex: Matemática, Português, etc.">
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
                               value="{{ old('hire_date', $teacher->hire_date->format('Y-m-d')) }}" required>
                    </div>

                    <!-- Status -->
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="is_active" name="is_active" value="1" 
                               {{ old('is_active', $teacher->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Professor Ativo</label>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary fw-bold">Atualizar</button>
                <a href="{{ route('admin.teachers.manage') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </section>
</x-app-layout>