<x-app-layout>
    @slot('title', 'Gerenciar Alunos')
    <x-admin-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Alunos</h2>
            <a href="{{ route('createStudent') }}" class="btn btn-success">+ Novo Aluno</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped bg-light">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Idade</th>
                        <th>Turma</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Maria Souza</td>
                        <td>maria@escola.com</td>
                        <td>15aria@escola.com</td>
                        <td>Turma A</td>
                        <td class="text-center">
                            <a href="{{ route('editStudent', 1) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{-- {{ route('students.destroy', 1) }} --}}#" method="POST" class="d-inline">
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
