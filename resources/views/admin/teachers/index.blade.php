<x-app-layout>
    @slot('title', 'Gerenciar Professores')
    <x-admin-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Professores</h2>
            <a href="{{ route('createTeacher') }}" class="btn btn-success">+ Novo Professor</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-striped bg-light">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Matéria</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>João Silva</td>
                        <td>joao@escola.com</td>
                        <td>Matemática</td>
                        <td class="text-center">
                            <a href="{{ route('editTeacher', 1) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{-- {{ route('admin.professores.destroy', 1) }} --}}#" method="POST" class="d-inline">
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
