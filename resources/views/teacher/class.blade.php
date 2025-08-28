<x-app-layout>
    @slot('title', 'Turma - {{ $schoolClass->name }}')
        <x-header/>
        <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
            <h2>Informações da turma: {{$schoolClass->name}}</h2>
            <div class="row rounded p-4 align-items-stretch">
                
                <!-- Alunos matriculados -->
                <div class="col-12 col-md-6 mb-4 mb-md-0 d-flex flex-column">
                    <h3>Alunos matriculados</h3>
                    <div class="border rounded p-3 bg-white h-100" data-bs-spy="scroll">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Nome do aluno 1</span>
                                <a href={{ route('studentInformation') }} class="btn btn-primary m-1">Ver aluno</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Nome do aluno 1</span>
                                <a href={{ route('studentInformation') }} class="btn btn-primary m-1">Ver aluno</a>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <span>Nome do aluno 1</span>
                                <a href={{ route('studentInformation') }} class="btn btn-primary m-1">Ver aluno</a>
                            </li>
                        </ul>
                    </div>
                </div>
    
                <!-- Avisos -->
                <div class="col-12 col-md-6 d-flex flex-column">
                    <!-- Cabeçalho com botão -->
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                        <h3 class="mb-2 mb-md-0">Avisos</h3>
                        <a href={{ route('class.information.add', $schoolClass->id) }} class="btn btn-primary w-md-auto">Adicionar informações</a>
                    </div>
    
                    <!-- Conteúdo dos avisos -->
                    <div class="border rounded p-3 bg-light h-100">
                        @if($informations->count() > 0)
                        <ul class="list-group">
                            @foreach($informations as $info)
                                @if($info) {{-- Verifique se $info não é false --}}
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <strong>{{ $info->content ?? 'Sem conteúdo' }}</strong>
                                            @if($info->date)
                                                - {{ $info->date->format('d/m/Y') }}
                                            @endif
                                            @if($info->time)
                                                às {{ \Carbon\Carbon::parse($info->time)->format('H:i') }}
                                            @endif
                                        </div>
                                        <div class="d-flex gap-2 align-items-stretch">
                                            <form action="{{ route('class.information.destroy', ['classId' => $schoolClass->id, 'id' => $info->id]) }}" 
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger d-flex h-100" 
                                                        onclick="return confirm('Tem certeza que deseja excluir?')">
                                                    Excluir
                                                </button>
                                            </form>
                                            <a href="{{ route('class.information.edit', ['classId' => $schoolClass->id, 'id' => $info->id]) }}" 
                                            class="btn btn-sm btn-outline-primary d-flex justify-content-center align-items-center h-100">
                                                Editar
                                            </a>
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-muted">Nenhum aviso cadastrado.</p>
                    @endif
                    </div>
                </div>
            </div>
        </section>
</x-app-layout>
