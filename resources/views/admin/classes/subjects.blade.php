<!-- resources/views/admin/classes/subjects.blade.php -->
<x-app-layout>
    @slot('title', 'Vincular Matérias - ' . $schoolClass->name)
    <x-admin-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2>Vincular Matérias - Turma: {{ $schoolClass->name }}</h2>
        
        <form action="{{ route('admin.classes.subjects.update', $schoolClass->id) }}" method="POST">
            @csrf
            @method('PUT')
            
            <div class="row">
                @foreach($subjects as $subject)
                <div class="col-md-4 mb-3">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" 
                               name="subjects[]" value="{{ $subject->id }}"
                               id="subject_{{ $subject->id }}"
                               {{ $schoolClass->subjects->contains($subject->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="subject_{{ $subject->id }}">
                            {{ $subject->name }}
                        </label>
                    </div>
                </div>
                @endforeach
            </div>
            
            <div class="mt-3">
                <button type="submit" class="btn btn-primary">Salvar Matérias</button>
                <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </section>
</x-app-layout>