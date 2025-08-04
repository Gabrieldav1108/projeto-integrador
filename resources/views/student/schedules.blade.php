<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/scss/app.scss', 'resources/js/app.js'])
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
    <title>Horários</title>
</head>
<body>
    <x-student-header/> 
    
    <section class="container p-3 mt-5 rounded-4 mx-auto" style="background-color: #cfe2ff; max-width: 900px; width: 100%;">
        <h4 class="text-center mb-4"><strong>Seus horários</strong></h4>
        <div class="table-responsive">
            <table class="table table-bordered text-center align-middle">
                <thead>
                    <tr>
                    <th colspan="6" class="text-center">Horários</th>
                    </tr>
                    <tr>
                    <th></th>
                    <th>Segunda-feira</th>
                    <th>Terça-feira</th>
                    <th>Quarta-feira</th>
                    <th>Quinta-feira</th>
                    <th>Sexta-feira</th>
                    </tr>
                </thead>
                <tbody>
                    <tr><td>07:00</td><td>aula 1</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>08:00</td><td>aula 1</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>09:00</td><td>aula 2</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>10:00</td><td>aula 2</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>13:00</td><td>aula 3</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>14:00</td><td>aula3</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>15:00</td><td>aula 4</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>16:00</td><td>aula 4</td><td></td><td></td><td></td><td></td></tr>
                    <tr><td>17:00</td><td>aula 5</td><td></td><td></td><td></td><td></td></tr>
                </tbody>
            </table>
        </div>
    </section>
    
</body>
</html>