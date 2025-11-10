<x-app-layout>
    @slot('title', 'Perfil do Usuário')
    <style>
        .card-custom {
            background-color: #e1efff;
            border: 1px solid #00000022;
            border-radius: 12px;
        }
        .profile-img, .profile-img-preview {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid #007bff;
            margin-bottom: 1rem;
        }
        .role-badge {
            font-size: 0.8rem;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
        }
        .role-admin { background-color: #dc3545; color: white; }
        .role-teacher { background-color: #0d6efd; color: white; }
        .role-student { background-color: #198754; color: white; }
    </style>

    <!-- Header condicional baseado no role -->
    @if($user->role === 'admin')
        <x-admin-header/>
    @elseif($user->role === 'teacher')
        <x-teacher-header/>
    @else
        <x-student-header/>
    @endif

    <div class="container my-5">
        <div class="p-5 rounded-4 card-custom shadow">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="fw-bold mb-0">Meu Perfil</h2>
                <span class="role-badge role-{{ $user->role }}">
                    @switch($user->role)
                        @case('admin') Administrador @break
                        @case('teacher') Professor @break
                        @case('student') Estudante @break
                    @endswitch
                </span>
            </div>
            
            <!-- Mensagens de sucesso -->
            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row g-4">
                <!-- Cartão: Informações Pessoais -->
                <div class="col-md-6 d-flex">
                    <div class="p-4 card-custom shadow w-100 d-flex flex-column justify-content-between">
                        <div>
                            <div class="d-flex justify-content-center">
                                <img src="{{ $user->foto_url }}" alt="Foto de perfil" class="profile-img-preview">
                            </div>
                            <h5 class="fw-bold mb-3 text-center">Informações Pessoais</h5>
                            <p><strong>Nome:</strong> {{ $user->name }}</p>
                            <p><strong>Email:</strong> {{ $user->email }}</p>
                            <p><strong>ID do Usuário:</strong> #{{ $user->id }}</p>
                            <p><strong>Conta criada em:</strong> {{ $user->created_at->format('d/m/Y') }}</p>
                            <p><strong>Tipo de Conta:</strong> 
                                <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : ($user->role === 'teacher' ? 'primary' : 'success') }}">
                                    @if($user->role === 'admin') Administrador
                                    @elseif($user->role === 'teacher') Professor
                                    @else Estudante
                                    @endif
                                </span>
                            </p>
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('profile.edit') }}" class="btn btn-primary">Editar Perfil</a>
                        </div>
                    </div>
                </div>

                <!-- Cartão: Estatísticas Específicas por Role -->
                <div class="col-md-6 d-flex">
                    <div class="p-4 card-custom shadow w-100 d-flex flex-column justify-content-between">
                        <div>
                            <h5 class="fw-bold mb-3 text-center">
                                @if($user->role === 'admin')
                                    Estatísticas do Sistema
                                @elseif($user->role === 'teacher')
                                    Minhas Turmas
                                @else
                                    Meu Progresso
                                @endif
                            </h5>
                            
                            <!-- Conteúdo Dinâmico por Tipo de Usuário -->
                            @if($user->role === 'admin')
                                <!-- Estatísticas para Admin -->
                                <p><strong>Total de Usuários:</strong> {{ $stats['total_users'] ?? 0 }}</p>
                                <p><strong>Total de Turmas:</strong> {{ $stats['total_classes'] ?? 0 }}</p>
                                <p><strong>Professores Cadastrados:</strong> {{ $stats['total_teachers'] ?? 0 }}</p>
                                <p><strong>Estudantes Cadastrados:</strong> {{ $stats['total_students'] ?? 0 }}</p>
                                
                            @elseif($user->role === 'teacher')
                                <!-- Estatísticas para Professor -->
                                @php
                                    // Usa os novos métodos personalizados
                                    $teacherClasses = $user->getTeachingClasses();
                                    $totalClasses = $teacherClasses->count();
                                    $totalStudents = $user->total_students;
                                    $mainSubject = $user->main_subject;
                                @endphp
                                
                                <p><strong>Turmas Ativas:</strong> 
                                    @if($totalClasses > 0)
                                        {{ $totalClasses }}
                                    @else
                                        <span class="text-warning">Nenhuma turma atribuída</span>
                                    @endif
                                </p>
                                
                                <p><strong>Total de Alunos:</strong> 
                                    @if($totalStudents > 0)
                                        {{ $totalStudents }}
                                    @else
                                        <span class="text-muted">0</span>
                                    @endif
                                </p>
                                
                                <p><strong>Próxima Aula:</strong> 
                                    @if($totalClasses > 0)
                                        <a href="{{ route('teacher.schedules') }}">Ver horários</a>
                                    @else
                                        <span class="text-muted">Nenhuma turma</span>
                                    @endif
                                </p>
                                
                                <p><strong>Disciplina Principal:</strong> 
                                    @if($mainSubject)
                                        <span class="badge bg-primary me-1">{{ $mainSubject->name }}</span>
                                    @else
                                        <span class="text-warning">Nenhuma disciplina atribuída</span>
                                    @endif
                                </p>
                                
                                <!-- Mostra as turmas específicas se houver -->
                                @if($totalClasses > 0)
                                    <div class="mt-3">
                                        <strong>Turmas:</strong>
                                        <ul class="list-unstyled mt-2">
                                            @foreach($teacherClasses as $class)
                                                <li>
                                                    <i class="fas fa-chalkboard me-2"></i>
                                                    {{ $class->name }} 
                                                    <span class="badge bg-secondary ms-2">{{ $class->students_count }} alunos</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                
                            @else
                                <!-- Estatísticas para Estudante -->
                                @php
                                    $studentClasses = $user->classes ? $user->classes->count() : 0;
                                    $completedAssignments = 0;
                                    $averageGrade = 'N/A';
                                @endphp
                                
                                <p><strong>Turmas Matriculadas:</strong> {{ $studentClasses }}</p>
                                <p><strong>Tarefas Concluídas:</strong> {{ $completedAssignments }}</p>
                                <p><strong>Média Geral:</strong> {{ $averageGrade }}</p>
                                <p><strong>Próxima Aula:</strong> 
                                    @if($studentClasses > 0)
                                        <a href="{{ route('student.schedules.index') }}">Ver horários</a>
                                    @else
                                        <span class="text-muted">Nenhuma turma</span>
                                    @endif
                                </p>
                            @endif
                        </div>
                        <div class="text-center mt-3">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="btn btn-danger">Sair da Conta</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Seção de Ações Rápidas por Role -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="p-4 card-custom shadow">
                        <h5 class="fw-bold mb-3">Ações Rápidas</h5>
                        <div class="row g-3">
                            @if($user->role === 'admin')
                                <div class="col-md-3">
                                    <a href="{{ route('admin.students.index') }}" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-users"></i> Gerenciar Estudantes
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('admin.teachers.index') }}" class="btn btn-outline-success w-100">
                                        <i class="fas fa-chalkboard-teacher"></i> Gerenciar Professores
                                    </a>
                                </div>
                                <div class="col-md-3">
                                    <a href="{{ route('admin.classes.index') }}" class="btn btn-outline-info w-100">
                                        <i class="fas fa-chalkboard"></i> Gerenciar Turmas
                                    </a>
                                </div>

                                
                            @elseif($user->role === 'teacher')
                                <div class="col-md-4">
                                    <a href="{{ route('teacher.classes.index') }}" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-chalkboard"></i> Minhas Turmas
                                    </a>
                                </div>
                                <div class="col-md-4">
                                    <a href="{{ route('teacher.schedules') }}" class="btn btn-outline-success w-100">
                                        <i class="fas fa-calendar-alt"></i> Meus Horários
                                    </a>
                                </div>
                            @else
                                <div class="col-md-6">
                                    <a href="{{ route('student.classes.index') }}" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-chalkboard"></i> Minhas Turmas
                                    </a>
                                </div>
                                <div class="col-md-6">
                                    <a href="{{ route('student.grades.index') }}" class="btn btn-outline-success w-100">
                                        <i class="fas fa-chart-line"></i> Meu Desempenho
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>