{{-- Botão que abre o modal de confirmação --}}
<p class="text-muted mb-3">
    Ao excluir sua conta, todos os dados serão removidos permanentemente.
    Esta ação não pode ser desfeita.
</p>

<button type="button" class="btn btn-danger"
        data-bs-toggle="modal" data-bs-target="#modal-excluir-conta">
    Excluir minha conta
</button>

{{-- Modal --}}
<div class="modal modal-blur fade" id="modal-excluir-conta" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body">
                <div class="modal-title">Confirmação</div>
                <div class="text-secondary mt-1 mb-3">
                    Tem certeza que deseja excluir sua conta? Informe sua senha para confirmar.
                </div>
                <form method="post" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="mb-3">
                        <label class="form-label sr-only" for="del-password">Senha</label>
                        <input id="del-password" type="password" name="password"
                               class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                               placeholder="Sua senha" required>
                        @error('password', 'userDeletion')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex gap-2">
                        <button type="button"
                                class="btn btn-link text-muted ms-auto"
                                data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-danger">Excluir conta</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Abre o modal automaticamente se houver erros de exclusão --}}
@if($errors->userDeletion->isNotEmpty())
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var modal = new bootstrap.Modal(document.getElementById('modal-excluir-conta'));
        modal.show();
    });
</script>
@endif
