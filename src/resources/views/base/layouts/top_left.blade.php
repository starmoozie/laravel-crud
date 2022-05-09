<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ config('starmoozie.base.html_direction') }}">

<head>
  @include(starmoozie_view('inc.head'))

</head>

<body class="{{ config('starmoozie.base.body_class') }}">

  @include(starmoozie_view('inc.main_header'))

  <div class="app-body">

    @include(starmoozie_view('inc.sidebar'))

    <main class="main pt-2">

       @yield('before_breadcrumbs_widgets')

       @includeWhen(isset($breadcrumbs), starmoozie_view('inc.breadcrumbs'))

       @yield('after_breadcrumbs_widgets')

       @yield('header')

      <div class="container-fluid animated fadeIn" style="min-height: 75vh;">

        @yield('before_content_widgets')

        @yield('content')
        
        @yield('after_content_widgets')

      </div>

      <footer class="{{ config('starmoozie.base.footer_class') }}">
        @include(starmoozie_view('inc.footer'))
      </footer>

    </main>

  </div><!-- ./app-body -->

  @yield('before_scripts')
  @stack('before_scripts')

  @include(starmoozie_view('inc.scripts'))

  @yield('after_scripts')
  @stack('after_scripts')
</body>
</html>