<header class="banner">
  <a class="brand block my-4 text-2xl" href="{{ home_url('/') }}">
    {!! $siteName !!}
  </a>

  @if (has_nav_menu('primary_navigation'))
    <nav class="nav-primary" aria-label="{{ wp_get_nav_menu_name('primary_navigation') }}">
      {!! wp_nav_menu([
        'theme_location' => 'primary_navigation',
        'menu_class' => 'nav flex flex-row mb-4',
        'echo' => false,
        'a_class_0' => "font-bold inline-flex items-center mr-6",
        ]) !!}
    </nav>
  @endif
</header>
