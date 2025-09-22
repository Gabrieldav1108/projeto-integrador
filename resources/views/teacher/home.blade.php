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
                        <p>N° da turma: {{$class->numberClass}}</p>
                        <a class="btn btn-primary fw-bold" href={{route('class.informations', $class->id)}}>Ver turma</a>
                    </div>
                </div>
            @endforeach
        </div>
            @if($schoolClasses->hasPages())
                <div class="d-flex justify-content-center mt-4">
                    <nav aria-label="Page navigation">
                        <ul class="pagination">
                            {{-- Previous Page Link --}}
                            @if($schoolClasses->onFirstPage())
                                <li class="page-item disabled">
                                    <span class="page-link">Anterior</span>
                                </li>
                            @else
                                <li class="page-item">
                                    <a class="page-link" href="{{ $schoolClasses->previousPageUrl() }}" rel="prev">Anterior</a>
                                </li>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach($schoolClasses->getUrlRange(1, $schoolClasses->lastPage()) as $page => $url)
                                @if($page == $schoolClasses->currentPage())
                                    <li class="page-item active" aria-current="page">
                                        <span class="page-link">{{ $page }}</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $url }}">{{ $page }}</a>
                                    </li>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if($schoolClasses->hasMorePages())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $schoolClasses->nextPageUrl() }}" rel="next">Próximo</a>
                                </li>
                            @else
                                <li class="page-item disabled">
                                    <span class="page-link">Próximo</span>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
    </section>
</x-app-layout>
