<x-app-layout>
    @slot('title', 'Adicionar Turma')
    <x-admin-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2 class="fw-bold mb-4">Adicionar Turma</h2>
        <form action="{{-- {{ route('classes.store') }} --}}#" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Nome da Turma</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="year" class="form-label">Ano</label>
                <input type="number" name="year" id="year" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary fw-bold">Salvar</button>
            <a href="{{ route('manageClasses') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </section>
</x-app-layout>
