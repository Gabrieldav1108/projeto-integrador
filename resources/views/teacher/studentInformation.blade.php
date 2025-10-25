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
                    <h5 class="text-center mb-3"><strong>Notas</strong></h5>
                    <p class="text-center text-muted small mb-3">Clique em qualquer nota para editar</p>

                    <div class="table-responsive mt-2">
                        <table class="table table-bordered table-hover mb-0">
                            <thead class="table-primary">
                                <tr>
                                    <th scope="col">Avaliação</th>
                                    <th scope="col">1º nota</th>
                                    <th scope="col">2º nota</th>
                                    <th scope="col">3º nota</th>
                                    <th scope="col">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $firstTotal = 0;
                                    $secondTotal = 0;
                                    $thirdTotal = 0;
                                @endphp

                                @if(isset($grades['first_trimester']))
                                <tr>
                                    <th scope="row">1° Trim</th>
                                    @foreach($grades['first_trimester'] as $index => $grade)
                                        <td>
                                            <a href="{{ route('teacher.grades.index') }}" 
                                               class="btn btn-outline-primary btn-sm w-100 py-1"
                                               title="Clique para editar esta nota">
                                                {{ $grade['grade'] }}
                                            </a>
                                        </td>
                                        @php $firstTotal += $grade['grade']; @endphp
                                    @endforeach
                                    <td class="align-middle">
                                        <strong>{{ number_format($firstTotal, 1) }}</strong>
                                    </td>
                                </tr>
                                @endif

                                @if(isset($grades['second_trimester']))
                                <tr>
                                    <th scope="row">2° Bim</th>
                                    @foreach($grades['second_trimester'] as $index => $grade)
                                        <td>
                                            <a href="{{ route('teacher.grades.index') }}" 
                                               class="btn btn-outline-primary btn-sm w-100 py-1"
                                               title="Clique para editar esta nota">
                                                {{ $grade['grade'] }}
                                            </a>
                                        </td>
                                        @php $secondTotal += $grade['grade']; @endphp
                                    @endforeach
                                    <td class="align-middle">
                                        <strong>{{ number_format($secondTotal, 1) }}</strong>
                                    </td>
                                </tr>
                                @endif

                                @if(isset($grades['third_trimester']))
                                <tr>
                                    <th scope="row">3° Trim</th>
                                    @foreach($grades['third_trimester'] as $index => $grade)
                                        <td>
                                            <a href="{{ route('teacher.grades.index') }}" 
                                               class="btn btn-outline-primary btn-sm w-100 py-1"
                                               title="Clique para editar esta nota">
                                                {{ $grade['grade'] }}
                                            </a>
                                        </td>
                                        @php $thirdTotal += $grade['grade']; @endphp
                                    @endforeach
                                    <td class="align-middle">
                                        <strong>{{ number_format($thirdTotal, 1) }}</strong>
                                    </td>
                                </tr>
                                @endif

                                <tr class="table-secondary">
                                    <td colspan="4" class="text-end align-middle">
                                        <strong>Média final:</strong>
                                    </td>
                                    <td class="align-middle">
                                        <strong class="fs-5">
                                            @php
                                                $totalGrades = $firstTotal + $secondTotal + $thirdTotal;
                                                $average = $totalGrades > 0 ? $totalGrades / 3 : 0;
                                            @endphp
                                            {{ number_format($average, 1) }}
                                        </strong>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Coluna: Informações do aluno -->
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
                                <div class="fw-medium">{{ $student->age }} anos</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                            <i class="fas fa-users text-primary me-3"></i>
                            <div>
                                <div class="text-muted small">Turma</div>
                                <div class="fw-medium">
                                    {{ $student->schoolClass ? $student->schoolClass->name : 'N/A' }}
                                    @if($student->schoolClass && $student->schoolClass->numberClass)
                                        - {{ $student->schoolClass->numberClass }}
                                    @endif
                                </div>
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
    </style>
</x-app-layout>