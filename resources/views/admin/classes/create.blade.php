<x-app-layout>
    @slot('title', 'Adicionar Turma')
    <style>
        .selected-items {
            background-color: #f8f9fa;
            border-radius: 5px;
            padding: 10px;
            margin-top: 10px;
            min-height: 44px;
        }
        .selected-item {
            display: inline-block;
            background-color: #e9ecef;
            padding: 5px 10px;
            margin: 3px;
            border-radius: 20px;
            font-size: 0.9rem;
        }
        .selected-item .remove {
            cursor: pointer;
            margin-left: 5px;
            color: #6c757d;
        }
        .selected-item .remove:hover {
            color: #dc3545;
        }
        .select-all {
            cursor: pointer;
            padding: 5px 10px;
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }
        .select-all:hover {
            background-color: #e9ecef;
        }
        .dropdown-section {
            margin-bottom: 20px;
        }
        .dropdown-section h6 {
            color: #495057;
            margin-bottom: 10px;
        }
    </style>
    <x-admin-header/>
    
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2 class="fw-bold mb-4">Adicionar Turma</h2>
        
        <form action="{{ route('admin.classes.store') }}" method="POST">
            @csrf

            {{-- Nome da Turma --}}
            <div class="mb-3">
                <label for="name" class="form-label">Nome da Turma</label>
                <input type="text" name="name" id="name" class="form-control" required>
            </div>

            {{-- Número da Turma --}}
            <div class="mb-3">
                <label for="numberClass" class="form-label">Número da Turma</label>
                <input type="number" name="numberClass" id="numberClass" class="form-control" required>
            </div>
            
            {{-- Seleção de Professores --}}
            <div class="dropdown-section">
                <h6>Professores</h6>
                <div class="mb-3">
                    <label for="teachers" class="form-label">Selecione um ou mais professores</label>
                    <div class="dropdown">
                        <button class="form-select text-start" type="button" id="dropdownTeachersButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="selectedTeachersText">Selecione os professores...</span>
                        </button>
                        <div class="dropdown-menu w-100" aria-labelledby="dropdownTeachersButton">
                            <div class="select-all" onclick="toggleSelectAll('teachers')">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAllTeachers">
                                    <label class="form-check-label" for="selectAllTeachers">Selecionar todos</label>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="px-3">
                                <input type="text" class="form-control mb-2" placeholder="Buscar professor..." id="searchTeacher">
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="teacher-list" style="max-height: 200px; overflow-y: auto;">
                                <div class="list-group">
                                    @foreach($teachers as $teacher)
                                        <label class="list-group-item">
                                            <input class="form-check-input me-2 teacher-checkbox" type="checkbox" name="teachers[]" value="{{ $teacher->id }}">
                                            {{ $teacher->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="selected-items mt-2" id="selectedTeachersItems"></div>
                    <input type="hidden" name="teachers_ids" id="teachersIds">
                </div>
            </div>

            {{-- Seleção de Matérias --}}
            <div class="dropdown-section">
                <h6>Matérias</h6>
                <div class="mb-3">
                    <label for="subjects" class="form-label">Selecione uma ou mais matérias</label>
                    <div class="dropdown">
                        <button class="form-select text-start" type="button" id="dropdownSubjectsButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <span id="selectedSubjectsText">Selecione as matérias...</span>
                        </button>
                        <div class="dropdown-menu w-100" aria-labelledby="dropdownSubjectsButton">
                            <div class="select-all" onclick="toggleSelectAll('subjects')">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="selectAllSubjects">
                                    <label class="form-check-label" for="selectAllSubjects">Selecionar todos</label>
                                </div>
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="px-3">
                                <input type="text" class="form-control mb-2" placeholder="Buscar matéria..." id="searchSubject">
                            </div>
                            <div class="dropdown-divider"></div>
                            <div class="subject-list" style="max-height: 200px; overflow-y: auto;">
                                <div class="list-group">
                                    @foreach($subjects as $subject)
                                        <label class="list-group-item">
                                            <input class="form-check-input me-2 subject-checkbox" type="checkbox" name="subjects[]" value="{{ $subject->id }}">
                                            {{ $subject->name }}
                                            @if($subject->description)
                                                <small class="text-muted d-block">- {{ $subject->description }}</small>
                                            @endif
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="selected-items mt-2" id="selectedSubjectsItems"></div>
                    <input type="hidden" name="subjects_ids" id="subjectsIds">
                </div>
            </div>

            <button type="submit" class="btn btn-primary fw-bold">Salvar</button>
            <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Inicializar seleções
            updateSelectedTeachers();
            updateSelectedSubjects();

            // Buscar professores
            document.getElementById('searchTeacher').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const items = document.querySelectorAll('.teacher-list .list-group-item');
                
                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });

            // Buscar matérias
            document.getElementById('searchSubject').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const items = document.querySelectorAll('.subject-list .list-group-item');
                
                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });

            // Event listeners para professores
            document.querySelectorAll('.teacher-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedTeachers);
            });

            // Event listeners para matérias
            document.querySelectorAll('.subject-checkbox').forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedSubjects);
            });
        });

        function updateSelectedTeachers() {
            const selectedItems = document.getElementById('selectedTeachersItems');
            const selectedText = document.getElementById('selectedTeachersText');
            const selectedCheckboxes = document.querySelectorAll('.teacher-checkbox:checked');
            const teachersIdsInput = document.getElementById('teachersIds');

            selectedItems.innerHTML = '';

            if (selectedCheckboxes.length === 0) {
                selectedText.textContent = 'Selecione os professores...';
                teachersIdsInput.value = '';
                return;
            }

            selectedText.textContent = `${selectedCheckboxes.length} professor(es) selecionado(s)`;

            let teacherIds = [];
            selectedCheckboxes.forEach(checkbox => {
                const teacherId = checkbox.value;
                const teacherName = checkbox.parentElement.textContent.trim();

                teacherIds.push(teacherId);

                const badge = document.createElement('div');
                badge.className = 'selected-item';
                badge.innerHTML = `${teacherName} <span class="remove" onclick="deselectItem('teachers', ${teacherId})"><i class="bi bi-x-circle"></i></span>`;
                selectedItems.appendChild(badge);
            });

            teachersIdsInput.value = teacherIds.join(',');
        }

        function updateSelectedSubjects() {
            const selectedItems = document.getElementById('selectedSubjectsItems');
            const selectedText = document.getElementById('selectedSubjectsText');
            const selectedCheckboxes = document.querySelectorAll('.subject-checkbox:checked');
            const subjectsIdsInput = document.getElementById('subjectsIds');

            selectedItems.innerHTML = '';

            if (selectedCheckboxes.length === 0) {
                selectedText.textContent = 'Selecione as matérias...';
                subjectsIdsInput.value = '';
                return;
            }

            selectedText.textContent = `${selectedCheckboxes.length} matéria(s) selecionada(s)`;

            let subjectIds = [];
            selectedCheckboxes.forEach(checkbox => {
                const subjectId = checkbox.value;
                const subjectName = checkbox.parentElement.textContent.split('\n')[0].trim();

                subjectIds.push(subjectId);

                const badge = document.createElement('div');
                badge.className = 'selected-item';
                badge.innerHTML = `${subjectName} <span class="remove" onclick="deselectItem('subjects', ${subjectId})"><i class="bi bi-x-circle"></i></span>`;
                selectedItems.appendChild(badge);
            });

            subjectsIdsInput.value = subjectIds.join(',');
        }

        function deselectItem(type, id) {
            const checkbox = document.querySelector(`.${type}-checkbox[value="${id}"]`);
            if (checkbox) {
                checkbox.checked = false;
                if (type === 'teachers') {
                    updateSelectedTeachers();
                } else {
                    updateSelectedSubjects();
                }
            }
        }

        function toggleSelectAll(type) {
            const selectAll = document.getElementById(`selectAll${type.charAt(0).toUpperCase() + type.slice(1)}`);
            const checkboxes = document.querySelectorAll(`.${type}-checkbox`);

            const nowSelectAll = !selectAll.checked;
            selectAll.checked = nowSelectAll;

            checkboxes.forEach(checkbox => {
                checkbox.checked = nowSelectAll;
            });

            if (type === 'teachers') {
                updateSelectedTeachers();
            } else {
                updateSelectedSubjects();
            }
        }
    </script>
</x-app-layout>