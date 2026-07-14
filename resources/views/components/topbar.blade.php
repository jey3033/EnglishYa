<header class="header text-white">
    {{-- Bible Verse --}}
    <div>
        <p class="italic text-white">{{ $setting->verse }}</p>
        <span class="text-sm text-white">{{ $setting->verse_reference }}</span>
    </div>
    {{-- User --}}
    <div class="flex items-center gap-4">
        <div>
            <x-avatar :user="Auth::User()" />
        </div>
        <div>
            <p class="font-semibold">
                {{ Auth::user()->name }}
            </p>
            <p class="text-sm text-white">
                {{ ucfirst(Auth::user()->role) }}
            </p>
        </div>
        <form action="/logout" method="POST">
            @csrf
            <button class="text-danger">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15m3 0 3-3m0 0-3-3m3 3H9" />
                </svg>
            </button>
        </form>
    </div>
</header>