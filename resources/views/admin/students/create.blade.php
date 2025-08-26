<x-app-layout>
    @slot('title', 'Adicionar Aluno')
    <x-admin-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2 class="fw-bold mb-4">Adicionar Aluno</h2>
        <form action="{{-- {{ route('students.store') }} --}}#" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nome Completo</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="age" class="form-label">Idade</label>
                <input type="number" name="age" id="age" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Senha</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="class_id" class="form-label">Turma</label>
                <select name="class_id" id="class_id" class="form-select" required>
                    <option value="">Selecione...</option>
                    <option value="1">Turma A</option>
                    <option value="2">Turma B</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary fw-bold">Salvar</button>
            <a href="{{ route('manageStudents') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </section>
</x-app-layout>
