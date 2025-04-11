<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Update Password') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <div class="form-group">
            <label for="update_password_current_password">Senha Atual</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                </div>
                <input type="password" class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                    id="update_password_current_password" name="current_password" required>
            </div>
            @error('current_password', 'updatePassword')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password">Nova Senha</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-key"></i></span>
                </div>
                <input type="password" class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                    id="update_password_password" name="password" required>
            </div>
            @error('password', 'updatePassword')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="update_password_password_confirmation">Confirmar Senha</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fas fa-check-double"></i></span>
                </div>
                <input type="password" class="form-control @error('password_confirmation', 'updatePassword') is-invalid @enderror" 
                    id="update_password_password_confirmation" name="password_confirmation" required>
            </div>
            @error('password_confirmation', 'updatePassword')
                <span class="text-danger">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-info">
                <i class="fas fa-save mr-1"></i> Atualizar Senha
            </button>

            @if (session('status') === 'password-updated')
                <span class="text-success ml-3">
                    <i class="fas fa-check mr-1"></i> Senha atualizada com sucesso!
                </span>
            @endif
        </div>
    </form>
</section>
