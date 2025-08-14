<x-app-layout>
    @slot('title', 'Editar Turma')
    <x-admin-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2 class="fw-bold mb-4">Editar Turma</h2>
        <form action="{{-- {{ route('classes.update', $class->id) }} --}}#" method="POST">
            @csrf @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Nome da Turma</label>
                <input type="text" name="name" id="name" class="form-control" value="Turma A" required>
            </div>

            <div class="mb-3">
                <label for="year" class="form-label">Número da turma</label>
                <input type="number" name="year" id="year" class="form-control" required>
            </div>
            
            <div class="mb-3">
                <label for="year" class="form-label">Nome do professor</label>
                <select name="class_id" id="class_id" class="form-select" required>
                    <option value="">Selecione...</option>
                    <option value="1">Professor 1</option>
                    <option value="2">Professor 2</option>
                    <option value="3">Professor 3</option>
                    <option value="4">Professor 4</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary fw-bold">Salvar</button>
            <a href="{{ route('manageClasses') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </section>
</x-app-layout>
