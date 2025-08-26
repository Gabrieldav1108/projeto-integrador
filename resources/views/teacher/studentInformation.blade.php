<x-app-layout>
    @slot('title', 'Informações do aluno')
    <x-header/>

    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2 class="text-center text-md-start mb-4">Informações do aluno</h2>

        <div class="row rounded p-4 g-4 justify-content-center">
            <!-- Coluna: Notas -->
            <div class="col-12 col-lg-5 d-flex flex-column mb-4 mb-lg-0">
                <div class="bg-white rounded shadow-sm p-3 h-100">
                    <h5 class="text-center mb-3"><strong>Notas</strong></h5>

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
                                <tr>
                                    <th scope="row">1° Trim</th>
                                    <td><a href="{{route('editGrade')}}" class="btn btn-link p-0 text-decoration-none">8.5</a></td>
                                    <td><a href="{{route('editGrade')}}" class="btn btn-link p-0 text-decoration-none">7.8</a></td>
                                    <td><a href="{{route('editGrade')}}" class="btn btn-link p-0 text-decoration-none">9.2</a></td>
                                    <td>25.5</td>
                                </tr>
                                <tr>
                                    <th scope="row">2° Bim</th>
                                    <td><a href="{{route('editGrade')}}" class="btn btn-link p-0 text-decoration-none">6.7</a></td>
                                    <td><a href="{{route('editGrade')}}" class="btn btn-link p-0 text-decoration-none">8.9</a></td>
                                    <td><a href="{{route('editGrade')}}" class="btn btn-link p-0 text-decoration-none">7.5</a></td>
                                    <td>23.1</td>
                                </tr>
                                <tr>
                                    <th scope="row">3° Trim</th>
                                    <td><a href="{{route('editGrade')}}" class="btn btn-link p-0 text-decoration-none">9.0</a></td>
                                    <td><a href="{{route('editGrade')}}" class="btn btn-link p-0 text-decoration-none">8.2</a></td>
                                    <td><a href="{{route('editGrade')}}" class="btn btn-link p-0 text-decoration-none">9.5</a></td>
                                    <td>26.7</td>
                                </tr>
                                <tr class="table-secondary">
                                    <td colspan="4" class="text-end"><strong>Média final:</strong></td>
                                    <td><strong>8.4</strong></td>
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

                    <!-- Informações -->
                    <div class="student-info">
                        <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                            <div>
                                <div class="text-muted small">E-mail</div>
                                <div class="fw-medium">maria@escola.com</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                            <div>
                                <div class="text-muted small">Idade</div>
                                <div class="fw-medium">17 anos</div>
                            </div>
                        </div>
                        
                        <div class="d-flex align-items-center mb-3 p-2 bg-light rounded">
                            <div>
                                <div class="text-muted small">Turma</div>
                                <div class="fw-medium">Turma A - Manhã</div>
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
    </style>
</x-app-layout>