<x-app-layout>
    @slot('title', 'Gerenciar Turmas')
    <x-admin-header/>

    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Turmas</h2>
            <a href="{{ route('admin.classes.create') }}" class="btn btn-success">+ Nova Turma</a>
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
                        <th>Número da turma</th>
                        <th>Professores</th>
                        <th>Matérias</th>
                        <th class="text-center">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($classes as $class)
                        <tr>
                            <td class="fw-bold">{{ $class->name }}</td>
                            <td>{{ $class->numberClass }}</td>
                            <td>
                                @if($class->teachers->count() > 0)
                                    {{ $class->teachers->pluck('name')->implode(', ') }}
                                @else
                                    <span class="text-muted">Nenhum professor</span>
                                @endif
                            </td>
                            <td>
                                @if($class->subjects->count() > 0)
                                    <span class="badge bg-primary">{{ $class->subjects->count() }} matéria(s)</span>
                                @else
                                    <span class="badge bg-warning text-dark">Sem matérias</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <!-- Vincular Matérias -->
                                <a href="{{ route('admin.classes.subjects.edit', $class->id) }}" 
                                   class="btn btn-info btn-sm" 
                                   title="Vincular Matérias">
                                    Matérias
                                </a>
                                
                                <!-- Editar Turma -->
                                <a href="{{ route('admin.classes.edit', $class->id) }}" 
                                   class="btn btn-warning btn-sm">
                                    Editar
                                </a>
                                
                                <!-- Excluir Turma -->
                                <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" class="d-inline">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Tem certeza que deseja excluir esta turma?')">
                                        Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Nenhuma turma cadastrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>