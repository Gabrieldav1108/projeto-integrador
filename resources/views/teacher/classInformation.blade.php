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
    <title>Turma</title>
</head>
<body>
    <x-header/>
    
    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2>Informações sobre a turma: ???</h2>
        <div class="row rounded p-4">
            {{-- right of section --}}
            <div class="col-md-5">
                <div class="border rounded p-3 bg-white">
                    <form class="form-control d-flex justify-content-center align-items-center flex-column p-3">
                        <h5 class="text-center"><strong>Adicionar</strong></h5>
                        <p class="text-center">Escreva a baixo as informações ou avisos para a turma ???</p>
                        <textarea class="text-center form-control" placeholder="Escreva aqui"></textarea>
                        <input type="submit" value="Adicionar" class="btn btn-outline-secondary btn-sm mt-3">
                    </form>
                </div>
            </div>
            {{-- left of section --}}
            <div class="col-md-7">
                <div class="border rounded p-3 h-100 d-flex align-items-center justify-content-center bg-light text-center">
                    <span>Informacoes atuais</span>
                </div>
            </div>
        </div>
    </section>
</body>
</html>