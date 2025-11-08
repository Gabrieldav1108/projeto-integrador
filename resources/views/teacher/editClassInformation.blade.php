<x-app-layout>
    @slot('title', 'Editar informações - {{ $schoolClass->name }}')

    <x-teacher-header/>
    
    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2>Informações sobre a turma: {{$schoolClass->name}}</h2>
        
        <div class="row d-flex gap-4 p-4">
            <!-- Formulário -->
            <div class="col-12 col-md-5">
                <div class="border rounded p-3 bg-white h-100">
                    <form method="POST" action="{{ route('teacher.class.information.update', ['classId' => $schoolClass->id, 'information' => $information->id]) }}" class="w-100 d-flex flex-column">
                        @csrf
                        @method('PUT')
                        <h5 class="text-center"><strong>Editar</strong></h5>
                        <p class="text-center">Editando o aviso - <b>{{$information->content}}</b></p>
                        
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        
                        <label class="form-label" for="content">Altere o aviso</label>
                        <input type="text" class="form-control" name="content" id="content" 
                               placeholder="Digite aqui!" value="{{ old('content', $information->content) }}" required>

                        <label class="form-label mt-2" for="date">Altere a data (se precisar)</label>
                        <input type="date" class="form-control" name="date" id="date" value="{{ old('date', $information->date ? \Carbon\Carbon::parse($information->date)->format('Y-m-d') : '') }}">

                        <label class="form-label mt-2" for="time">Altere o horário (se precisar)</label>
                        <input type="time" class="form-control" name="time" id="time" value="{{ old('time', $information->time ? \Carbon\Carbon::parse($information->time)->format('H:i') : '') }}">
                        
                        <div class="d-flex gap-2 justify-content-center mt-3">
                            <a href="{{ route('teacher.class.informations', $schoolClass->id) }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Atualizar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informações atuais -->
            <div class="col-12 col-md-6">
                <div class="border rounded p-3 bg-light h-100 d-flex flex-column">
                    <h5 class="text-center mb-3">Informações atuais (ativas)</h5>
                    @if($currentInformations->count() > 0)
                        <ul class="list-group">
                            @foreach($currentInformations as $info)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <strong @if($info->id == $information->id) style="color: #0d6efd;" @endif>
                                            {{ $info->content }}
                                        </strong>
                                        @if($info->date)
                                            - {{ \Carbon\Carbon::parse($info->date)->format('d/m/Y') }}
                                            @if($info->time)
                                                às {{ \Carbon\Carbon::parse($info->time)->format('H:i') }}
                                            @endif
                                        @endif
                                    </div>
                                    <div class="d-flex gap-1">
                                        @if($info->id == $information->id)
                                            <span class="badge bg-primary">Editando</span>
                                        @else
                                            <a href="{{ route('teacher.class.information.edit', ['classId' => $schoolClass->id, 'id' => $info->id]) }}" 
                                            class="btn btn-sm btn-outline-primary">Editar</a>
                                            <form action="{{ route('teacher.class.information.destroy', ['classId' => $schoolClass->id, 'id' => $info->id]) }}" 
                                                method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-outline-danger" 
                                                        onclick="return confirm('Tem certeza que deseja excluir este aviso?')">
                                                    Excluir
                                                </button>
                                            </form>
                                        @endif
                                    </div>
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