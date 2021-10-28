{{ trans('starmoozie::base.click_here_to_reset') }}: <a href="{{ $link = starmoozie_url('password/reset', $token).'?email='.urlencode($user->getEmailForPasswordReset()) }}"> {{ $link }} </a>
