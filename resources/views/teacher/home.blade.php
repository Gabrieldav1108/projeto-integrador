<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/sass/app.sass', 'resources/js/app.js'])
        <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Jost:wght@500;600;700&family=Open+Sans:wght@400;600&display=swap" rel="stylesheet"> 

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
    <title>Home</title>
</head>
    {{-- navbar --}}
    <x-header/>

    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h1 class="mt-4">Meus Cursos</h1>
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