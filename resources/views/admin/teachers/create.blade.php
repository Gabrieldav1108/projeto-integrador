<x-app-layout>
    @slot('title', 'Adicionar Professor')
    <x-admin-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2 class="fw-bold mb-4">Adicionar Professor</h2>
        
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.teachers.store') }}" method="POST">
            @csrf

            <div class="row">
                <div class="col-md-6">
                    <!-- Name -->
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome Completo *</label>
                        <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                    </div>

                    <!-- Email -->
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail *</label>
                        <input type="email" name="email" id="email" class="form-control" value="{{ old('email') }}" required>
                    </div>
                    
                    <!-- Password -->
                    <div class="mb-3">
                        <label for="password" class="form-label">Senha *</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <!-- Specialty -->
                    <div class="mb-3">
                        <label for="specialty" class="form-label">Especialidade/Matéria</label>
                        <input type="text" name="specialty" id="specialty" class="form-control" value="{{ old('specialty') }}" 
                               placeholder="Ex: Matemática, Português, etc.">
                    </div>

                    <!-- Phone -->
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefone</label>
                        <input type="text" name="phone" id="phone" class="form-control" value="{{ old('phone') }}"
                               placeholder="(00) 00000-0000">
                    </div>

                    <!-- Hire Date -->
                    <div class="mb-3">
                        <label for="hire_date" class="form-label">Data de Contratação *</label>
                        <input type="date" name="hire_date" id="hire_date" class="form-control" value="{{ old('hire_date') }}" required>
                    </div>
                </div>
            </div>

            <!-- Buttons -->
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary fw-bold">Salvar</button>
                <a href="{{ route('admin.teachers.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </section>
</x-app-layout>