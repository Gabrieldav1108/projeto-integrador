<x-app-layout>
    @slot('title', 'Turma')
        <x-header/>
        <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
            <h2>Informações da turma</h2>
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
                        <a href={{ route('addClassInformation') }} class="btn btn-primary w-md-auto">Adicionar informações</a>
                    </div>
    
                    <!-- Conteúdo dos avisos -->
                    <div class="border rounded p-3 bg-light h-100">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Prova de matemática - 10/07
                                <div>
                                    <a href="#" class="btn btn-sm btn-outline-danger">Excluir</a>
                                    <a href={{route('editClassInformation')}} class="btn btn-sm btn-outline-primary">Editar</a>
                                </div>
                            </li>
    
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Entrega do trabalho de história - 15/07
                                <div>
                                    <a href="#" class="btn btn-sm btn-outline-danger">Excluir</a>
                                    <a href={{route('editClassInformation')}} class="btn btn-sm btn-outline-primary">Editar</a>
                                </div>                        </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Apresentação de ciências - 20/07
                                <div>
                                    <a href="#" class="btn btn-sm btn-outline-danger">Excluir</a>
                                    <a href={{route('editClassInformation')}} class="btn btn-sm btn-outline-primary">Editar</a>
                                </div>                        </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    
    {{-- navbar --}}
</x-app-layout>
