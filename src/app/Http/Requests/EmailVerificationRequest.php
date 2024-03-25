<?php

namespace Starmoozie\CRUD\app\Http\Requests;

use Starmoozie\CRUD\app\Library\Auth\UserFromCookie;
use Illuminate\Foundation\Auth\EmailVerificationRequest as OriginalEmailVerificationRequest;

class EmailVerificationRequest extends OriginalEmailVerificationRequest
{
    public function user($guard = null)
    {
        return parent::user(starmoozie_guard_name()) ?? (new UserFromCookie())();
    }
}
