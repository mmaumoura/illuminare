@php
    $s = auth()->user()?->setting;
    $currentTheme        = $s?->theme         ?? 'light';
    $currentPrimary      = $s?->theme_primary  ?? 'blue';
    $currentBase         = $s?->theme_base     ?? 'gray';
    $currentFont         = $s?->theme_font     ?? 'sans-serif';
    $currentRadius       = $s?->theme_radius   ?? '1';

    $colors = ['blue','azure','indigo','purple','pink','red','orange','yellow','lime','green','teal','cyan'];
    $fonts  = ['sans-serif','serif','monospace','comic'];
    $bases  = ['slate','gray','zinc','neutral','stone'];
    $radii  = ['0','0.5','1','1.5','2'];
@endphp

{{-- Floating toggle button --}}
<div class="settings">
    <a href="#" class="btn btn-floating btn-icon btn-primary"
       data-bs-toggle="offcanvas"
       data-bs-target="#offcanvas-settings"
       aria-controls="offcanvas-settings"
       aria-label="Configurações de tema">
        <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
             viewBox="0 0 24 24" fill="none" stroke="currentColor"
             stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
            <path d="M3 21v-13l9 -4l9 4v13"/>
            <path d="M13 13h4v8h-4z"/>
            <path d="M7 13m0 1a1 1 0 0 1 1 -1h2a1 1 0 0 1 1 1v3a1 1 0 0 1 -1 1h-2a1 1 0 0 1 -1 -1z"/>
        </svg>
    </a>

    {{-- Offcanvas panel --}}
    <form class="offcanvas offcanvas-start offcanvas-narrow"
          tabindex="-1"
          id="offcanvas-settings"
          role="dialog"
          aria-modal="true"
          aria-labelledby="offcanvas-settings-title">

        <div class="offcanvas-header">
            <h2 class="offcanvas-title" id="offcanvas-settings-title">Configurações de Tema</h2>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>
        </div>

        <div class="offcanvas-body d-flex flex-column">
            <div>

                {{-- Color mode --}}
                <div class="mb-4">
                    <label class="form-label">Modo de cor</label>
                    <p class="form-hint">Escolha o modo de cor do sistema.</p>
                    @foreach(['light','dark'] as $mode)
                    <label class="form-check">
                        <div class="form-selectgroup-item">
                            <input type="radio" name="theme" value="{{ $mode }}"
                                   class="form-check-input"
                                   {{ $currentTheme === $mode ? 'checked' : '' }} />
                            <div class="form-check-label">{{ ucfirst($mode === 'light' ? 'Claro' : 'Escuro') }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>

                {{-- Color scheme --}}
                <div class="mb-4">
                    <label class="form-label">Cor primária</label>
                    <p class="form-hint">Escolha a cor principal do sistema.</p>
                    <div class="row g-2">
                        @foreach($colors as $color)
                        <div class="col-auto">
                            <label class="form-colorinput">
                                <input name="theme-primary" type="radio"
                                       value="{{ $color }}"
                                       class="form-colorinput-input"
                                       {{ $currentPrimary === $color ? 'checked' : '' }} />
                                <span class="form-colorinput-color bg-{{ $color }}"></span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Font family --}}
                <div class="mb-4">
                    <label class="form-label">Família de fonte</label>
                    <p class="form-hint">Escolha a fonte do sistema.</p>
                    @foreach($fonts as $font)
                    <label class="form-check">
                        <div class="form-selectgroup-item">
                            <input type="radio" name="theme-font" value="{{ $font }}"
                                   class="form-check-input"
                                   {{ $currentFont === $font ? 'checked' : '' }} />
                            <div class="form-check-label">{{ ucfirst($font) }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>

                {{-- Theme base --}}
                <div class="mb-4">
                    <label class="form-label">Base de cinza</label>
                    <p class="form-hint">Escolha o tom de cinza do sistema.</p>
                    @foreach($bases as $base)
                    <label class="form-check">
                        <div class="form-selectgroup-item">
                            <input type="radio" name="theme-base" value="{{ $base }}"
                                   class="form-check-input"
                                   {{ $currentBase === $base ? 'checked' : '' }} />
                            <div class="form-check-label">{{ ucfirst($base) }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>

                {{-- Corner radius --}}
                <div class="mb-4">
                    <label class="form-label">Raio dos cantos</label>
                    <p class="form-hint">Escolha o arredondamento dos componentes.</p>
                    @foreach($radii as $radius)
                    <label class="form-check">
                        <div class="form-selectgroup-item">
                            <input type="radio" name="theme-radius" value="{{ $radius }}"
                                   class="form-check-input"
                                   {{ $currentRadius === $radius ? 'checked' : '' }} />
                            <div class="form-check-label">{{ $radius }}</div>
                        </div>
                    </label>
                    @endforeach
                </div>

            </div>

            <div class="mt-auto space-y">
                <button type="button" class="btn w-100" id="theme-reset-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-1" width="24" height="24"
                         viewBox="0 0 24 24" fill="none" stroke="currentColor"
                         stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                        <path d="M20 11a8.1 8.1 0 0 0 -15.5 -2m-.5 -4v4h4"/>
                        <path d="M4 13a8.1 8.1 0 0 0 15.5 2m.5 4v-4h-4"/>
                    </svg>
                    Resetar configurações
                </button>
                <button type="button" class="btn btn-primary w-100" data-bs-dismiss="offcanvas">
                    Fechar
                </button>
            </div>
        </div>
    </form>
</div>

<script>
(function () {
    var CSRF      = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    var UPDATE_URL = '{{ route("theme.update") }}';
    var RESET_URL  = '{{ route("theme.reset") }}';

    /* ---------------------------------------------------------------
       Mapas de valores → CSS custom properties
    --------------------------------------------------------------- */
    var colorMap = {
        'blue':   { hex: '#066fd1', rgb: '6, 111, 209' },
        'azure':  { hex: '#45aaf2', rgb: '69, 170, 242' },
        'indigo': { hex: '#6574cd', rgb: '101, 116, 205' },
        'purple': { hex: '#a55eea', rgb: '165, 94, 234' },
        'pink':   { hex: '#f66d9b', rgb: '246, 109, 155' },
        'red':    { hex: '#cd201f', rgb: '205, 32, 31' },
        'orange': { hex: '#fd9644', rgb: '253, 150, 68' },
        'yellow': { hex: '#f1c40f', rgb: '241, 196, 15' },
        'lime':   { hex: '#7bd235', rgb: '123, 210, 53' },
        'green':  { hex: '#5eba00', rgb: '94, 186, 0' },
        'teal':   { hex: '#2bcbba', rgb: '43, 203, 186' },
        'cyan':   { hex: '#17a2b8', rgb: '23, 162, 184' },
    };

    var fontMap = {
        'sans-serif': '"Inter", system-ui, -apple-system, sans-serif',
        'serif':      'Georgia, "Times New Roman", serif',
        'monospace':  '"Courier New", Courier, monospace',
        'comic':      '"Comic Sans MS", cursive',
    };

    // [base, sm, lg, xl, xxl] — mesmos valores que Tabler 1.4 usa em px
    var radiusMap = {
        '0':   ['0',     '0',    '0',     '0',       '0'],
        '0.5': ['3px',   '2px',  '4px',   '0.5rem',  '1rem'],
        '1':   ['6px',   '4px',  '8px',   '1rem',    '2rem'],
        '1.5': ['9px',   '6px',  '12px',  '1.5rem',  '3rem'],
        '2':   ['12px',  '8px',  '16px',  '2rem',    '4rem'],
    };

    var DYNAMIC_PROPS = [
        '--tblr-primary', '--tblr-primary-rgb', '--tblr-primary-lt', '--tblr-link-color',
        '--tblr-body-font-family',
        '--tblr-border-radius', '--tblr-border-radius-sm', '--tblr-border-radius-lg',
        '--tblr-border-radius-xl', '--tblr-border-radius-xxl',
    ];

    /* ---------------------------------------------------------------
       Funções de aplicação
    --------------------------------------------------------------- */
    function applyColor(name) {
        var el = document.documentElement;
        var c  = colorMap[name];
        if (!c) return;
        el.style.setProperty('--tblr-primary',     c.hex);
        el.style.setProperty('--tblr-primary-rgb', c.rgb);
        el.style.setProperty('--tblr-primary-lt',  'rgba(' + c.rgb + ', 0.1)');
        el.style.setProperty('--tblr-link-color',  c.hex);
    }

    function applyFont(name) {
        var f = fontMap[name];
        if (!f) return;
        document.documentElement.style.setProperty('--tblr-body-font-family', f);
    }

    function applyRadius(factor) {
        var r = radiusMap[factor];
        if (!r) return;
        var el = document.documentElement;
        el.style.setProperty('--tblr-border-radius',     r[0]);
        el.style.setProperty('--tblr-border-radius-sm',  r[1]);
        el.style.setProperty('--tblr-border-radius-lg',  r[2]);
        el.style.setProperty('--tblr-border-radius-xl',  r[3]);
        el.style.setProperty('--tblr-border-radius-xxl', r[4]);
    }

    function applyTheme(mode) {
        document.documentElement.setAttribute('data-bs-theme', mode);
    }

    /* ---------------------------------------------------------------
       Coleta payload completo do formulário
    --------------------------------------------------------------- */
    function collectPayload(form) {
        var keys = ['theme', 'theme-base', 'theme-font', 'theme-primary', 'theme-radius'];
        var payload = {};
        keys.forEach(function (key) {
            var el = form.querySelector('[name="' + key + '"]:checked');
            if (el) payload[key.replace(/-/g, '_')] = el.value;
        });
        return payload;
    }

    /* ---------------------------------------------------------------
       Event listeners
    --------------------------------------------------------------- */
    var form = document.getElementById('offcanvas-settings');
    if (!form) return;

    form.addEventListener('change', function (event) {
        var name  = event.target.name;
        var value = event.target.value;

        if      (name === 'theme')         applyTheme(value);
        else if (name === 'theme-primary') applyColor(value);
        else if (name === 'theme-font')    applyFont(value);
        else if (name === 'theme-radius')  applyRadius(value);
        // theme-base: saved to DB; visual support requires Tabler v2

        fetch(UPDATE_URL, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': CSRF,
                'Accept': 'application/json',
            },
            body: JSON.stringify(collectPayload(form)),
        });
    });

    document.getElementById('theme-reset-btn').addEventListener('click', function () {
        // Remove all dynamic CSS properties → app.css brand defaults kick back in
        DYNAMIC_PROPS.forEach(function (p) {
            document.documentElement.style.removeProperty(p);
        });
        document.documentElement.setAttribute('data-bs-theme', 'light');

        // Reset radios to brand defaults
        var defaults = {
            'theme': 'light', 'theme-base': 'gray',
            'theme-font': 'sans-serif', 'theme-primary': 'blue', 'theme-radius': '1'
        };
        Object.keys(defaults).forEach(function (key) {
            form.querySelectorAll('[name="' + key + '"]').forEach(function (r) {
                r.checked = r.value === defaults[key];
            });
        });

        // Delete DB record
        fetch(RESET_URL, {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
        });
    });
})();
</script>

