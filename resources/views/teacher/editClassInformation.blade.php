<x-app-layout>
    @slot('title', 'Adicionar informações - {{ $schoolClass->name }}')

    <x-header/>
    
    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2>Informações sobre a turma: {{$schoolClass->name}}</h2>
        
        <div class="row d-flex gap-4 p-4">
            <!-- Formulário -->
            <div class="col-12 col-md-5">
                <div class="border rounded p-3 bg-white h-100">
                    <form method="POST" action="{{ route('class.information.update', ["classId" => $schoolClass, "id" => $information->id]) }}" class="w-100 d-flex flex-column">
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

                        <label class="form-label mt-2" for="date">Altere a a data (se precisar)</label>
                        <input type="date" class="form-control" name="date" id="date" value="{{ old('date', $information->date ? \Carbon\Carbon::parse($information->date)->format('Y-m-d') : '') }}">

                        <label class="form-label mt-2" for="time">Altere o horário (se precisar)</label>
                        <input type="time" class="form-control" name="time" id="time" value="{{ old('time', $information->time ? \Carbon\Carbon::parse($information->time)->format('H:i') : '') }}">
                        
                        <div class="d-flex gap-2 justify-content-center mt-3">
                            <a href="{{ route('class.informations', $schoolClass->id) }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Adicionar</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Informações atuais -->
            <div class="col-12 col-md-6">
                <div class="border rounded p-3 bg-light h-100 d-flex flex-column">
                    <h5 class="text-center mb-3">Informações atuais</h5>
                    @php
                        $currentInformations = $schoolClass->informations()->orderBy('created_at', 'desc')->get();
                    @endphp
                    
                    @if($currentInformations->count() > 0)
                        <ul class="list-group">
                            @foreach($currentInformations as $info)
                                <li class="list-group-item">
                                    <strong>{{ $info->content }}</strong>
                                    @if($info->date)
                                        - {{ $info->date->format('d/m/Y') }}
                                    @endif
                                    @if($info->time)
                                        às {{ \Carbon\Carbon::parse($info->time)->format('H:i') }}
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <p class="text-center text-muted">Nenhuma informação cadastrada.</p>
                    @endif
                </div>
            </div>
    </section>
</x-app-layout>
