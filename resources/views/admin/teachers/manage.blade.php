<x-app-layout>
    @slot('title', 'Gerenciar Professores')
    <x-admin-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Professores</h2>
            <a href="{{ route('admin.teachers.create') }}" class="btn btn-success">+ Novo Professor</a>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered table-striped bg-light">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Especialidade</th>
                        <th>Telefone</th>
                        <th>Data de Contratação</th>
                        <th>Status</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($teachers as $teacher)
                    <tr>
                        <td>{{ $teacher->name }}</td>
                        <td>{{ $teacher->email }}</td>
                        <td>{{ $teacher->specialty ?? 'N/A' }}</td>
                        <td>{{ $teacher->phone ?? 'N/A' }}</td>
                        <td>{{ $teacher->hire_date->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge {{ $teacher->is_active ? 'bg-success' : 'bg-danger' }}">
                                {{ $teacher->is_active ? 'Ativo' : 'Inativo' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.teachers.edit', $teacher->id) }}" class="btn btn-warning btn-sm">Editar</a>
                            <form action="{{ route('admin.teachers.destroy', $teacher->id) }}" method="POST" class="d-inline">
                                @csrf 
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm" 
                                        onclick="return confirm('Tem certeza que deseja excluir este professor?')">
                                    Excluir
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if($teachers->isEmpty())
            <div class="alert alert-info text-center mt-4">
                Nenhum professor cadastrado.
            </div>
        @endif
    </section>
</x-app-layout>