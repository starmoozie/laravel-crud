<?php

namespace Starmoozie\CRUD\app\Http\Controllers;

use Alert;
use Starmoozie\CRUD\app\Http\Requests\AccountInfoRequest;
use Starmoozie\CRUD\app\Http\Requests\ChangePasswordRequest;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Hash;

class MyAccountController extends Controller
{
    protected $data = [];

    public function __construct()
    {
        $this->middleware(starmoozie_middleware());
    }

    /**
     * Show the user a form to change their personal information & password.
     */
    public function getAccountInfoForm()
    {
        $this->data['title'] = trans('starmoozie::base.my_account');
        $this->data['user'] = $this->guard()->user();

        return view(starmoozie_view('my_account'), $this->data);
    }

    /**
     * Save the modified personal information for a user.
     */
    public function postAccountInfoForm(AccountInfoRequest $request)
    {
        $result = $this->guard()->user()->update($request->except(['_token']));

        if ($result) {
            Alert::success(trans('starmoozie::base.account_updated'))->flash();
        } else {
            Alert::error(trans('starmoozie::base.error_saving'))->flash();
        }

        return redirect()->back();
    }

    /**
     * Save the new password for a user.
     */
    public function postChangePasswordForm(ChangePasswordRequest $request)
    {
        $user = $this->guard()->user();
        $user->password = Hash::make($request->new_password);

        if ($user->save()) {
            Alert::success(trans('starmoozie::base.account_updated'))->flash();
        } else {
            Alert::error(trans('starmoozie::base.error_saving'))->flash();
        }

        return redirect()->back();
    }

    /**
     * Get the guard to be used for account manipulation.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return starmoozie_auth();
    }
}
