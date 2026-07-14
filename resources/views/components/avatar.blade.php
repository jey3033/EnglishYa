@props([
    'user',
    'size' => '10',
])

@php
    $avatar = $user->profile_path
        ? asset('storage/' . $user->profile_path)
        : 'https://api.dicebear.com/10.x/adventurer/svg?seed=' . urlencode($user->name);
@endphp

<img
    src="{{ $avatar }}"
    alt="{{ $user->name }}"
    class="w-{{ $size }} h-{{ $size }} rounded-full object-cover border border-primary-light"
>