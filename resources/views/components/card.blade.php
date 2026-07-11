@props([
    'variant' => 'default',
    'icon',
    'title',
    'content'
])

<div class='main-card'>
    <div class='card-header'>
        <div class='card-icon'>
            {{ $icon }}
        </div>
        <h2 class='card-title'>{{ $title }}</h2>
    </div>
    <div class='card-body'>
        {{ $content }}
    </div>
</div>