@php
    use App\Support\Avatars;

    $avatars  = Avatars::all();
    $key      = $user->avatar ?? null;
    $size     = $size   ?? 'sm';
    $rounded  = $rounded ?? false;

    $classes = 'avatar avatar-' . $size . ($rounded ? ' rounded' : '');

    if ($key && isset($avatars[$key])) {
        $av  = $avatars[$key];
        $bg  = $av['bg'];
        $svg = $av['path'];
        $useAvatar = true;
    } else {
        $initials  = strtoupper(substr($user->name, 0, $size === 'xl' ? 2 : 1));
        $useAvatar = false;
    }
@endphp

@if($useAvatar)
<span class="{{ $classes }}" style="background-color: {{ $bg }}; color:#fff; flex-shrink:0;">
    <svg xmlns="http://www.w3.org/2000/svg"
         width="55%" height="55%"
         viewBox="0 0 24 24"
         fill="none"
         stroke="currentColor"
         stroke-width="2"
         stroke-linecap="round"
         stroke-linejoin="round">
        {!! $svg !!}
    </svg>
</span>
@else
<span class="{{ $classes }}" style="background-color:var(--tblr-primary); color:#fff; font-weight:700; flex-shrink:0;">
    {{ $initials }}
</span>
@endif
