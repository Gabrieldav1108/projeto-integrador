<x-app-layout>
  @slot('title', 'Editar Perfil')
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
    
    <!-- Header condicional baseado no role -->
    @if(Auth::user()->role === 'admin')
        <x-admin-header/>
    @elseif(Auth::user()->role === 'teacher')
        <x-teacher-header/>
    @else
        <x-student-header/>
    @endif

    <div class="container my-5">
    <div class="p-5 rounded-4 card-custom shadow">
      <h2 class="mb-4 fw-bold">Editar Perfil</h2>

      <!-- Mensagens de sucesso/erro -->
      @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          {{ session('success') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      @endif

      <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
          <!-- Foto do perfil -->
          <div class="col-md-4 text-center">
            <img src="{{ $user->foto_url }}" alt="Foto atual" class="profile-img-preview" id="profilePreview">
            <div class="mt-2">
              <label for="foto" class="form-label fw-semibold">Alterar foto</label>
              <input class="form-control" type="file" id="foto" name="foto" accept="image/*">
            </div>
          </div>

          <!-- Dados pessoais -->
          <div class="col-md-8">
            <div class="mb-3">
              <label for="name" class="form-label fw-semibold">Nome</label>
              <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}">
            </div>

            <div class="mb-3">
              <label for="email" class="form-label fw-semibold">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}">
            </div>

            <div class="mb-3">
              <label for="password" class="form-label fw-semibold">Nova Senha (deixe em branco para manter a atual)</label>
              <input type="password" class="form-control" id="password" name="password" placeholder="Digite a nova senha">
            </div>
            <div class="mb-3">
              <label for="password_confirmation" class="form-label fw-semibold">Confirme a Nova Senha</label>
              <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Confirme a nova senha">
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

  <script>
    // Preview da imagem antes de enviar
    document.getElementById('foto').addEventListener('change', function(e) {
      const file = e.target.files[0];
      if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
          document.getElementById('profilePreview').src = e.target.result;
        }
        reader.readAsDataURL(file);
      }
    });
  </script>
</x-app-layout>