<?php  namespace Stevemo\Cpanel\Controllers;

use Flash;
use Sentry;
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
        try
        {
            $formData = Input::only('login_attribute','password');
            $formData['remember'] = Input::get('remember', false);

            $this->execute(Config::get('cpanel::commands.login'),$formData);

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
        $data['user'] = Sentry::getUser();

        $this->execute(Config::get('cpanel::commands.logout'), $data);

        Flash::success(Lang::get('cpanel::users.logout'));

        return Redirect::to('/');
    }
} 