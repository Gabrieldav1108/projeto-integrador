{{-- resources/views/teacher/grades/create.blade.php --}}
<x-app-layout>
    @slot('title', 'Adicionar nota - ' . $student->name)
    <x-teacher-header/>

    <section class="container p-3 mt-5 rounded-4 mx-auto" style="background-color: #cfe2ff; max-width: 600px; width: 100%;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="bold mb-0">Adicionar Nova Nota</h2>
            <a href="{{ route('teacher.students.show', $student->id) }}" class="btn btn-secondary">
                ← Voltar
            </a>
        </div>

        <div class="rounded p-4">
            <div class="border rounded p-4 bg-white">
                <form method="POST" action="{{ route('teacher.grades.store', $student->id) }}" class="form-control d-flex justify-content-center align-items-center flex-column p-4">
                    @csrf
                    
                    <h5 class="text-center fs-2 mb-4"><strong>Nova Nota</strong></h5>
                    
                    <div class="alert alert-info text-center w-100">
                        <strong class="fs-5">Aluno: {{ $student->name }}</strong>
                        @if(isset($subject))
                            <br><strong class="fs-6">Matéria: {{ $subject->name }}</strong>
                            <input type="hidden" name="subject_id" value="{{ $subject->id }}">
                        @endif
                    </div>

                    @if(!isset($subject))
                    <div class="alert alert-danger text-center">
                        <strong>Erro: Nenhuma matéria encontrada para este professor.</strong>
                    </div>
                    @endif

                    <div class="w-100 mb-3">
                        <label class="form-label">Trimestre</label>
                        <select name="trimester" class="form-select" required>
                            <option value="">Selecione o trimestre</option>
                            <option value="first_trimester" {{ old('trimester') == 'first_trimester' ? 'selected' : '' }}>1º Trimestre</option>
                            <option value="second_trimester" {{ old('trimester') == 'second_trimester' ? 'selected' : '' }}>2º Trimestre</option>
                            <option value="third_trimester" {{ old('trimester') == 'third_trimester' ? 'selected' : '' }}>3º Trimestre</option>
                        </select>
                    </div>

                    <div class="w-100 mb-3">
                        <label class="form-label">Nome da Avaliação</label>
                        <input type="text" name="assessment_name" class="form-control" value="{{ old('assessment_name') }}" 
                               placeholder="Ex: Prova Bimestral, Trabalho em Grupo" required>
                    </div>

                    <div class="w-100 mb-3">
                        <label class="form-label">Nota (0-10)</label>
                        <input type="number" name="grade" class="form-control" step="0.1" min="0" max="10" 
                               value="{{ old('grade') }}" placeholder="0.0" required>
                    </div>

                    <div class="w-100 mb-4">
                        <label class="form-label">Data da Avaliação (Opcional)</label>
                        <input type="date" name="assessment_date" class="form-control" value="{{ old('assessment_date') }}">
                    </div>

                    @if($errors->any())
                        <div class="alert alert-danger w-100">
                            <ul class="mb-0">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if(isset($subject))
                        <button type="submit" class="btn btn-primary btn-lg w-100">Adicionar Nota</button>
                    @else
                        <button type="button" class="btn btn-secondary btn-lg w-100" disabled>Nenhuma Matéria Disponível</button>
                    @endif
                </form>
            </div>
        </div>
    </section>
</x-app-layout>