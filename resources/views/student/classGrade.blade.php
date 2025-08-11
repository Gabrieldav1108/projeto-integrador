<x-app-layout>
    @slot('title', 'Notas')
    <x-student-header/>
    <section class="container p-3 mt-5 rounded-4 mx-auto" style="background-color: #cfe2ff; max-width: 900px; width: 100%;">
        <h4 class="text-center mb-4"><strong>Notas da Materia tal</strong></h4>
        <table class="table table-bordered text-center align-middle">
            <thead>
                <tr>
                <th colspan="3">Notas</th>
                </tr>
                <tr>
                <th>Primeiro trimestre</th>
                <th>Segundo trimestre</th>
                <th>Terceiro trimestre</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                <td>nota 1</td>
                <td>nota 1</td>
                <td>nota 1</td>
                </tr>
                <tr>
                <td>nota 2</td>
                <td>nota 2</td>
                <td>nota 2</td>
                </tr>
                <tr>
                <td>nota 3</td>
                <td>nota 3</td>
                <td>nota 3</td>
                </tr>
                <tr>
                <td>total</td>
                <td>total</td>
                <td>total</td>
                </tr>
            </tbody>
        </table>
    </section>
</x-app-layout>