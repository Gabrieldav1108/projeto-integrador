<x-app-layout>
    @slot('title', 'Horários')
    <x-header/>
    <section class="container p-3 mt-5 rounded-4 mx-auto" style="background-color: #cfe2ff; max-width: 900px; width: 100%;">
        <h4 class="text-center mb-4">Horários</h4>
        <div class="table-responsive">
        <table class="table table-bordered text-center align-middle">
            <thead class="table-light">
            <tr>
                <th>Horário</th>
                <th>Segunda-feira</th>
                <th>Terça-feira</th>
                <th>Quarta-feira</th>
                <th>Quinta-feira</th>
                <th>Sexta-feira</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>07:00</td>
                <td>turma 1</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>08:00</td>
                <td>turma 1</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>09:00</td>
                <td>pausa</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>10:00</td>
                <td>turma 2</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>13:00</td>
                <td>turma 3</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>14:00</td>
                <td>turma 3</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>15:00</td>
                <td>pausa</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>16:00</td>
                <td>turma 4</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            <tr>
                <td>17:00</td>
                <td>turma 4</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            </tbody>
        </table>
        </div>
    </section>
</x-app-layout>