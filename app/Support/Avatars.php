<?php

namespace App\Support;

class Avatars
{
    /**
     * Retorna a lista completa de avatares pré-definidos.
     * Cada avatar tem: bg (cor de fundo), label (nome exibido) e path (conteúdo SVG interno).
     */
    public static function all(): array
    {
        return [
            'av01' => [
                'bg'    => '#E53935',
                'label' => 'Rubi',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"/><path stroke-linecap="round" stroke-linejoin="round" d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"/>',
            ],
            'av02' => [
                'bg'    => '#D81B60',
                'label' => 'Rosa',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12.572l-7.5 7.428l-7.5 -7.428a5 5 0 1 1 7.5 -6.566a5 5 0 1 1 7.5 6.566"/>',
            ],
            'av03' => [
                'bg'    => '#8E24AA',
                'label' => 'Violeta',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z"/>',
            ],
            'av04' => [
                'bg'    => '#3949AB',
                'label' => 'Safira',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M4 13a8 8 0 0 1 7 7a6 6 0 0 0 3 -5a9 9 0 0 0 6 -8a3 3 0 0 0 -3 -3a9 9 0 0 0 -8 6a6 6 0 0 0 -5 3"/><path stroke-linecap="round" stroke-linejoin="round" d="M7 14a6 6 0 0 0 -3 6a6 6 0 0 0 6 -3"/><circle cx="15" cy="9" r="1"/>',
            ],
            'av05' => [
                'bg'    => '#039BE5',
                'label' => 'Céu',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z"/>',
            ],
            'av06' => [
                'bg'    => '#00897B',
                'label' => 'Jade',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 21c.5 -4.5 2.5 -8 7 -10"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 18c6.218 0 10.5 -3.288 11 -12v-2h-4.014c-9 0 -11.986 4 -12 9c0 1 0 3 2 5h3z"/>',
            ],
            'av07' => [
                'bg'    => '#43A047',
                'label' => 'Esmeralda',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 6l4 6l5 -4l-2 10h-14l-2 -10l5 4z"/>',
            ],
            'av08' => [
                'bg'    => '#F57C00',
                'label' => 'Âmbar',
                'path'  => '<circle cx="12" cy="12" r="4"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7"/>',
            ],
            'av09' => [
                'bg'    => '#795548',
                'label' => 'Canela',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 14c.83 .642 2.077 1.017 3.5 1c1.423 .017 2.67 -.358 3.5 -1c.83 -.642 2.077 -1.017 3.5 -1c1.423 -.017 2.67 .358 3.5 1"/><path stroke-linecap="round" stroke-linejoin="round" d="M8 3a2.4 2.4 0 0 0 -1 2a2.4 2.4 0 0 0 1 2"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 3a2.4 2.4 0 0 0 -1 2a2.4 2.4 0 0 0 1 2"/><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h14v5a6 6 0 0 1 -6 6h-2a6 6 0 0 1 -6 -6v-5z"/><path stroke-linecap="round" stroke-linejoin="round" d="M16.746 16.726a3 3 0 1 0 .252 -5.555"/>',
            ],
            'av10' => [
                'bg'    => '#546E7A',
                'label' => 'Ardósia',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M3 17a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"/><path stroke-linecap="round" stroke-linejoin="round" d="M13 17a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-13l10 -2v13"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 8l10 -2"/>',
            ],
            'av11' => [
                'bg'    => '#AD1457',
                'label' => 'Fúcsia',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M5 7h1a2 2 0 0 0 2 -2a1 1 0 0 1 1 -1h6a1 1 0 0 1 1 1a2 2 0 0 0 2 2h1a2 2 0 0 1 2 2v9a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-9a2 2 0 0 1 2 -2"/><circle cx="12" cy="13" r="3"/>',
            ],
            'av12' => [
                'bg'    => '#4527A0',
                'label' => 'Ametista',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M6 5h12l3 5l-8.5 9.5a.7 .7 0 0 1 -1 0l-8.5 -9.5l3 -5"/><path stroke-linecap="round" stroke-linejoin="round" d="M10 12l-2 -7.5l5 2.5m3.5 5l2 -7.5l-5 2.5"/><path stroke-linecap="round" stroke-linejoin="round" d="M6.5 10h11"/>',
            ],
            'av13' => [
                'bg'    => '#0097A7',
                'label' => 'Ciano',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M13 3l0 7l6 0l-8 11l0 -7l-6 0l8 -11"/>',
            ],
            'av14' => [
                'bg'    => '#2E7D32',
                'label' => 'Floresta',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M9 3h6l3 7l-6 2l-6 -2z"/><path stroke-linecap="round" stroke-linejoin="round" d="M12 12v9"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 21h6"/>',
            ],
            'av15' => [
                'bg'    => '#E65100',
                'label' => 'Cobre',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0"/><path stroke-linecap="round" stroke-linejoin="round" d="M9 10l.01 0"/><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l.01 0"/><path stroke-linecap="round" stroke-linejoin="round" d="M9.5 15a3.5 3.5 0 0 0 5 0"/>',
            ],
            'av16' => [
                'bg'    => '#6A1B9A',
                'label' => 'Uva',
                'path'  => '<path stroke-linecap="round" stroke-linejoin="round" d="M12 3a6 6 0 0 0 9 9a9 9 0 1 1 -9 -9z"/><path stroke-linecap="round" stroke-linejoin="round" d="M20 3v4"/><path stroke-linecap="round" stroke-linejoin="round" d="M22 5h-4"/>',
            ],
        ];
    }

    public static function get(string $key): ?array
    {
        return static::all()[$key] ?? null;
    }

    public static function keys(): array
    {
        return array_keys(static::all());
    }
}
