<x-app-layout>
    @slot('title', "Turma - {$schoolClass->name}")
    
    <x-teacher-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2>Informações da turma: {{ $schoolClass->name }}</h2>
        <div class="row rounded p-4 align-items-stretch">
            
            <!-- Alunos matriculados -->
            <div class="col-12 col-md-6 mb-4 mb-md-0 d-flex flex-column">
                <h3>Alunos matriculados</h3>
                <div class="border rounded p-3 bg-white h-100" style="max-height: 400px; overflow-y: auto;">
                    @if($schoolClass->students->count() > 0)
                        <ul class="list-group">
                            @foreach($schoolClass->students as $userStudent)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <span>{{ $userStudent->name }}</span>
                                    <a href="{{ route('teacher.students.show', $userStudent->id) }}" 
                                    class="btn btn-primary btn-sm">
                                        Ver aluno
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-muted mt-3">Nenhum aluno matriculado nesta turma.</p>
                    @endif
                </div>
            </div>

            <!-- Avisos -->
            <div class="col-12 col-md-6 d-flex flex-column">
                <!-- Cabeçalho com botão -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                    <h3 class="mb-2 mb-md-0">Avisos</h3>
                    <a href="{{ route('teacher.class.information.add', $schoolClass->id) }}" 
                       class="btn btn-primary w-md-auto">
                        Adicionar informações
                    </a>
                </div>

                <!-- Conteúdo dos avisos -->
                <div class="border rounded p-3 bg-light h-100" style="max-height: 400px; overflow-y: auto;">
                    @if($informations->count() > 0)
                        <ul class="list-group">
                            @foreach($informations as $info)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="flex-grow-1 me-3">
                                        <strong>{{ $info->content ?? 'Sem conteúdo' }}</strong>
                                        <br>
                                        <small class="text-muted">
                                            @if($info->date)
                                                {{ \Carbon\Carbon::parse($info->date)->format('d/m/Y') }}
                                            @endif
                                            @if($info->time)
                                                às {{ \Carbon\Carbon::parse($info->time)->format('H:i') }}
                                            @endif
                                        </small>
                                    </div>
                                    <div class="d-flex gap-2" style="min-width: 140px;">
                                        <!-- Botão Editar -->
                                        <a href="{{ route('teacher.class.information.edit', ['classId' => $schoolClass->id, 'information' => $info->id]) }}" 
                                           class="btn btn-sm btn-outline-primary flex-fill d-flex align-items-center justify-content-center"
                                           style="height: 32px;">
                                            Editar
                                        </a>
                                        <!-- Botão Excluir -->
                                        <form action="{{ route('teacher.class.information.destroy', ['classId' => $schoolClass->id, 'information' => $info->id]) }}" 
                                              method="POST" class="d-flex flex-fill">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger w-100 d-flex align-items-center justify-content-center"
                                                    style="height: 32px;"
                                                    onclick="return confirm('Tem certeza que deseja excluir este aviso?')">
                                                Excluir
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-muted mt-3">Nenhum aviso cadastrado.</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Botão Voltar -->
        <div class="mt-4">
            <a href="{{ route('teacher.home') }}" class="btn btn-secondary">
                ← Voltar para Dashboard
            </a>
        </div>
    </section>
</x-app-layout>