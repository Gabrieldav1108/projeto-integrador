<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
    <title>Home</title>
</head>
    {{-- navbar --}}
    <x-header/>

    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h1 class="mt-4">Minhas turmas</h1>
        <div class="row rounded-3 p-4">
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff" >
                    <h5 class="fw-bold">Nome da turma</h5>
                    <p>Nome da matéria</p>
                    <a class="btn btn-primary fw-bold" href={{route('class')}}>Ver turma</a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Nome da turma</h5>
                    <p>Nome da matéria</p>
                    <a class="btn btn-primary fw-bold" href={{route('class')}}>Ver turma</a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Nome da turma</h5>
                    <p>Nome da matéria</p>
                    <a class="btn btn-primary fw-bold" href={{route('class')}}>Ver turma</a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Nome da turma</h5>
                    <p>Nome da matéria</p>
                    <a class="btn btn-primary fw-bold" href={{route('class')}}>Ver turma</a>
                </div>
            </div>

            <!-- Segunda linha -->
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Nome da turma</h5>
                    <p>Nome da matéria</p>
                    <a class="btn btn-primary fw-bold" href={{route('class')}}>Ver turma</a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Nome da turma</h5>
                    <p>Nome da matéria</p>
                    <a class="btn btn-primary fw-bold" href={{route('class')}}>Ver turma</a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Nome da turma</h5>
                    <p>Nome da matéria</p>
                    <a class="btn btn-primary fw-bold" href={{route('class')}}>Ver turma</a>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="p-3 border rounded text-center border-black border-2 shadow" style="background-color: #e0efff">
                    <h5 class="fw-bold">Nome da turma</h5>
                    <p>Nome da matéria</p>
                    <a class="btn btn-primary fw-bold" href={{route('class')}}>Ver turma</a>
                </div>
            </div>
    </section>
    
</body>
</html>