<x-app-layout>
    @slot('title', 'Adicionar professor')
    <x-admin-header/>
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2 class="fw-bold mb-4">Adicionar Professor</h2>
        <form action="{{-- {{ route('admin.teachers.store') }} --}}#" method="POST">
            @csrf

            <!-- Name -->
            <div class="mb-3">
                <label for="name" class="form-label">Nome Completo</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            <!-- Email -->
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" name="email" id="email" class="form-control" required>
            </div>

            <!-- Subject -->
            <div class="mb-3">
                <label for="subject" class="form-label">Matéria</label>
                <select name="classes[]" id="classes" class="form-select" multiple size="1" onclick="this.size=5" onblur="this.size=1" style="transition: all 0.2s;">
                    <option value="class1">Materia 1</option>
                    <option value="class2">Materia 2</option>
                    <option value="class3">Materia 3</option>
                </select>            
            </div>

            <!-- Classes -->
            <div class="mb-3">
                <label for="classes" class="form-label">Turmas</label>
                <select name="classes[]" id="classes" class="form-select" multiple size="1" onclick="this.size=5" onblur="this.size=1" style="transition: all 0.2s;">
                    <option value="class1">Class 1</option>
                    <option value="class2">Class 2</option>
                    <option value="class3">Class 3</option>
                </select>
                <small class="text-muted">Pressione CTRL (ou Command ou Mac) para selecionar vários.</small>
            </div>

            <!-- Schedules -->
            <div class="mb-3">
                <label for="schedules" class="form-label">Hórarios da turma</label>
                <select name="schedules[]" id="schedules" class="form-select" multiple size="1" onclick="this.size=6" onblur="this.size=1">
                    <option value="monday-08-10">Monday 08:00-10:00</option>
                    <option value="monday-10-12">Monday 10:00-12:00</option>
                    <option value="wednesday-13-15">Wednesday 13:00-15:00</option>
                    <option value="wednesday-15-17">Wednesday 15:00-17:00</option>
                    <option value="friday-08-10">Friday 08:00-10:00</option>
                    <option value="friday-10-12">Friday 10:00-12:00</option>
                </select>
                <small class="text-muted">Clique para expandir e selecionar horários</small>
            </div>

            <!-- Buttons -->
            <button type="submit" class="btn btn-primary fw-bold">Salvar</button>
            <a href="{{ route('manageTeachers') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </section>
</x-app-layout>
