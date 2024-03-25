<?php

namespace Starmoozie\CRUD\app\Library\Auth;

use Illuminate\Support\Facades\Cookie;

class UserFromCookie
{
    public function __invoke(): ?\Illuminate\Contracts\Auth\MustVerifyEmail
    {
        if (Cookie::has('starmoozie_email_verification')) {
            return config('starmoozie.base.user_model_fqn')::where(config('starmoozie.base.email_column'), Cookie::get('starmoozie_email_verification'))->first();
        }

        return null;
    }
}
