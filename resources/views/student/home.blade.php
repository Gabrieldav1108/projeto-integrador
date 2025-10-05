<x-app-layout>
    @slot('title', 'Home')
    <x-student-header/>
    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h1 class="mt-4">Minhas matérias</h1>
        
        @if($classes->count() > 0)
            <div class="row rounded-3 p-4">
                @foreach($classes as $class)
                <div class="col-md-3 mb-4">
                    <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                        <h5 class="fw-bold">{{ $class->name }}</h5>
                        <p class="text-muted">
                            @if($class->teacher)
                                Professor: {{ $class->teacher->name }}
                            @else
                                Professor não atribuído
                            @endif
                        </p>
                        <p class="small text-muted">
                            Código: {{ $class->code ?? 'N/A' }}
                        </p>
                        <a class="btn btn-primary fw-bold" href="{{ route('student.classes.show', $class->id) }}">
                            Ver Matéria
                        </a>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center p-5">
                <h4 class="text-muted">Nenhuma matéria encontrada</h4>
                <p class="text-muted">Você não está matriculado em nenhuma turma no momento.</p>
                <a href="{{ route('student.classes.index') }}" class="btn btn-outline-primary">
                    Ver todas as turmas disponíveis
                </a>
            </div>
        @endif
    </section>
</x-app-layout>