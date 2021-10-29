<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ config('starmoozie.base.html_direction') }}">
<head>
    @include(starmoozie_view('inc.head'))
</head>
<body class="app flex-row align-items-center">

  @yield('header')

  <div class="container">
  @yield('content')
  </div>

  @if(config('starmoozie.base.show_footer'))
  <footer class="app-footer sticky-footer">
    @include('starmoozie::inc.footer')
  </footer>
  @endif

  @yield('before_scripts')
  @stack('before_scripts')

  @include(starmoozie_view('inc.scripts'))

  @yield('after_scripts')
  @stack('after_scripts')

</body>
</html>
