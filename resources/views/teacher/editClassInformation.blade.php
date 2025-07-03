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
    <title>Informações da turma</title>
</head>
<body>
    <x-header/>
    
    <section class="container p-3 mt-5 rounded-4" style="background-color: #cfe2ff">
        <h2>Informações sobre a turma: ???</h2>
            <div class="row rounded p-4">
                <!-- Formulário -->
                <div class="col-12 col-md-5 mb-3 mb-md-0 mt-4">
                    <div class="border rounded p-3 bg-white h-100">
                        <form class="w-100 d-flex flex-column">
                            <h5 class="text-center"><strong>Adicionar</strong></h5>
                            <p class="text-center">Escreva abaixo as informações ou avisos para a turma ???</p>
                            
                            <label class="form-label" for="body">Edite o aviso</label>
                            <input type="text" class="form-control" name="content" id="content" placeholder="Digite aqui!">
    
                            <label class="form-label mt-2" for="body">Edite a data(se tiver)</label>
                            <input type="date" class="form-control" name="content" id="content" placeholder="Digite aqui!">
    
                            <label class="form-label mt-2" for="body">Edite o horário(se tiver)</label>
                            <input type="date" class="form-control" name="content" id="content" placeholder="Digite aqui!">
                            
                            <input type="submit" value="Adicionar" class="btn btn-primary btn-sm align-self-center mt-3">
                        </form>
                    </div>
                </div>
    
                <!-- Informações atuais -->
                <div class="col-12 col-md-6 d-flex flex-column" >
                    <h5>Informações atuais</h5>
    
                    <div class="border rounded p-3 bg-light h-100">
                        <ul class="list-group">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Prova de matemática - 10/07
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Entrega do trabalho de história - 15/07
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Apresentação de ciências - 20/07
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
    </section>
</body>
</html>