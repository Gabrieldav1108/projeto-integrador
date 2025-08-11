<x-app-layout>
    @slot('title', 'Boletim do aluno')
    <x-student-header/>

        <section class="container p-3 mt-5 rounded-4 mx-auto" style="background-color: #cfe2ff; max-width: 900px; width: 100%;">
        <h4 class="text-center mb-4"><strong>Boletim do aluno: ???</strong></h4>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                <tr>
                    <th rowspan="2">Matérias</th>
                    <th colspan="3">Notas</th>
                    <th rowspan="2">Média final</th>
                </tr>
                <tr>
                    <th>Primeiro trimestre</th>
                    <th>Segundo trimestre</th>
                    <th>Terceiro trimestre</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Matéria 1</td>
                    <td>nota 1</td>
                    <td>nota 2</td>
                    <td>nota 3</td>
                    <td>média</td>
                </tr>
                <tr>
                    <td>Matéria 2</td>
                    <td>nota 1</td>
                    <td>nota 2</td>
                    <td>nota 3</td>
                    <td>média</td>
                </tr>
                <tr>
                    <td>Matéria 3</td>
                    <td>nota 1</td>
                    <td>nota 2</td>
                    <td>nota 3</td>
                    <td>média</td>
                </tr>
                <tr>
                    <td>Matéria 4</td>
                    <td>nota 1</td>
                    <td>nota 2</td>
                    <td>nota 3</td>
                    <td>média</td>
                </tr>
                <tr>
                    <td>Matéria 5</td>
                    <td>nota 1</td>
                    <td>nota 2</td>
                    <td>nota 3</td>
                    <td>média</td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>