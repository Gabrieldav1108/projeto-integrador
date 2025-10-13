<x-app-layout>
    @slot('title', "Matéria - {$subject->name}")
    <x-student-header/>
    
    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>{{ $subject->name }}</h1>
            <a href="{{ route('student.home') }}" class="btn btn-secondary">
                ← Voltar
            </a>
        </div>

        <div class="row">
            <!-- Avisos Gerais da Matéria -->
            <div class="col-12 mb-4">
                <div class="border rounded p-4 bg-white">
                    <h3 class="mb-3">📢 Avisos da Matéria</h3>
                    
                    @php
                        // Coletar todos os avisos de todas as turmas desta matéria
                        $allInformations = collect();
                        foreach ($subject->schoolClasses as $class) {
                            $allInformations = $allInformations->merge($class->classInformations);
                        }
                        $allInformations = $allInformations->sortByDesc('created_at');
                    @endphp
                    
                    @if($allInformations->count() > 0)
                        <div class="row">
                            @foreach($allInformations as $info)
                                <div class="col-md-6 mb-3">
                                    <div class="card border-primary">
                                        <div class="card-body">
                                            <h6 class="card-title">{{ $info->content }}</h6>
                                            @if($info->date || $info->time)
                                                <p class="card-text small text-muted mb-1">
                                                    @if($info->date)
                                                        📅 {{ \Carbon\Carbon::parse($info->date)->format('d/m/Y') }}
                                                    @endif
                                                    @if($info->time)
                                                        ⏰ {{ \Carbon\Carbon::parse($info->time)->format('H:i') }}
                                                    @endif
                                                </p>
                                            @endif
                                            <p class="card-text small text-muted">
                                                Turma: {{ $info->schoolClass->name }}
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-bell-slash fa-2x text-muted mb-3"></i>
                            <p class="text-muted">Nenhum aviso disponível para esta matéria.</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Turmas do Estudante nesta Matéria -->
            <div class="col-12">
                <div class="border rounded p-4 bg-white">
                    <h3 class="mb-3">🏫 Minhas Turmas</h3>
                    
                    @if($subject->schoolClasses->count() > 0)
                        <div class="row">
                            @foreach($subject->schoolClasses as $class)
                                <div class="col-md-4 mb-3">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">{{ $class->name }}</h5>
                                            <p class="card-text small text-muted">
                                                Avisos ativos: {{ $class->classInformations->count() }}
                                            </p>
                                            <p class="card-text small">
                                                Professor: 
                                                @if($class->teachers->count() > 0)
                                                    {{ $class->teachers->first()->name ?? 'Não definido' }}
                                                @else
                                                    Não definido
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-users-slash fa-2x text-muted mb-3"></i>
                            <p class="text-muted">Você não está em nenhuma turma desta matéria.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>
</x-app-layout>