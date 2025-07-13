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
    <style>
        .card-custom {
        background-color: #e1efff;
        border: 1px solid #00000022;
        border-radius: 12px;
        }
        .profile-img {
        width: 100px;
        height: 100px;
        object-fit: cover;
        border-radius: 50%;
        border: 2px solid #007bff;
        margin-bottom: 1rem;
    }
    </style>
    <link href="css/style.css" rel="stylesheet">
    <title>Perfil</title>
</head>
<body>
    <x-header/>

    <div class="container my-5">
    <div class="p-5 rounded-4 card-custom shadow">
      <h2 class="mb-4 fw-bold">Meu Perfil</h2>
      <div class="row g-4">
        <!-- Cartão: Informações Pessoais -->
        <div class="col-md-6 d-flex">
          <div class="p-4 card-custom shadow w-100 d-flex flex-column justify-content-between">
            <div>
              <div class="d-flex justify-content-center">
                <img src="../.././img/zentisu.webp" alt="Foto de Perfil" class="profile-img">
              </div>
              <h5 class="fw-bold mb-3 text-center">Informações Pessoais</h5>
              <p><strong>Nome:</strong> Gabriel Dávila</p>
              <p><strong>Email:</strong> gabriel@email.com</p>
              <p><strong>Instituição:</strong> Escola Técnica XYZ</p>
            </div>
            <div class="text-center mt-3">
              <a href={{'editProfile'}} class="btn btn-primary">Editar Perfil</a>
            </div>
          </div>
        </div>

        <!-- Cartão: Estatísticas -->
        <div class="col-md-6 d-flex">
          <div class="p-4 card-custom shadow w-100 d-flex flex-column justify-content-between">
            <div>
              <h5 class="fw-bold mb-3 text-center">Minhas Estatísticas</h5>
              <p><strong>Turmas:</strong> 8</p>
              <p><strong>Formações:</strong> ???</p>
              <p><strong>Horários:</strong> <a href="{{'schedules' }}">Ver horários</a></p>
            </div>
            <div class="text-center mt-3">
              <button class="btn btn-danger">Sair da Conta</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>