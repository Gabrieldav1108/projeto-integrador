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
                            <p class="mb-3">
                                @if($class->teachers->count() > 0)
                                    @foreach($class->teachers as $teacher)
                                        {{ $teacher->name }}@if(!$loop->last), @endif
                                    @endforeach
                                @else
                                    <span class="text-muted">Professor não atribuído</span>
                                @endif
                            </p>
                            <a class="btn btn-primary fw-bold" href="{{ route('student.classes.index', $class->id) }}">
                                Ver Matéria
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="row rounded-3 p-4">
                <div class="col-12 text-center py-5">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <h4 class="text-muted">Nenhuma turma encontrada</h4>
                    <p class="text-muted">Você não está matriculado em nenhuma turma no momento.</p>
                    <button class="btn btn-primary">
                        <i class="fas fa-envelope me-2"></i>Contatar Administração
                    </button>
                </div>
            </div>
        @endif
    </section>
</x-app-layout>