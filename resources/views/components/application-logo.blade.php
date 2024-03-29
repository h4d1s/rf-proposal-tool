@props([
    'color' => 'blue',
    'big' => false
])

@php
    $width = 25;
    $height = 26;
    if($big) {
        $width *= 2;
        $height *= 2;
    }
@endphp

<div class="navbar-brand-icon">
    @if($color === 'blue')
        <svg xmlns="http://www.w3.org/2000/svg" width="{{ $width }}" height="{{ $height }}" viewBox="0 0 25 26">
            <g fill="none" fill-rule="evenodd" transform="translate(-4 -3)">
                <polygon points="0 0 33 0 33 33 0 33"/>
                <path fill="#4A90E2" d="M16.4861111,25.550603 L6.25,17.7383325 L4,19.4562139 L16.5,29 L29,19.4562139 L26.7361111,17.7246985 L16.4861111,25.550603 L16.4861111,25.550603 Z M16.5,22.0875721 L26.7222222,14.2753015 L29,12.5437861 L16.5,3 L4,12.5437861 L6.26388889,14.2753015 L16.5,22.0875721 L16.5,22.0875721 Z"/>
            </g>
        </svg>
    @else
        <svg xmlns="http://www.w3.org/2000/svg" width="{{ $width }}" height="{{ $height }}" viewBox="0 0 25 26">
            <g fill="none" fill-rule="evenodd" transform="translate(-4 -3)">
                <polygon points="0 0 33 0 33 33 0 33"/>
                <path fill="#FFF" d="M16.4861111,25.550603 L6.25,17.7383325 L4,19.4562139 L16.5,29 L29,19.4562139 L26.7361111,17.7246985 L16.4861111,25.550603 L16.4861111,25.550603 Z M16.5,22.0875721 L26.7222222,14.2753015 L29,12.5437861 L16.5,3 L4,12.5437861 L6.26388889,14.2753015 L16.5,22.0875721 L16.5,22.0875721 Z"/>
            </g>
        </svg>
    @endif
</div>
