{{-- resources/views/teacher/grades/edit.blade.php --}}
<x-app-layout>
    @slot('title', 'Editar nota - ' . $grade->assessment_name)
    <x-teacher-header/>

    <section class="container p-3 mt-5 rounded-4 mx-auto" style="background-color: #cfe2ff; max-width: 600px; width: 100%;">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="bold mb-0">Editar nota</h2>
            <a href="{{ route('teacher.students.show', $student->id) }}" class="btn btn-secondary">
                ← Voltar
            </a>
        </div>

        <div class="rounded p-4">
            <div class="border rounded p-4 bg-white">
                <form method="POST" action="{{ route('teacher.grades.update', ['studentId' => $student->id, 'gradeId' => $grade->id]) }}" class="form-control d-flex justify-content-center align-items-center flex-column p-4">
                    @csrf
                    @method('PUT')
                    
                    <h5 class="text-center fs-2 mb-4"><strong>Editar Nota</strong></h5>
                    
                    <div class="alert alert-info text-center w-100">
                        <strong class="fs-5">Aluno: {{ $student->name }}</strong><br>
                        <strong class="fs-6">Avaliação: {{ $grade->assessment_name }}</strong><br>
                        <strong class="fs-6">Valor atual: {{ number_format($grade->grade, 1) }}</strong>
                    </div>

                    <input type="hidden" name="subject_id" value="{{ $subject->id }}">

                    <div class="w-100 mb-3">
                        <label class="form-label">Trimestre</label>
                        <select name="trimester" class="form-select" required>
                            <option value="first_trimester" {{ $grade->trimester == 'first_trimester' ? 'selected' : '' }}>1º Trimestre</option>
                            <option value="second_trimester" {{ $grade->trimester == 'second_trimester' ? 'selected' : '' }}>2º Trimestre</option>
                            <option value="third_trimester" {{ $grade->trimester == 'third_trimester' ? 'selected' : '' }}>3º Trimestre</option>
                        </select>
                    </div>

                    <div class="w-100 mb-3">
                        <label class="form-label">Nome da Avaliação</label>
                        <input type="text" name="assessment_name" class="form-control" value="{{ old('assessment_name', $grade->assessment_name) }}" required>
                    </div>

                    <div class="w-100 mb-4">
                        <label class="form-label">Nota (0-10)</label>
                        <input type="number" name="grade" class="form-control" step="0.1" min="0" max="10" 
                               value="{{ old('grade', $grade->grade) }}" required>
                    </div>

                    <div class="w-100 mb-4">
                        <label class="form-label">Data da Avaliação (Opcional)</label>
                        <input type="date" name="assessment_date" class="form-control" 
                               value="{{ old('assessment_date', $grade->assessment_date ? $grade->assessment_date->format('Y-m-d') : '') }}">
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

                    <button type="submit" class="btn btn-primary btn-lg w-100">Atualizar Nota</button>
                </form>
            </div>
        </div>
    </section>
</x-app-layout>