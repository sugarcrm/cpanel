<?php  namespace Stevemo\Cpanel\Controllers;

use Cpanel;
use Flash;
use Stevemo\Cpanel\Exceptions\LoginException;
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

    /**
     * Sign in a member
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $remember = Input::get('remember_me', false);
        $credentials = [
            Config::get('cartalyst/sentry::users.login_attribute') => Input::get('login_attribute'),
            'password' => Input::get('password')
        ];

        try
        {
            Cpanel::authenticate($credentials,$remember);
            Flash::message( Lang::get('cpanel::users.login_success') );
            return Redirect::intended(Config::get('cpanel::prefix', 'admin'));
        }
        catch (LoginException $e)
        {
            return Redirect::back()->withInput()->withErrors($e->getMessage());
        }
    }

    /**
     * Logout the current user
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy()
    {
        Cpanel::logout();
        Flash::success(Lang::get('cpanel::users.logout'));
        return Redirect::to('/');
    }
} 