<x-app-layout>
    @slot('title', 'Home')
    
    {{-- navbar --}}    
    <x-header/>

    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h1 class="mt-4">Minhas turmas</h1>
        <div class="row rounded-3 p-4">

            @foreach ($schoolClasses as $class)
                <div class="col-md-3 mb-4">
                    <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff" >
                        <h5 class="fw-bold">{{$class->name}}</h5>
                        <p>{{$class->numbeClass}}</p>
                        <a class="btn btn-primary fw-bold" href={{route('class')}}>Ver turma</a>
                    </div>
                </div>
            @endforeach
        </div>
        @if($schoolClasses->hasPages())
            <div class="d-flex justify-content-center mt-4">
                {{ $schoolClasses->links() }}
            </div>
        @endif
    </section>
</x-app-layout>
