<x-app-layout>
    @slot('title', 'Editar Aluno')
    <x-admin-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2 class="fw-bold mb-4">Editar Aluno: {{ $student->name }}</h2>

        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('student.update', $student->id) }}" method="POST">
            @csrf 
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nome Completo</label>
                <input type="text" name="name" id="name" class="form-control" 
                       value="{{ old('name', $student->name) }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" 
                       value="{{ old('email', $student->email) }}" required>
            </div>
            
            <div class="mb-3">
                <label for="age" class="form-label">Idade</label>
                <input type="number" name="age" id="age" class="form-control" 
                       value="{{ old('age', $student->age) }}" required>
            </div>

            <div class="mb-3">
                <label for="class_id" class="form-label">Turma</label>
                <select name="class_id" id="class_id" class="form-select" required>
                    <option value="">Selecione uma turma</option>
                    @foreach ($schoolClasses as $class)
                        <option value="{{ $class->id }}" 
                            {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
                            {{ $class->name }}
                        </option>                    
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary fw-bold">Salvar</button>
            <a href="{{ route('manageStudents') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </section>
</x-app-layout>