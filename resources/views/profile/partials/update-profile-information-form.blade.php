<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <div class="form-group">
            <label for="name">Nome</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-user"></i></span>
                </div>
                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                    id="name" name="name" value="{{ old('name', $user->name) }}" 
                    required autofocus>
            </div>
            @error('name')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                </div>
                <input type="email" class="form-control @error('email') is-invalid @enderror" 
                    id="email" name="email" value="{{ old('email', $user->email) }}" 
                    required>
            </div>
            @error('email')
                <span class="text-danger">{{ $message }}</span>
            @enderror

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div class="alert alert-warning mt-2">
                    <p>Seu endereço de email não foi verificado.</p>
                    <button form="send-verification" class="btn btn-sm btn-outline-warning">
                        Clique aqui para reenviar o email de verificação
                    </button>

                    @if (session('status') === 'verification-link-sent')
                        <div class="alert alert-success mt-2">
                            Um novo link de verificação foi enviado para seu endereço de email.
                        </div>
                    @endif
                </div>
            @endif
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save mr-1"></i> Salvar
            </button>

            @if (session('status') === 'profile-updated')
                <span class="text-success ml-3">
                    <i class="fas fa-check mr-1"></i> Salvo com sucesso!
                </span>
            @endif
        </div>
    </form>
</section>
