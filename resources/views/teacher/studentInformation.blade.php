<x-app-layout>
    @slot('title', 'Informações do aluno - ' . $student->name)
    <x-teacher-header/>

    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-center text-md-start mb-0">Informações do aluno</h2>
            <a href="{{ route('teacher.students.index') }}" class="btn btn-secondary">
                ← Voltar para lista
            </a>
        </div>

        <div class="row rounded p-4 g-4 justify-content-center">
            <!-- Coluna: Notas -->
            <div class="col-12 col-lg-5 d-flex flex-column mb-4 mb-lg-0">
                <div class="bg-white rounded shadow-sm p-3 h-100">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h5 class="text-center mb-0"><strong>Notas</strong></h5>
                    </div>
                    <p class="text-center text-muted small mb-3">Clique em qualquer nota para editar</p>

                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">Avaliação</th>
                                    <th scope="col">1º nota</th>
                                    <th scope="col">2º nota</th>
                                    <th scope="col">3º nota</th>
                                    <th scope="col">Média Trim</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $firstAverage = 0;
                                    $secondAverage = 0;
                                    $thirdAverage = 0;
                                    $firstCount = 0;
                                    $secondCount = 0;
                                    $thirdCount = 0;
                                @endphp

                                <!-- Primeiro Trimestre -->
                                @if(isset($grades['first_trimester']) && count($grades['first_trimester']) > 0)
                                <tr>
                                    <th scope="row">1° Trim</th>
                                    @foreach($grades['first_trimester'] as $index => $grade)
                                        <td>
                                            @if(isset($grade['id']))
                                                <a href="{{ route('teacher.grades.edit', ['studentId' => $student->id, 'gradeId' => $grade['id']]) }}" 
                                                   class="btn btn-outline-primary btn-sm w-100 py-1"
                                                   title="Clique para editar esta nota">
                                                    {{ number_format($grade['grade'], 1) }}
                                                </a>
                                            @else
                                                <a href="{{ route('teacher.grades.create', $student->id) }}" 
                                                   class="btn btn-outline-secondary btn-sm w-100 py-1"
                                                   title="Adicionar nota">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            @endif
                                        </td>
                                        @php 
                                            $firstAverage += $grade['grade'];
                                            $firstCount++;
                                        @endphp
                                    @endforeach
                                    {{-- Preencher notas faltantes --}}
                                    @for($i = $firstCount; $i < 3; $i++)
                                        <td>
                                            <a href="{{ route('teacher.grades.create', $student->id) }}" 
                                               class="btn btn-outline-secondary btn-sm w-100 py-1"
                                               title="Adicionar nota">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </td>
                                    @endfor
                                    <td class="align-middle">
                                        <strong>
                                            @php
                                                $firstTrimAverage = $firstCount > 0 ? $firstAverage / $firstCount : 0;
                                            @endphp
                                            {{ number_format($firstTrimAverage, 1) }}
                                        </strong>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <th scope="row">1° Trim</th>
                                    @for($i = 0; $i < 3; $i++)
                                        <td>
                                            <a href="{{ route('teacher.grades.create', $student->id) }}" 
                                               class="btn btn-outline-secondary btn-sm w-100 py-1"
                                               title="Adicionar nota">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </td>
                                    @endfor
                                    <td class="align-middle">
                                        <strong>0.0</strong>
                                    </td>
                                </tr>
                                @endif

                                <!-- Segundo Trimestre -->
                                @if(isset($grades['second_trimester']) && count($grades['second_trimester']) > 0)
                                <tr>
                                    <th scope="row">2° Trim</th>
                                    @foreach($grades['second_trimester'] as $index => $grade)
                                        <td>
                                            @if(isset($grade['id']))
                                                <a href="{{ route('teacher.grades.edit', ['studentId' => $student->id, 'gradeId' => $grade['id']]) }}" 
                                                   class="btn btn-outline-primary btn-sm w-100 py-1"
                                                   title="Clique para editar esta nota">
                                                    {{ number_format($grade['grade'], 1) }}
                                                </a>
                                            @else
                                                <a href="{{ route('teacher.grades.create', $student->id) }}" 
                                                   class="btn btn-outline-secondary btn-sm w-100 py-1"
                                                   title="Adicionar nota">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            @endif
                                        </td>
                                        @php 
                                            $secondAverage += $grade['grade'];
                                            $secondCount++;
                                        @endphp
                                    @endforeach
                                    {{-- Preencher notas faltantes --}}
                                    @for($i = $secondCount; $i < 3; $i++)
                                        <td>
                                            <a href="{{ route('teacher.grades.create', $student->id) }}" 
                                               class="btn btn-outline-secondary btn-sm w-100 py-1"
                                               title="Adicionar nota">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </td>
                                    @endfor
                                    <td class="align-middle">
                                        <strong>
                                            @php
                                                $secondTrimAverage = $secondCount > 0 ? $secondAverage / $secondCount : 0;
                                            @endphp
                                            {{ number_format($secondTrimAverage, 1) }}
                                        </strong>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <th scope="row">2° Trim</th>
                                    @for($i = 0; $i < 3; $i++)
                                        <td>
                                            <a href="{{ route('teacher.grades.create', $student->id) }}" 
                                               class="btn btn-outline-secondary btn-sm w-100 py-1"
                                               title="Adicionar nota">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </td>
                                    @endfor
                                    <td class="align-middle">
                                        <strong>0.0</strong>
                                    </td>
                                </tr>
                                @endif

                                <!-- Terceiro Trimestre -->
                                @if(isset($grades['third_trimester']) && count($grades['third_trimester']) > 0)
                                <tr>
                                    <th scope="row">3° Trim</th>
                                    @foreach($grades['third_trimester'] as $index => $grade)
                                        <td>
                                            @if(isset($grade['id']))
                                                <a href="{{ route('teacher.grades.edit', ['studentId' => $student->id, 'gradeId' => $grade['id']]) }}" 
                                                   class="btn btn-outline-primary btn-sm w-100 py-1"
                                                   title="Clique para editar esta nota">
                                                    {{ number_format($grade['grade'], 1) }}
                                                </a>
                                            @else
                                                <a href="{{ route('teacher.grades.create', $student->id) }}" 
                                                   class="btn btn-outline-secondary btn-sm w-100 py-1"
                                                   title="Adicionar nota">
                                                    <i class="fas fa-plus"></i>
                                                </a>
                                            @endif
                                        </td>
                                        @php 
                                            $thirdAverage += $grade['grade'];
                                            $thirdCount++;
                                        @endphp
                                    @endforeach
                                    {{-- Preencher notas faltantes --}}
                                    @for($i = $thirdCount; $i < 3; $i++)
                                        <td>
                                            <a href="{{ route('teacher.grades.create', $student->id) }}" 
                                               class="btn btn-outline-secondary btn-sm w-100 py-1"
                                               title="Adicionar nota">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </td>
                                    @endfor
                                    <td class="align-middle">
                                        <strong>
                                            @php
                                                $thirdTrimAverage = $thirdCount > 0 ? $thirdAverage / $thirdCount : 0;
                                            @endphp
                                            {{ number_format($thirdTrimAverage, 1) }}
                                        </strong>
                                    </td>
                                </tr>
                                @else
                                <tr>
                                    <th scope="row">3° Trim</th>
                                    @for($i = 0; $i < 3; $i++)
                                        <td>
                                            <a href="{{ route('teacher.grades.create', $student->id) }}" 
                                               class="btn btn-outline-secondary btn-sm w-100 py-1"
                                               title="Adicionar nota">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </td>
                                    @endfor
                                    <td class="align-middle">
                                        <strong>0.0</strong>
                                    </td>
                                </tr>
                                @endif

                                <!-- Média Final -->
                                <tr class="table-secondary">
                                    <td colspan="4" class="text-end align-middle">
                                        <strong>Média final:</strong>
                                    </td>
                                    <td class="align-middle">
                                        <strong class="fs-5">
                                            @php
                                                // Calcular a média final baseada nas médias dos trimestres
                                                $trimestersWithGrades = 0;
                                                $totalTrimAverage = 0;
                                                
                                                if ($firstCount > 0) {
                                                    $totalTrimAverage += $firstTrimAverage;
                                                    $trimestersWithGrades++;
                                                }
                                                if ($secondCount > 0) {
                                                    $totalTrimAverage += $secondTrimAverage;
                                                    $trimestersWithGrades++;
                                                }
                                                if ($thirdCount > 0) {
                                                    $totalTrimAverage += $thirdTrimAverage;
                                                    $trimestersWithGrades++;
                                                }
                                                
                                                $finalAverage = $trimestersWithGrades > 0 ? $totalTrimAverage / $trimestersWithGrades : 0;
                                            @endphp
                                            {{ number_format($finalAverage, 1) }}
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Coluna: Informações do aluno (mantida igual) -->
            <div class="col-12 col-lg-5 d-flex flex-column">
                <div class="bg-white rounded shadow-sm p-3 h-100">
                    <h5 class="text-center mb-4"><strong>Informações do aluno</strong></h5>

                    <!-- Foto e nome do aluno -->
                    <div class="text-center mb-4">
                        <div class="mb-3">
                            <div class="bg-primary rounded-circle d-inline-flex align-items-center justify-content-center" 
                                 style="width: 80px; height: 80px;">
                                <i class="fas fa-user fa-2x text-white"></i>
                            </div>
                        </div>
                        <h4 class="text-primary mb-1">{{ $student->name }}</h4>
                        @if($student->schoolClass)
                            <span class="badge bg-secondary">{{ $student->schoolClass->name }}</span>
                        @endif
                    </div>

                    <!-- Informações -->
                    <div class="student-info">
                        <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                            <i class="fas fa-envelope text-primary me-3"></i>
                            <div>
                                <div class="text-muted small">E-mail</div>
                                <div class="fw-medium">{{ $student->email }}</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                            <i class="fas fa-birthday-cake text-primary me-3"></i>
                            <div>
                                <div class="text-muted small">Idade</div>
                                <div class="fw-medium">{{ $student->age ?? 'N/A' }} anos</div>
                            </div>
                        </div>

                        @if($student->schoolClass && $student->schoolClass->teachers->count() > 0)
                        <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                            <i class="fas fa-chalkboard-teacher text-primary me-3"></i>
                            <div>
                                <div class="text-muted small">Professores da Turma</div>
                                <div class="fw-medium">
                                    {{ $student->schoolClass->teachers->pluck('name')->implode(', ') }}
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($student->schoolClass && $student->schoolClass->subjects->count() > 0)
                        <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                            <i class="fas fa-book text-primary me-3"></i>
                            <div>
                                <div class="text-muted small">Matérias da Turma</div>
                                <div class="fw-medium">
                                    @foreach($student->schoolClass->subjects->take(3) as $subject)
                                        <span class="badge bg-primary me-1">{{ $subject->name }}</span>
                                    @endforeach
                                    @if($student->schoolClass->subjects->count() > 3)
                                        <span class="badge bg-secondary">+{{ $student->schoolClass->subjects->count() - 3 }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                            <i class="fas fa-id-card text-primary me-3"></i>
                            <div>
                                <div class="text-muted small">ID do Estudante</div>
                                <div class="fw-medium">#{{ $student->id }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <style>
        .student-info {
            padding: 0.5rem;
        }
        .table th {
            border-top: none;
            font-weight: 600;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, 0.05);
        }
        .badge {
            font-size: 0.75em;
            padding: 0.4em 0.6em;
        }   
        .container {
            max-width: 1200px;
        }
        .btn-outline-primary:hover {
            background-color: #0d6efd;
            color: white;
        }
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }
    </style>
</x-app-layout>