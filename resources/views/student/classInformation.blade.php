<x-app-layout>
    @slot('title', 'Informações da turma')
    <x-student-header/>
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <strong><h2>Informações da turma</h2></strong>
        <div class="row rounded p-4 align-items-stretch mt-3">
            <!-- Alunos matriculados -->
            <div class="col-12 col-md-6 mb-4 mb-md-0 d-flex flex-column">
                <h3 class="mb-2 mb-md-0">Informações sobre a matéria</h3>

                <div class="border rounded d-flex align-items-center flex-column justify-content-center p-3 bg-light text-center mt-3" style="height: 300px;">
                    <strong>Nome do professor: professor tal</strong></br>
                    <span><b>Horário de aula:</b> tal dia da semana tal horario</span></br>
                    <p><b>Plano de ensino:</b> Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris consequat risus a euismod mollis. Proin eu sem augue. Duis est lorem, malesuada et dui in, finibus elementum odio. Lorem ipsum.</p>
                </div>
            </div>

            <!-- Avisos -->
            <div class="col-12 col-md-6 d-flex flex-column" >
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                    <h3 class="mb-2 mb-md-0">Avisos do professor</h3>
                    <a href={{ route('student.dashboard') }} class="btn btn-primary w-md-auto">Notas</a>
                </div>

                <div class="border rounded p-3 bg-light h-100">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Prova de matemática - 10/07
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Entrega do trabalho de história - 15/07
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Apresentação de ciências - 20/07
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>