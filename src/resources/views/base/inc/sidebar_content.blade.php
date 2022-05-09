<!-- This file is used to store sidebar items, starting with Starmoozie\Base 0.9.0 -->
<li class="nav-item"><a class="nav-link" href="{{ starmoozie_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('starmoozie::base.dashboard') }}</a></li>

@includeIf('menu_permission_view::sidebar_content')