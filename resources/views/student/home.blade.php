<x-app-layout>
    @slot('title', 'Home')
    <x-student-header/>
    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h1 class="mt-4">Minhas matérias</h1>
        <div class="row rounded-3 p-4">
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff" >
                    <h5 class="fw-bold">Nome da Materia</h5>
                    <p>Nome do professor</p>
                    <a class="btn btn-primary fw-bold" href={{route('classInformation')}}>Ver Materia</a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Nome da Materia</h5>
                    <p>Nome do professor</p>
                    <a class="btn btn-primary fw-bold" href={{route('classInformation')}}>Ver Materia</a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Nome da Materia</h5>
                    <p>Nome do professor</p>
                    <a class="btn btn-primary fw-bold" href={{route('classInformation')}}>Ver Materia</a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Nome da Materia</h5>
                    <p>Nome do professor</p>
                    <a class="btn btn-primary fw-bold" href={{route('classInformation')}}>Ver Materia</a>
                </div>
            </div>

            <!-- Segunda linha -->
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Nome da Materia</h5>
                    <p>Nome do professor</p>
                    <a class="btn btn-primary fw-bold" href={{route('classInformation')}}>Ver Materia</a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Nome da Materia</h5>
                    <p>Nome do professor</p>
                    <a class="btn btn-primary fw-bold" href={{route('classInformation')}}>Ver Materia</a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Nome da Materia</h5>
                    <p>Nome do professor</p>
                    <a class="btn btn-primary fw-bold" href={{route('classInformation')}}>Ver Materia</a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Nome da Materia</h5>
                    <p>Nome do professor</p>
                    <a class="btn btn-primary fw-bold" href={{route('classInformation')}}>Ver Materia</a>
                </div>
            </div>
    </section>
</x-app-layout>