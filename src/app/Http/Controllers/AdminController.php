<?php

namespace Starmoozie\CRUD\app\Http\Controllers;

use Illuminate\Routing\Controller;

class AdminController extends Controller
{
    protected $data = []; // the information we send to the view

    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware(starmoozie_middleware());
    }

    /**
     * Show the admin dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $this->data['title'] = trans('starmoozie::base.dashboard'); // set the page title
        $this->data['breadcrumbs'] = [
            trans('starmoozie::crud.admin')     => starmoozie_url('dashboard'),
            trans('starmoozie::base.dashboard') => false,
        ];

        return view(starmoozie_view('dashboard'), $this->data);
    }

    /**
     * Redirect to the dashboard.
     *
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(starmoozie_url('dashboard'));
    }
}
