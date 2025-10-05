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
            <div class="mb-3">
                <label for="teachers" class="form-label">Selecione um ou mais professores</label>
                <div class="dropdown">
                    <button class="form-select text-start" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <span id="selectedText">Selecione os professores...</span>
                    </button>
                    <div class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton">
                        <div class="select-all" onclick="toggleSelectAll()">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="selectAll">
                                <label class="form-check-label" for="selectAll">Selecionar todos</label>
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
                                            <input class="form-check-input me-2" type="checkbox" name="teachers" value="{{ $teacher->id }}">
                                            {{ $teacher->name }}
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="selected-items mt-2" id="selectedItems"></div>
                <input type="hidden" name="teachers_ids" id="teachersIds">
            </div>

            <button type="submit" class="btn btn-primary fw-bold">Salvar</button>
            <a href="{{ route('admin.classes.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            updateSelectedTeachers();

            document.getElementById('searchTeacher').addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                const items = document.querySelectorAll('.teacher-list .list-group-item');
                
                items.forEach(item => {
                    const text = item.textContent.toLowerCase();
                    item.style.display = text.includes(searchTerm) ? 'block' : 'none';
                });
            });

            document.querySelectorAll('input[name="teachers"]').forEach(checkbox => {
                checkbox.addEventListener('change', updateSelectedTeachers);
            });
        });

        function updateSelectedTeachers() {
            const selectedItems = document.getElementById('selectedItems');
            const selectedText = document.getElementById('selectedText');
            const selectedCheckboxes = document.querySelectorAll('input[name="teachers"]:checked');
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
                badge.innerHTML = `${teacherName} <span class="remove" onclick="deselectTeacher(${teacherId})"><i class="bi bi-x-circle"></i></span>`;
                selectedItems.appendChild(badge);
            });

            teachersIdsInput.value = teacherIds.join(',');
        }

        function deselectTeacher(teacherId) {
            const checkbox = document.querySelector(`input[name="teachers"][value="${teacherId}"]`);
            if (checkbox) {
                checkbox.checked = false;
                updateSelectedTeachers();
            }
        }

        function toggleSelectAll() {
            const selectAll = document.getElementById('selectAll');
            const checkboxes = document.querySelectorAll('input[name="teachers"]');

            const nowSelectAll = !selectAll.checked;
            selectAll.checked = nowSelectAll;

            checkboxes.forEach(checkbox => {
                checkbox.checked = nowSelectAll;
            });

            updateSelectedTeachers();
        }
    </script>
</x-app-layout>
