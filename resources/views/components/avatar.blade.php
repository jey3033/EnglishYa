@props([
    'user',
    'size' => 'md',
])

@php
    $sizes = [
        'sm' => 'w-5 h-5',
        'md' => 'w-10 h-10',
        'lg' => 'w-14 h-14',
        'xl' => 'w-50 h-50',
    ];

    $avatar = $user->profile_path
        ? asset('storage/' . $user->profile_path)
        : 'https://api.dicebear.com/10.x/adventurer/svg?seed=' . urlencode($user->name);
@endphp

<img
    src="{{ $avatar }}"
    alt="{{ $user->name }}"
    class="{{ $sizes[$size] }} rounded-full object-cover border border-primary-light"
>