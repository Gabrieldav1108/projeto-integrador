<x-app-layout>
    @slot('title', 'Horários')
    <x-student-header/> 
    
    <section class="container p-3 mt-5 rounded-4 mx-auto" style="background-color: #cfe2ff; max-width: 900px; width: 100%;">
        <h4 class="text-center mb-4"><strong>Seus horários</strong></h4>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                    <th colspan="6" class="text-center">Horários</th>
                    </tr>
                    <tr>
                    <th></th>
                    <th>Segunda-feira</th>
                    <th>Terça-feira</th>
                    <th>Quarta-feira</th>
                    <th>Quinta-feira</th>
                    <th>Sexta-feira</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>07:00</td><td>aula 1</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>08:00</td><td>aula 1</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>09:00</td><td>aula 2</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>10:00</td><td>aula 2</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>13:00</td><td>aula 3</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>14:00</td><td>aula3</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>15:00</td><td>aula 4</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>16:00</td><td>aula 4</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>17:00</td><td>aula 5</td><td></td><td></td><td></td><td></td></tr>
                </tbody>
            </table>
        </div>
    </section>
</x-app-layout>