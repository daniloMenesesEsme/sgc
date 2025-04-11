<section>
    <div class="alert alert-danger">
        <h5><i class="icon fas fa-exclamation-triangle"></i> Atenção!</h5>
        <p>Depois que sua conta for excluída, todos os seus recursos e dados serão permanentemente excluídos. Antes de excluir sua conta, baixe todos os dados ou informações que deseja manter.</p>
    </div>

    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modal-delete-account">
        <i class="fas fa-trash mr-1"></i> Excluir Conta
    </button>

    <!-- Modal de confirmação -->
    <div class="modal fade" id="modal-delete-account" tabindex="-1" role="dialog" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')
                    
                    <div class="modal-header bg-danger">
                        <h5 class="modal-title" id="deleteAccountModalLabel">Excluir Conta</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <i class="fas fa-exclamation-triangle fa-4x text-warning mb-3"></i>
                            <h5>Tem certeza que deseja excluir sua conta?</h5>
                        </div>
                        
                        <p>Depois que sua conta for excluída, todos os seus recursos e dados serão permanentemente excluídos. Por favor, digite sua senha para confirmar que deseja excluir permanentemente sua conta.</p>
                        
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                </div>
                                <input type="password" class="form-control @error('password', 'userDeletion') is-invalid @enderror" 
                                    id="password" name="password" placeholder="Digite sua senha" required>
                            </div>
                            @error('password', 'userDeletion')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash mr-1"></i> Excluir Conta
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
