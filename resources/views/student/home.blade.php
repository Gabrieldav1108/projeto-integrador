<x-app-layout>
    @slot('title', 'Home')
    <x-student-header/>
    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h1 class="mt-4">Minhas matérias</h1>
        
        @if($subjects->count() > 0)
            <div class="row rounded-3 p-4">
                @foreach($subjects as $subject)
                    <div class="col-md-3 mb-4">
                        <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                            <h5 class="fw-bold">{{ $subject->name }}</h5>
                            <p class="small text-muted mb-3">
                                {{ $subject->description ?? 'Sem descrição' }}
                            </p>
                            <a class="btn btn-primary fw-bold" href="{{ route('student.classes.index', $subject->id) }}">
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
                    <h4 class="text-muted">Nenhuma matéria encontrada</h4>
                    <p class="text-muted">Você não está matriculado em nenhuma matéria no momento.</p>
                    <button class="btn btn-primary">
                        <i class="fas fa-envelope me-2"></i>Contatar Administração
                    </button>
                    
                    {{-- Debug --}}
                    <div class="mt-3 small text-muted">
                        <p>Usuário: {{ Auth::user()->name }}</p>
                        <p>Turmas: {{ Auth::user()->schoolClasses->count() }}</p>
                    </div>
                </div>
            </div>
        @endif
    </section>
</x-app-layout>