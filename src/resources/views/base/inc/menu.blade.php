<!-- =================================================== -->
<!-- ========== Top menu items (ordered left) ========== -->
<!-- =================================================== -->
<ul class="nav navbar-nav d-md-down-none">

    @if (starmoozie_auth()->check())
        <!-- Topbar. Contains the left part -->
        @include(starmoozie_view('inc.topbar_left_content'))
    @endif

</ul>
<!-- ========== End of top menu left items ========== -->



<!-- ========================================================= -->
<!-- ========= Top menu right items (ordered right) ========== -->
<!-- ========================================================= -->
<ul class="nav navbar-nav ml-auto @if(config('starmoozie.base.html_direction') == 'rtl') mr-0 @endif">
    @if (starmoozie_auth()->guest())
        <li class="nav-item"><a class="nav-link" href="{{ route('starmoozie.auth.login') }}">{{ trans('starmoozie::base.login') }}</a>
        </li>
        @if (config('starmoozie.base.registration_open'))
            <li class="nav-item"><a class="nav-link" href="{{ route('starmoozie.auth.register') }}">{{ trans('starmoozie::base.register') }}</a></li>
        @endif
    @else
        <!-- Topbar. Contains the right part -->
        @include(starmoozie_view('inc.topbar_right_content'))
        @include(starmoozie_view('inc.menu_user_dropdown'))
    @endif
</ul>
<!-- ========== End of top menu right items ========== -->
