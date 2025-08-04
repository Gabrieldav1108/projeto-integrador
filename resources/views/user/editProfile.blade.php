<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .profile-img, .profile-img-preview {
          width: 150px;
          height: 150px;
          object-fit: cover;
          border-radius: 50%;
          border: 2px solid #007bff;
          margin-bottom: 1rem;
        }
    </style>
    <link href="css/style.css" rel="stylesheet">
    <title>Editar Perfil</title>
</head>
<body>
    <x-header/>

    <div class="container my-5">
    <div class="p-5 rounded-4 card-custom shadow">
      <h2 class="mb-4 fw-bold">Editar Perfil</h2>

      <form method="POST" action="#" enctype="multipart/form-data">
        <!-- Laravel CSRF token -->
        @csrf

        <div class="row g-4">
          <!-- Foto do perfil -->
          <div class="col-md-4 text-center">
            <img src="{{asset('img/sukuna.jpg')}}" alt="Foto atual" class="profile-img-preview">
            <div class="mt-2">
              <label for="foto" class="form-label fw-semibold">Alterar foto</label>
              <input class="form-control" type="file" id="foto" name="foto">
            </div>
          </div>

          <!-- Dados pessoais -->
          <div class="col-md-8">
            <div class="mb-3">
              <label for="name" class="form-label fw-semibold">Nome</label>
              <input type="text" class="form-control" id="name" name="name" value="Gabriel Dávila">
            </div>

            <div class="mb-3">
              <label for="email" class="form-label fw-semibold">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="gabriel@email.com">
            </div>

            <div class="mb-3">
              <label for="password" class="form-label fw-semibold">Senha</label>
              <input type="text" class="form-control" id="password" name="password" value="*********">
            </div>
            <div class="mb-3">
              <label for="conf_password" class="form-label fw-semibold">Confirme a senha</label>
              <input type="text" class="form-control" id="conf_password" name="conf_password" value="*********">
            </div>

            <div class="d-flex justify-content-end gap-2">
              <a href="{{ route('profile') }}" class="btn btn-secondary">Cancelar</a>
              <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</body>
</html>