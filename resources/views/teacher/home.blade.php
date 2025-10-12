<x-app-layout>
    @slot('title', 'Home')
    
    {{-- navbar --}}    
    <x-teacher-header/>

    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h1 class="mt-4">Minhas turmas</h1>
        
        @if($schoolClasses->count() > 0)
            <div class="row rounded-3 p-4">
                @foreach ($schoolClasses as $class)
                    <div class="col-md-3 mb-4">
                        <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                            <h5 class="fw-bold">{{ $class->name }}</h5>
                            <p>N° da turma: {{ $class->numberClass }}</p>
                            <a class="btn btn-primary fw-bold" href="{{ route('teacher.class.informations', $class->id) }}">
                                Ver turma
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
                    <p class="text-muted">Você não está atribuído a nenhuma turma no momento.</p>
                </div>
            </div>
        @endif
    </section>
</x-app-layout>