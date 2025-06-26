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
    <title>Boletim</title>
</head>
<body>
    <x-student-header/>

        <section class="container p-3 mt-5 rounded-4 mx-auto" style="background-color: #cfe2ff; max-width: 900px; width: 100%;">
        <h4 class="text-center mb-4"><strong>Boletim do aluno: ???</strong></h4>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                <tr>
                    <th rowspan="2">Matérias</th>
                    <th colspan="3">Notas</th>
                    <th rowspan="2">Média final</th>
                </tr>
                <tr>
                    <th>Primeiro trimestre</th>
                    <th>Segundo trimestre</th>
                    <th>Terceiro trimestre</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>Matéria 1</td>
                    <td>nota 1</td>
                    <td>nota 2</td>
                    <td>nota 3</td>
                    <td>média</td>
                </tr>
                <tr>
                    <td>Matéria 2</td>
                    <td>nota 1</td>
                    <td>nota 2</td>
                    <td>nota 3</td>
                    <td>média</td>
                </tr>
                <tr>
                    <td>Matéria 3</td>
                    <td>nota 1</td>
                    <td>nota 2</td>
                    <td>nota 3</td>
                    <td>média</td>
                </tr>
                <tr>
                    <td>Matéria 4</td>
                    <td>nota 1</td>
                    <td>nota 2</td>
                    <td>nota 3</td>
                    <td>média</td>
                </tr>
                <tr>
                    <td>Matéria 5</td>
                    <td>nota 1</td>
                    <td>nota 2</td>
                    <td>nota 3</td>
                    <td>média</td>
                </tr>
                </tbody>
            </table>
        </div>
    </section>
    
</body>
</html>