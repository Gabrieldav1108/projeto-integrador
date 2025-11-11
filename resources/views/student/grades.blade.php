<x-app-layout>
    @slot('title', 'Notas')
    <x-student-header/>
    
    <section class="container py-5">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <!-- Header com título e informações -->
                <div class="text-center mb-5">
                    @if($subjectId)
                        @php
                            $currentSubject = $subjects->first();
                        @endphp
                        <h1 class="display-6 fw-bold text-primary mb-3">📊 Notas de {{ $currentSubject->name }}</h1>
                        @if($currentSubject->teachers->first())
                            <p class="text-muted fs-5">
                                <i class="fas fa-chalkboard-teacher me-2"></i>
                                Professor: {{ $currentSubject->teachers->first()->user->name ?? $currentSubject->teachers->first()->name }}
                            </p>
                        @endif
                    @else
                        <h1 class="display-6 fw-bold text-primary mb-3">📚 Minhas Notas</h1>
                        <p class="text-muted fs-5">Acompanhe seu desempenho em todas as matérias</p>
                    @endif
                </div>

                @if($subjects->count() > 0)
                    @foreach($subjects as $subject)
                        @if(!$subjectId || $subject->id == $subjectId)
                            <!-- Card da Matéria -->
                            <div class="card shadow-lg border-0 mb-5">
                                <div class="card-header bg-gradient-primary text-white py-4">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="h4 mb-1">
                                                <i class="fas fa-book me-2"></i>
                                                {{ $subject->name }}
                                            </h3>
                                            @if($subject->description)
                                                <p class="mb-0 opacity-75">{{ $subject->description }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-body p-0">
                                    <!-- Tabela de Notas -->
                                    <div class="table-responsive">
                                        <table class="table table-hover mb-0">
                                            <thead class="table-light">
                                                <tr>
                                                    <th class="border-0 ps-4" style="width: 25%;">
                                                        <i class="fas fa-tasks me-2"></i>
                                                        Avaliação
                                                    </th>
                                                    <th class="text-center border-0" style="width: 25%;">
                                                        <div class="d-flex flex-column">
                                                            <span>📅 1º Trimestre</span>
                                                            <small class="text-muted">Fev - Abr</small>
                                                        </div>
                                                    </th>
                                                    <th class="text-center border-0" style="width: 25%;">
                                                        <div class="d-flex flex-column">
                                                            <span>📅 2º Trimestre</span>
                                                            <small class="text-muted">Mai - Jul</small>
                                                        </div>
                                                    </th>
                                                    <th class="text-center border-0" style="width: 25%;">
                                                        <div class="d-flex flex-column">
                                                            <span>📅 3º Trimestre</span>
                                                            <small class="text-muted">Ago - Nov</small>
                                                        </div>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    // Organizar as notas por trimestre
                                                    $firstTrimester = $grades[$subject->id]['first_trimester'] ?? ($grades['first_trimester'] ?? collect());
                                                    $secondTrimester = $grades[$subject->id]['second_trimester'] ?? ($grades['second_trimester'] ?? collect());
                                                    $thirdTrimester = $grades[$subject->id]['third_trimester'] ?? ($grades['third_trimester'] ?? collect());
                                                    
                                                    // Calcular totais e médias
                                                    $firstTotal = $firstTrimester->sum('grade');
                                                    $secondTotal = $secondTrimester->sum('grade');
                                                    $thirdTotal = $thirdTrimester->sum('grade');
                                                    
                                                    $firstAverage = $firstTrimester->count() > 0 ? $firstTotal / $firstTrimester->count() : 0;
                                                    $secondAverage = $secondTrimester->count() > 0 ? $secondTotal / $secondTrimester->count() : 0;
                                                    $thirdAverage = $thirdTrimester->count() > 0 ? $thirdTotal / $thirdTrimester->count() : 0;
                                                    
                                                    // Média final
                                                    $trimestersWithGrades = 0;
                                                    $finalAverage = 0;
                                                    if ($firstAverage > 0) { $trimestersWithGrades++; $finalAverage += $firstAverage; }
                                                    if ($secondAverage > 0) { $trimestersWithGrades++; $finalAverage += $secondAverage; }
                                                    if ($thirdAverage > 0) { $trimestersWithGrades++; $finalAverage += $thirdAverage; }
                                                    $finalAverage = $trimestersWithGrades > 0 ? $finalAverage / $trimestersWithGrades : 0;
                                                    
                                                    // Determinar cor da média final
                                                    $finalAverageColor = $finalAverage >= 7 ? 'success' : ($finalAverage >= 5 ? 'warning' : 'danger');
                                                @endphp

                                                <!-- Linha das avaliações individuais -->
                                                @for($i = 0; $i < max($firstTrimester->count(), $secondTrimester->count(), $thirdTrimester->count(), 3); $i++)
                                                    <tr class="align-middle">
                                                        <td class="ps-4">
                                                            @if(isset($firstTrimester[$i]) || isset($secondTrimester[$i]) || isset($thirdTrimester[$i]))
                                                                @php
                                                                    $grade = $firstTrimester[$i] ?? $secondTrimester[$i] ?? $thirdTrimester[$i];
                                                                @endphp
                                                                <small class="text-muted">{{ $grade->assessment_name ?? 'Avaliação ' . ($i + 1) }}</small>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if(isset($firstTrimester[$i]))
                                                                <span class="badge bg-primary rounded-pill fs-6 px-3 py-2">
                                                                    {{ number_format($firstTrimester[$i]->grade, 1) }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if(isset($secondTrimester[$i]))
                                                                <span class="badge bg-info rounded-pill fs-6 px-3 py-2">
                                                                    {{ number_format($secondTrimester[$i]->grade, 1) }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if(isset($thirdTrimester[$i]))
                                                                <span class="badge bg-warning rounded-pill fs-6 px-3 py-2 text-dark">
                                                                    {{ number_format($thirdTrimester[$i]->grade, 1) }}
                                                                </span>
                                                            @else
                                                                <span class="text-muted">-</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endfor

                                                <!-- Linha de separação -->
                                                <tr>
                                                    <td colspan="4" class="p-0">
                                                        <hr class="my-2">
                                                    </td>
                                                </tr>

                                                <!-- Linha dos totais -->
                                                <tr class="table-active">
                                                    <td class="ps-4 fw-bold">
                                                        <i class="fas fa-calculator me-2"></i>
                                                        Total do Trimestre
                                                    </td>
                                                    <td class="text-center fw-bold fs-5 text-primary">
                                                        {{ number_format($firstTotal, 1) }}
                                                    </td>
                                                    <td class="text-center fw-bold fs-5 text-info">
                                                        {{ number_format($secondTotal, 1) }}
                                                    </td>
                                                    <td class="text-center fw-bold fs-5 text-warning">
                                                        {{ number_format($thirdTotal, 1) }}
                                                    </td>
                                                </tr>

                                                <!-- Linha das médias -->
                                                <tr class="table-light">
                                                    <td class="ps-4 fw-bold">
                                                        <i class="fas fa-chart-line me-2"></i>
                                                        Média do Trimestre
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-primary rounded-pill fs-6 px-3 py-2">
                                                            {{ number_format($firstAverage, 1) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-info rounded-pill fs-6 px-3 py-2">
                                                            {{ number_format($secondAverage, 1) }}
                                                        </span>
                                                    </td>
                                                    <td class="text-center">
                                                        <span class="badge bg-warning rounded-pill fs-6 px-3 py-2 text-dark">
                                                            {{ number_format($thirdAverage, 1) }}
                                                        </span>
                                                    </td>
                                                </tr>

                                                <!-- Linha da média final -->
                                                <tr class="table-success">
                                                    <td colspan="3" class="ps-4 fw-bold border-0">
                                                        <i class="fas fa-trophy me-2"></i>
                                                        Média Final
                                                    </td>
                                                    <td class="text-center border-0">
                                                        <span class="badge bg-{{ $finalAverageColor }} rounded-pill fs-4 px-4 py-3">
                                                            {{ number_format($finalAverage, 1) }}
                                                        </span>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                    <!-- Status de Aprovação -->
                                    <div class="card-footer bg-light border-0">
                                        <div class="row align-items-center">
                                            <div class="col-md-8">
                                                <h6 class="mb-1">Status:</h6>
                                                @if($finalAverage >= 7)
                                                    <span class="badge bg-success fs-6">
                                                        <i class="fas fa-check-circle me-1"></i>
                                                        Aprovado
                                                    </span>
                                                @elseif($finalAverage >= 5)
                                                    <span class="badge bg-warning fs-6 text-dark">
                                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                                        Recuperação
                                                    </span>
                                                @else
                                                    <span class="badge bg-danger fs-6">
                                                        <i class="fas fa-times-circle me-1"></i>
                                                        Reprovado
                                                    </span>
                                                @endif
                                            </div>
                                            <div class="col-md-4 text-md-end">
                                                <small class="text-muted">
                                                    <i class="fas fa-clock me-1"></i>
                                                    Última atualização: {{ now()->format('d/m/Y') }}
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                @else
                    <!-- Estado vazio -->
                    <div class="text-center py-5">
                        <div class="empty-state">
                            <i class="fas fa-clipboard-list fa-4x text-muted mb-4"></i>
                            <h3 class="text-muted">Nenhuma nota disponível</h3>
                            <p class="text-muted mb-4">Você não está matriculado em nenhuma matéria ou não há notas lançadas.</p>
                            <a href="{{ route('student.home') }}" class="btn btn-primary btn-lg">
                                <i class="fas fa-home me-2"></i>
                                Voltar ao Início
                            </a>
                        </div>
                    </div>
                @endif

                <!-- Navegação -->
                <div class="d-flex justify-content-between mt-4">
                    @if($subjectId)
                        <a href="{{ route('student.subject.show', $subjectId) }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Voltar para a Matéria
                        </a>
                    @else
                        <a href="{{ route('student.home') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-2"></i>
                            Voltar para o Início
                        </a>
                    @endif
                    
                    <button onclick="window.print()" class="btn btn-outline-secondary">
                        <i class="fas fa-print me-2"></i>
                        Imprimir Boletim
                    </button>
                </div>
            </div>
        </div>
    </section>

    <style>
        .bg-gradient-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .card {
            border-radius: 1rem;
            overflow: hidden;
        }
        
        .table th {
            font-weight: 600;
            border-bottom: 2px solid #dee2e6;
        }
        
        .table td {
            padding: 1rem 0.75rem;
            vertical-align: middle;
        }
        
        .empty-state {
            padding: 3rem 1rem;
        }
        
        .badge {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        @media (max-width: 768px) {
            .table-responsive {
                font-size: 0.875rem;
            }
            
            .badge {
                font-size: 0.75rem !important;
                padding: 0.4rem 0.8rem !important;
            }
        }
        
        .shadow-lg {
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175) !important;
        }
    </style>
</x-app-layout>