<x-app-layout>
    <x-slot name="header">Meu Perfil</x-slot>

    <div class="row row-cards">

        {{-- Coluna esquerda: avatar atual + identidade --}}
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body text-center py-4">
                    <x-user-avatar :user="$user" size="xl" :rounded="true" />
                    <h3 class="mb-0 mt-3">{{ $user->name }}</h3>
                    <p class="text-muted">{{ $user->email }}</p>
                    @if($user->role)
                    <span class="badge" style="background-color:var(--tblr-primary); color:#fff;">
                        {{ $user->role->name }}
                    </span>
                    @endif
                </div>
            </div>

            {{-- Avatar picker (estilo Netflix) --}}
            <div class="card mt-3">
                <div class="card-header">
                    <h3 class="card-title">
                        <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><circle cx="12" cy="12" r="4"/><circle cx="12" cy="12" r="9"/></svg>
                        Escolha seu Avatar
                    </h3>
                </div>
                <div class="card-body">

                    @if(session('status') === 'avatar-updated')
                    <div class="alert alert-success alert-dismissible mb-3" role="alert">
                        <div>Avatar atualizado com sucesso!</div>
                        <a class="btn-close" data-bs-dismiss="alert" aria-label="Fechar"></a>
                    </div>
                    @endif

                    <form method="POST" action="{{ route('profile.avatar') }}" id="avatar-form">
                        @csrf
                        <input type="hidden" name="avatar" id="avatar-input" value="{{ $user->avatar ?? '' }}">

                        <div class="avatar-picker-grid">
                            @foreach($avatars as $key => $av)
                            <button type="button"
                                    class="avatar-picker-item {{ ($user->avatar === $key) ? 'selected' : '' }}"
                                    data-key="{{ $key }}"
                                    title="{{ $av['label'] }}"
                                    onclick="selectAvatar('{{ $key }}')">
                                <span class="avatar avatar-md rounded"
                                      style="background-color: {{ $av['bg'] }}; color:#fff; width:3rem; height:3rem;">
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         width="55%" height="55%"
                                         viewBox="0 0 24 24"
                                         fill="none"
                                         stroke="currentColor"
                                         stroke-width="2"
                                         stroke-linecap="round"
                                         stroke-linejoin="round">
                                        {!! $av['path'] !!}
                                    </svg>
                                </span>
                                <div class="avatar-check">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12l5 5l10 -10"/></svg>
                                </div>
                            </button>
                            @endforeach
                        </div>

                        <div class="mt-3 d-flex align-items-center gap-2">
                            <button type="submit" class="btn btn-primary">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2"/><circle cx="12" cy="14" r="2"/><polyline points="14 4 14 8 8 8 8 4"/></svg>
                                Salvar Avatar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Coluna direita: formulários --}}
        <div class="col-lg-8">

            {{-- Dados do perfil --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Informações do Perfil</h3>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Alterar senha --}}
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="card-title">Alterar Senha</h3>
                </div>
                <div class="card-body">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Excluir conta --}}
            <div class="card border-danger">
                <div class="card-header">
                    <h3 class="card-title text-danger">Zona de Perigo</h3>
                </div>
                <div class="card-body">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </div>
    </div>

    @push('styles')
    <style>
        .avatar-picker-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 0.5rem;
        }

        .avatar-picker-item {
            position: relative;
            background: none;
            border: 2px solid transparent;
            border-radius: 0.5rem;
            padding: 0.25rem;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: border-color 0.15s ease, transform 0.1s ease;
        }

        .avatar-picker-item:hover {
            border-color: var(--tblr-primary);
            transform: scale(1.08);
        }

        .avatar-picker-item.selected {
            border-color: var(--tblr-primary);
            background-color: rgba(var(--tblr-primary-rgb), 0.08);
        }

        .avatar-check {
            position: absolute;
            top: -4px;
            right: -4px;
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background-color: var(--tblr-primary);
            color: #fff;
            display: none;
            align-items: center;
            justify-content: center;
        }

        .avatar-picker-item.selected .avatar-check {
            display: flex;
        }
    </style>
    @endpush

    @push('scripts')
    <script>
        function selectAvatar(key) {
            document.getElementById('avatar-input').value = key;

            document.querySelectorAll('.avatar-picker-item').forEach(function(el) {
                el.classList.remove('selected');
            });

            document.querySelector('.avatar-picker-item[data-key="' + key + '"]').classList.add('selected');
        }
    </script>
    @endpush

</x-app-layout>

