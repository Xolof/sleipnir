<nav x-data="{ mobileMenuIsOpen: false }" class="flex">
    <!-- Hamburger Button -->
    <button @click="mobileMenuIsOpen = !mobileMenuIsOpen" class="p-4 md:hidden justify-end cursor-pointer" aria-label="Toggle menu">
        <svg class="h-6 w-6 text-zinc-800" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path x-show="!mobileMenuIsOpen" d="M4 6h16M4 12h16M4 18h16" />
            <path x-show="mobileMenuIsOpen" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuIsOpen"
        @click.away="mobileMenuIsOpen = false"
        class="fixed inset-0 md:hidden transition-transform duration-300 bg-zinc-50 z-900 p-4"
        :class="{ 'translate-x-0': mobileMenuIsOpen, '-translate-x-full': !mobileMenuIsOpen }"
    >
        <div class="flex justify-between p-4">
            <div class="text-zinc-800 text-xl">
                <a href="/" class="brand block">{!! $siteName !!}</a>
            </div>
            <button @click="mobileMenuIsOpen = false" class="text-zinc-800 text-2xl cursor-pointer" aria-label="Close menu">
                ×
            </button>
        </div>
        @if (has_nav_menu('primary_navigation'))
        <nav class="nav-primary text-lg" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
            {!! wp_nav_menu([
            'theme_location' => 'primary_navigation',
            "menu_class" => "flex flex-col p-4 space-y-2",
            'echo' => false,
            'a_class_0' => "inline-flex items-center mb-2 mobile-nav-item"
            ]) !!}
        </nav>
        @endif
    </div>

    <!-- Desktop Menu -->
    <div class="w-full mx-auto py-4 flex justify-between items-center max-w-7xl lg:px-8">
        @if (has_nav_menu('primary_navigation'))
        {{-- <nav class="nav-primary" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}"> --}}
        {!! wp_nav_menu([
        'theme_location' => 'primary_navigation',
        "menu_class" => "hidden md:flex space-x-7",
        'echo' => false,
        'a_class_0' => "inline-flex items-center mr-6"
        ]) !!}
        {{-- </nav> --}}
        @endif
    </div>
</nav>
