<x-app-layout>
    @slot('title', 'Perfil do Usuário')
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
                <img src="{{asset('img/sukuna.jpg')}}" alt="Foto atual" class="profile-img-preview">
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
</x-app-layout>