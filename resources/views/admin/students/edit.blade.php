<x-app-layout>
    @slot('title', 'Editar Aluno')
    <x-admin-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2 class="fw-bold mb-4">Editar Aluno</h2>
        <form action="{{-- {{ route('students.update', $student->id) }} --}}#" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nome Completo</label>
                <input type="text" name="name" id="name" class="form-control" value="Maria Souza" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" value="maria@escola.com" required>
            </div>

            <div class="mb-3">
                <label for="class_id" class="form-label">Turma</label>
                <select name="class_id" id="class_id" class="form-select" required>
                    <option value="1" selected>Turma A</option>
                    <option value="2">Turma B</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary fw-bold">Salvar</button>
            <a href="{{ route('manageStudents') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </section>
</x-app-layout>
