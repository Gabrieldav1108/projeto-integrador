<x-app-layout>
    @slot('title', 'Gerenciar Turmas')
    <x-admin-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Turmas</h2>
            <a href="{{ route('createClass') }}" class="btn btn-success">+ Nova Turma</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped bg-light">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Número da turma</th>
                        <th>Professores</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Turma A</td>
                        <td>901</td>
                        <td>Professor 1, Professor 2</td>
                        <td class="text-center">
                            <a href="{{ route('editClass', 1) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{-- {{ route('classes.destroy', 1) }} --}}#" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-danger btn-sm">Excluir</button>
                            </form>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>
