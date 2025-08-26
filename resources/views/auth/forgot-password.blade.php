<x-guest-layout>
    <div class="mb-4 text-secondary small">
        {{ __('Esqueceu sua senha? Sem problemas! Informe seu endereço de e-mail e enviaremos um link para redefinição de senha.') }}
    </div>

    <!-- Status de sessão -->
    @if (session('status'))
        <div class="alert alert-success mb-4">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="d-flex flex-column gap-3">
        @csrf

        <!-- Email -->
        <div class="form-group">
            <label for="email" class="form-label">{{ __('E-mail') }}</label>
            <input id="email" type="email"
                   class="form-control @error('email') is-invalid @enderror"
                   name="email" value="{{ old('email') }}" required autofocus>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Botão -->
        <div class="d-flex justify-content-end mt-3">
            <button type="submit" class="btn btn-primary px-4">
                {{ __('Enviar link de redefinição') }}
            </button>
        </div>
    </form>
</x-guest-layout>
