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
    <title>Informações da matéria</title>
</head>
<body>
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
                    <a href={{ route('studentClassGrade') }} class="btn btn-primary w-md-auto">Notas</a>
                </div>

                <div class="border rounded p-3 bg-light h-100 d-flex align-items-center justify-content-center text-center" style="height: 300px;">
                    <span>Informações que o professor adicionar como datas de provas ou entrega de trabalhos</span>
                </div>
            </div>
        </div>
    </section>
</body>
</html>