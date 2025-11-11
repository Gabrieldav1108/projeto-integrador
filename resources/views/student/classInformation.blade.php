<x-app-layout>
    @slot('title', $subject->name)
    <x-student-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">Matéria: {{ $subject->name }}</h2>
            <a href="{{ route('student.home') }}" class="btn btn-secondary">
                ← Voltar
            </a>
        </div>

        <div class="row rounded p-4 align-items-stretch mt-3">
            <!-- Informações sobre a matéria -->
            <div class="col-12 col-md-6 mb-4 mb-md-0 d-flex flex-column">
                <h3 class="mb-3">Informações sobre a matéria</h3>

                <div class="border rounded p-4 bg-white" style="min-height: 300px;">
                    @if($mainTeacher)
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="fas fa-chalkboard-teacher fa-3x text-primary"></i>
                            </div>
                            <strong class="fs-5">Professor: {{ $mainTeacher->name }}</strong>
                        </div>
                        
                        <div class="mb-3">
                            <strong>📧 Email:</strong> 
                            <span class="ms-2">{{ $mainTeacher->email }}</span>
                        </div>
                        
                        @if($mainTeacher->phone)
                        <div class="mb-3">
                            <strong>📞 Telefone:</strong> 
                            <span class="ms-2">{{ $mainTeacher->phone }}</span>
                        </div>
                        @endif
                        
                        @if($mainTeacher->specialty)
                        <div class="mb-3">
                            <strong>🎓 Especialidade:</strong> 
                            <span class="ms-2">{{ $mainTeacher->specialty }}</span>
                        </div>
                        @endif
                    @else
                        <div class="text-center text-muted py-5">
                            <i class="fas fa-user-slash fa-3x mb-3"></i>
                            <p>Nenhum professor vinculado a esta matéria.</p>
                        </div>
                    @endif

                    <!-- Descrição da matéria -->
                    <div class="mt-4 pt-3 border-top">
                        <strong>📝 Descrição:</strong>
                        <p class="mt-2">{{ $subject->description ?? 'Sem descrição disponível.' }}</p>
                    </div>
                </div>
            </div>

            <!-- Avisos do professor -->
            <div class="col-12 col-md-6 d-flex flex-column">
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                    <h3 class="mb-2 mb-md-0">Avisos do professor</h3>
                    <a href="{{ route('grades.subject', $subject->id) }}" class="btn btn-primary w-md-auto">Notas</a>
                </div>

                <div class="border rounded p-3 bg-light h-100">
                    @if($subject->classInformations->count() > 0)
                        <ul class="list-group">
                            @foreach($subject->classInformations as $info)
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <div class="flex-grow-1">
                                        <strong>{{ $info->content }}</strong>
                                        @if($info->date || $info->time)
                                            <br>
                                            <small class="text-muted">
                                                @if($info->date)
                                                    📅 {{ \Carbon\Carbon::parse($info->date)->format('d/m/Y') }}
                                                @endif
                                                @if($info->time)
                                                    ⏰ {{ \Carbon\Carbon::parse($info->time)->format('H:i') }}
                                                @endif
                                            </small>
                                        @endif
                                        @if($info->schoolClass)
                                            <br>
                                            <small class="text-muted">
                                                Turma: {{ $info->schoolClass->name }}
                                            </small>
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-bell-slash fa-2x mb-3"></i>
                            <p>Nenhum aviso disponível no momento.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>        

    </section>
</x-app-layout>