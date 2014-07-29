<?php  namespace Stevemo\Cpanel\Controllers;

use View, Config, Input, Redirect, Lang;

class SessionsController extends BaseController {

    /**
     * Display the Cpanel login form
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $login_attribute = Config::get('cartalyst/sentry::users.login_attribute');
        return View::make('cpanel::sessions.create', compact('login_attribute'));
    }

    public function store()
    {

    }
} 