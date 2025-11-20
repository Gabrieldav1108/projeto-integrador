<x-app-layout>
    @slot('title', 'Informações do aluno - ' . $student->name)
    <x-teacher-header/>

    <section class="container p-4 mt-5 rounded-4 mx-auto d-flex flex-column"
            style="background-color: #cfe2ff; max-width: 1200px; height: auto;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="text-center text-md-start mb-0">Informações do aluno</h2>
            <a href="javascript:history.back()" class="btn btn-secondary">
                ← Voltar para lista
            </a>
        </div>

        <!-- Container principal com display flex -->
        <div class="d-flex flex-column flex-lg-row gap-4">
            <!-- Coluna: Notas -->
            <div class="p-4 rounded-4"
                style="background:white; max-height:500px; overflow:auto;">
                <div class="bg-white rounded shadow-sm p-4 h-100">
                    <div class="mb-3">
                        <h5 class="text-center mb-2"><strong>Notas - {{ $subject->name }}</strong></h5>
                        <p class="text-center text-muted small mb-0">Clique em qualquer nota para editar</p>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col" class="text-center">Avaliação</th>
                                    <th scope="col" class="text-center">1º nota</th>
                                    <th scope="col" class="text-center">2º nota</th>
                                    <th scope="col" class="text-center">3º nota</th>
                                    <th scope="col" class="text-center">Média Trim</th>
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
                                    
                                    $subjectGrades = [
                                        'first_trimester' => [],
                                        'second_trimester' => [],
                                        'third_trimester' => []
                                    ];
                                    
                                    if (isset($grades['first_trimester'])) {
                                        $subjectGrades['first_trimester'] = array_filter($grades['first_trimester'], function($grade) use ($subject) {
                                            return isset($grade['subject_id']) && $grade['subject_id'] == $subject->id;
                                        });
                                    }
                                    
                                    if (isset($grades['second_trimester'])) {
                                        $subjectGrades['second_trimester'] = array_filter($grades['second_trimester'], function($grade) use ($subject) {
                                            return isset($grade['subject_id']) && $grade['subject_id'] == $subject->id;
                                        });
                                    }
                                    
                                    if (isset($grades['third_trimester'])) {
                                        $subjectGrades['third_trimester'] = array_filter($grades['third_trimester'], function($grade) use ($subject) {
                                            return isset($grade['subject_id']) && $grade['subject_id'] == $subject->id;
                                        });
                                    }
                                @endphp

                                <!-- Primeiro Trimestre -->
                                @if(count($subjectGrades['first_trimester']) > 0)
                                <tr>
                                    <th scope="row" class="text-center">1° Trim</th>
                                    @foreach($subjectGrades['first_trimester'] as $index => $grade)
                                        <td class="text-center">
                                            @if(isset($grade['id']))
                                                <a href="{{ route('teacher.grades.edit', ['studentId' => $student->id, 'gradeId' => $grade['id']]) }}" 
                                                class="btn btn-outline-primary btn-sm w-100 py-1"
                                                title="Clique para editar esta nota">
                                                    {{ number_format($grade['grade'], 1) }}
                                                </a>
                                            @else
                                                <a href="{{ route('teacher.grades.create', $student->id) }}?subject_id={{ $subject->id }}" 
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
                                    @for($i = $firstCount; $i < 3; $i++)
                                        <td class="text-center">
                                            <a href="{{ route('teacher.grades.create', $student->id) }}?subject_id={{ $subject->id }}" 
                                            class="btn btn-outline-secondary btn-sm w-100 py-1"
                                            title="Adicionar nota">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </td>
                                    @endfor
                                    <td class="text-center align-middle">
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
                                    <th scope="row" class="text-center">1° Trim</th>
                                    @for($i = 0; $i < 3; $i++)
                                        <td class="text-center">
                                            <a href="{{ route('teacher.grades.create', $student->id) }}?subject_id={{ $subject->id }}" 
                                            class="btn btn-outline-secondary btn-sm w-100 py-1"
                                            title="Adicionar nota">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </td>
                                    @endfor
                                    <td class="text-center align-middle">
                                        <strong>0.0</strong>
                                    </td>
                                </tr>
                                @endif

                                <!-- Segundo Trimestre -->
                                @if(count($subjectGrades['second_trimester']) > 0)
                                <tr>
                                    <th scope="row" class="text-center">2° Trim</th>
                                    @foreach($subjectGrades['second_trimester'] as $index => $grade)
                                        <td class="text-center">
                                            @if(isset($grade['id']))
                                                <a href="{{ route('teacher.grades.edit', ['studentId' => $student->id, 'gradeId' => $grade['id']]) }}" 
                                                class="btn btn-outline-primary btn-sm w-100 py-1"
                                                title="Clique para editar esta nota">
                                                    {{ number_format($grade['grade'], 1) }}
                                                </a>
                                            @else
                                                <a href="{{ route('teacher.grades.create', $student->id) }}?subject_id={{ $subject->id }}" 
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
                                    @for($i = $secondCount; $i < 3; $i++)
                                        <td class="text-center">
                                            <a href="{{ route('teacher.grades.create', $student->id) }}?subject_id={{ $subject->id }}" 
                                            class="btn btn-outline-secondary btn-sm w-100 py-1"
                                            title="Adicionar nota">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </td>
                                    @endfor
                                    <td class="text-center align-middle">
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
                                    <th scope="row" class="text-center">2° Trim</th>
                                    @for($i = 0; $i < 3; $i++)
                                        <td class="text-center">
                                            <a href="{{ route('teacher.grades.create', $student->id) }}?subject_id={{ $subject->id }}" 
                                            class="btn btn-outline-secondary btn-sm w-100 py-1"
                                            title="Adicionar nota">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </td>
                                    @endfor
                                    <td class="text-center align-middle">
                                        <strong>0.0</strong>
                                    </td>
                                </tr>
                                @endif

                                <!-- Terceiro Trimestre -->
                                @if(count($subjectGrades['third_trimester']) > 0)
                                <tr>
                                    <th scope="row" class="text-center">3° Trim</th>
                                    @foreach($subjectGrades['third_trimester'] as $index => $grade)
                                        <td class="text-center">
                                            @if(isset($grade['id']))
                                                <a href="{{ route('teacher.grades.edit', ['studentId' => $student->id, 'gradeId' => $grade['id']]) }}" 
                                                class="btn btn-outline-primary btn-sm w-100 py-1"
                                                title="Clique para editar esta nota">
                                                    {{ number_format($grade['grade'], 1) }}
                                                </a>
                                            @else
                                                <a href="{{ route('teacher.grades.create', $student->id) }}?subject_id={{ $subject->id }}" 
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
                                    @for($i = $thirdCount; $i < 3; $i++)
                                        <td class="text-center">
                                            <a href="{{ route('teacher.grades.create', $student->id) }}?subject_id={{ $subject->id }}" 
                                            class="btn btn-outline-secondary btn-sm w-100 py-1"
                                            title="Adicionar nota">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </td>
                                    @endfor
                                    <td class="text-center align-middle">
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
                                    <th scope="row" class="text-center">3° Trim</th>
                                    @for($i = 0; $i < 3; $i++)
                                        <td class="text-center">
                                            <a href="{{ route('teacher.grades.create', $student->id) }}?subject_id={{ $subject->id }}" 
                                            class="btn btn-outline-secondary btn-sm w-100 py-1"
                                            title="Adicionar nota">
                                                <i class="fas fa-plus"></i>
                                            </a>
                                        </td>
                                    @endfor
                                    <td class="text-center align-middle">
                                        <strong>0.0</strong>
                                    </td>
                                </tr>
                                @endif

                                <!-- Média Final -->
                                <tr class="table-secondary">
                                    <td colspan="4" class="text-end align-middle">
                                        <strong>Média final:</strong>
                                    </td>
                                    <td class="text-center align-middle">
                                        <strong class="fs-5">
                                            @php
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

            <!-- Coluna: Informações do Aluno -->
            
            <div class="flex-fill">
                <div class="p-4 rounded-4 bg-white" style="max-height: 500px; overflow: auto;">
                    <h5 class="text-center mb-4"><strong>Informações do aluno</strong></h5>

                    <!-- Foto e nome do aluno -->
                    <div class="text-center mb-4">
                        <x-student-avatar :student="$student" size="lg" vertical />
                        <h4 class="text-primary mt-3 mb-2">{{ $student->name }}</h4>
                        @if($student->schoolClass)
                            <span class="badge bg-secondary fs-6">{{ $student->schoolClass->name }}</span>
                        @endif
                    </div>

                    <!-- Informações -->
                    <div class="student-info">
                        <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                            <div class="flex-grow-1">
                                <div class="text-muted small">E-mail</div>
                                <div class="fw-medium text-break">{{ $student->email }}</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                            <div class="flex-grow-1">
                                <div class="text-muted small">Idade</div>
                                <div class="fw-medium">{{ $student->age ?? 'N/A' }} anos</div>
                            </div>
                        </div>

                        @if($student->schoolClass && $student->schoolClass->teachers->count() > 0)
                        <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                            <div class="flex-grow-1">
                                <div class="text-muted small">Professores da Turma</div>
                                <div class="fw-medium">
                                    {{ $student->schoolClass->teachers->pluck('name')->implode(', ') }}
                                </div>
                            </div>
                        </div>
                        @endif

                        @if($student->schoolClass && $student->schoolClass->subjects->count() > 0)
                        <div class="d-flex align-items-start mb-3 p-3 bg-light rounded">
                            <div class="flex-grow-1">
                                <div class="text-muted small mb-2">Matérias da Turma</div>
                                <div class="fw-medium">
                                    @foreach($student->schoolClass->subjects as $subject)
                                        <span class="badge bg-primary me-1 mb-1 d-inline-block">{{ $subject->name }}</span>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="d-flex align-items-center mb-3 p-3 bg-light rounded">
                            <div class="flex-grow-1">
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
        .btn-outline-primary:hover {
            background-color: #0d6efd;
            color: white;
        }
        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: white;
        }

        .custom-container {
            background-color: #cfe2ff;
            max-width: 1300px;   /* controla a largura */
            margin: 0 auto;      /* centraliza */
        }
        /* Garantir layout lado a lado */
        @media (min-width: 992px) {
            .row.fix {
                display: flex !important;
                flex-wrap: nowrap !important;
            }
            .row.fix > .col-lg-6 {
                width: 50% !important;
                max-width: 50% !important;
            }
        }
        
    </style>
</x-app-layout>