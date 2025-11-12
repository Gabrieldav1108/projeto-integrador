<x-app-layout>
    @slot('title', 'Adicionar informações - ' . $schoolClass->name)

    <x-teacher-header/>
    
    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2>Informações sobre a turma: {{$schoolClass->name}}</h2>
        
        <div class="row d-flex gap-4 p-4">
            <!-- Formulário -->
            <div class="col-12 col-md-5">
                <div class="border rounded p-3 bg-white h-100">
                    <form method="POST" action="{{ route('teacher.class.information.store', $schoolClass->id) }}" class="w-100 d-flex flex-column">
                        @csrf
                        <h5 class="text-center"><strong>Adicionar</strong></h5>
                        <p class="text-center">Escreva abaixo as informações ou avisos para a turma {{ $schoolClass->name }}</p>
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <label class="form-label" for="content">Digite o aviso</label>
                        <input type="text" class="form-control" name="content" id="content" 
                               placeholder="Digite aqui!" value="{{ old('content') }}" required>

                        <label class="form-label mt-2" for="date">Digite uma data (se tiver)</label>
                        <input type="date" class="form-control" name="date" id="date" value="{{ old('date') }}">

                        <label class="form-label mt-2" for="time">Digite um horário (se tiver)</label>
                        <input type="time" class="form-control" name="time" id="time" value="{{ old('time') }}">
                        
                        <div class="d-flex gap-2 justify-content-center mt-3">
                            <a href="{{ route('teacher.class.informations', $schoolClass->id) }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>

        <!-- Informações atuais -->
        <div class="col-12 col-md-6">
            <div class="border rounded p-3 bg-light h-100 d-flex flex-column">
                <h5 class="text-center mb-3">Informações atuais</h5>
                @if($currentInformations->count() > 0)
                    <ul class="list-group">
                        @foreach($currentInformations as $info)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <strong>{{ $info->content }}</strong>
                                    @if($info->date)
                                        - {{ \Carbon\Carbon::parse($info->date)->format('d/m/Y') }}
                                        @if($info->time)
                                            às {{ \Carbon\Carbon::parse($info->time)->format('H:i') }}
                                        @endif
                                    @endif
                                    @if($info->isExpired())
                                        <span class="badge bg-warning text-dark ms-2">Expirado</span>
                                    @else
                                        <span class="badge bg-success ms-2">Ativo</span>
                                    @endif
                                </div>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('teacher.class.information.edit', ['classId' => $schoolClass->id, 'information' => $info->id]) }}" 
                                    class="btn btn-outline-primary btn-sm w-50 text-center">
                                        <i class="fas fa-edit me-1"></i>Editar
                                    </a>
                                    <button type="button" 
                                            class="btn btn-outline-danger btn-sm w-50 text-center"
                                            onclick="if(confirm('Tem certeza que deseja excluir este aviso?')) { document.getElementById('delete-form-{{ $info->id }}').submit(); }">
                                        <i class="fas fa-trash me-1"></i>Excluir
                                    </button>
                                </div>

                                <form id="delete-form-{{ $info->id }}" 
                                    action="{{ route('teacher.class.information.destroy', ['classId' => $schoolClass->id, 'information' => $info->id]) }}" 
                                    method="POST" class="d-none">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-center text-muted">Nenhuma informação ativa no momento.</p>
                @endif
            </div>
        </div>
        </div>
    </section>
</x-app-layout>