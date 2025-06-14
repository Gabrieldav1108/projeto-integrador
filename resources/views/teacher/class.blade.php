<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
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
    <title>Turma</title>
</head>
<body>
    <x-header/>
    <section class="container p-4 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2>Informações da turma</h2>
        <div class="row rounded p-4 align-items-stretch">
            
            <!-- Alunos matriculados -->
            <div class="col-12 col-md-6 mb-4 mb-md-0 d-flex flex-column">
                <h3>Alunos matriculados</h3>
                <div class="border rounded p-3 bg-white h-100" data-bs-spy="scroll">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Nome do aluno 1</span>
                            <a href={{ route('studentInformation') }} class="btn btn-primary m-1">Ver aluno</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Nome do aluno 1</span>
                            <a href={{ route('studentInformation') }} class="btn btn-primary m-1">Ver aluno</a>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <span>Nome do aluno 1</span>
                            <a href={{ route('studentInformation') }} class="btn btn-primary m-1">Ver aluno</a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Avisos -->
            <div class="col-12 col-md-6 d-flex flex-column">
                <!-- Cabeçalho com botão -->
                <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
                    <h3 class="mb-2 mb-md-0">Avisos</h3>
                    <a href={{ route('classInformation') }} class="btn btn-primary w-100 w-md-auto">Adicionar informações</a>
                </div>

                <!-- Conteúdo dos avisos -->
                <div class="border rounded p-3 bg-light h-100 d-flex align-items-center justify-content-center text-center">
                    <span>Informações que o professor adicionar como datas de provas ou entrega de trabalhos</span>
                </div>
            </div>
        </div>
    </section>
</body>
</html>