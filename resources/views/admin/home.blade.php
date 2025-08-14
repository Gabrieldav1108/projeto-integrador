<x-app-layout>
    @slot('title', 'Painel do Administrador')
    <x-admin-header/>
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2 class="fw-bold mb-4">Painel do Administrador</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="p-4 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Gerenciar Professores</h5>
                    <p>Adicionar, editar ou excluir professores.</p>
                    <a href="{{route("manageTeachers")}}" class="btn btn-primary fw-bold">Acessar</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Gerenciar Alunos</h5>
                    <p>Adicionar, editar ou excluir alunos.</p>
                    <a href="{{route('manageClasses')}}" class="btn btn-primary fw-bold">Acessar</a>
                </div>
            </div>
            <div class="col-md-4">
                <div class="p-4 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Gerenciar Turmas</h5>
                    <p>Criar, editar ou excluir turmas.</p>
                    <a href="{{route('manageClasses')}}" class="btn btn-primary fw-bold">Acessar</a>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>
