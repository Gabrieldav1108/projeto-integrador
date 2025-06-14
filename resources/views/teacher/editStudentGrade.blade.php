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
    <title>Notas do aluno</title>
</head>
<body>
    <x-header/>

    <section class="container p-3 mt-5 rounded-4 w-100 w-sm-75 w-md-50" style="background-color: #cfe2ff">
        <h2 class="bold">Editar nota: ???</h2>
        <div class="rounded p-4">
            <div class="">
                <div class="border rounded p-3 bg-white">
                    <form class="form-control d-flex justify-content-center align-items-center flex-column p-4">
                        <h5 class="text-center fs-2"><strong>Editar</strong></h5>
                        <strong class="p-2 fs-4">Valor atual da nota: ???</strong>
                        <label for="#" class="form-control mt-3">Insira o novo valor da nota</label>
                        <input type="text" class="form-control" placeholder="Novo valor"/>
                        <input type="submit" value="Editar" class="btn btn-primary btn-lg mt-4">
                    </form>
                </div>
            </div>
        </div>
    </section>
</body>
</html>