<x-app-layout>
    @slot('title', 'Informações do aluno')
    <x-header/>

    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2 class="text-center text-md-start">Informações do aluno</h2>

        <div class="row rounded p-4 g-4">
            <!-- Coluna: Notas -->
            <div class="col-12 col-md-6 d-flex flex-column">
                <h5 class="text-center"><strong>Notas</strong></h5>

                <div class="table-responsive mt-2">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th scope="col">Notas</th>
                                <th scope="col">1º Trimestre</th>
                                <th scope="col">2º Trimestre</th>
                                <th scope="col">3º Trimestre</th>
                                <th scope="col">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1°</td>
                                <td><a href={{route('editGrade')}} class="btn btn-link p-0 text-decoration-none">Nota 1</a href={{route('editGrade')}}></td>
                                <td><a href={{route('editGrade')}} class="btn btn-link p-0 text-decoration-none">Nota 1</a href={{route('editGrade')}}></td>
                                <td><a href={{route('editGrade')}} class="btn btn-link p-0 text-decoration-none">Nota 1</a href={{route('editGrade')}}></td>
                                <td>Total</td>
                            </tr>
                            <tr>
                                <td>2°</td>
                                <td><a href={{route('editGrade')}} class="btn btn-link p-0 text-decoration-none">Nota 2</a href={{route('editGrade')}}></td>
                                <td><a href={{route('editGrade')}} class="btn btn-link p-0 text-decoration-none">Nota 2</a href={{route('editGrade')}}></td>
                                <td><a href={{route('editGrade')}} class="btn btn-link p-0 text-decoration-none">Nota 2</a href={{route('editGrade')}}></td>
                                <td>Total</td>
                            </tr>
                            <tr>
                                <td>3°</td>
                                <td><a href={{route('editGrade')}} class="btn btn-link p-0 text-decoration-none">Nota 3</a href={{route('editGrade')}}></td>
                                <td><a href={{route('editGrade')}} class="btn btn-link p-0 text-decoration-none">Nota 3</a href={{route('editGrade')}}></td>
                                <td><a href={{route('editGrade')}} class="btn btn-link p-0 text-decoration-none">Nota 3</a href={{route('editGrade')}}></td>
                                <td>Total</td>
                            </tr>
                            <tr>
                                <td colspan="4"></td>
                                <td><strong>Média final</strong></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Coluna: Informações do aluno -->
            <div class="col-12 col-md-6 d-flex flex-column">
                <h5 class="text-center"><strong>Informações do aluno</strong></h5>

                <div class="border rounded p-3 d-flex align-items-center justify-content-center bg-light text-center flex-grow-1 mt-2"
                 style="height: 300px;">
                    <span>Informações sobre o aluno</span>
                </div>
            </div>
        </div>
    </section>
</x-app-layout>