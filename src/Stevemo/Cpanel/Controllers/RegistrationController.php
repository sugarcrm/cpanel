<?php  namespace Stevemo\Cpanel\Controllers; 

use Config;
use Flash;
use Laracasts\Commander\CommanderTrait;
use Laracasts\Validation\FormValidationException;
use Redirect;
use View;

class RegistrationController extends BaseController {

    use CommanderTrait;

    /**
     * Display the registration form
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        return View::make('cpanel::registration.create');
    }

    /**
     * Register a new user
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        try
        {
            $this->execute(Config::get('cpanel::commands.register_user'));

            Flash::success(Lang::get('cpanel::users.register_success'));
            return Redirect::route('cpanel.login');
        }
        catch (FormValidationException $e)
        {
            return Redirect::back()
                ->withInput()
                ->withErrors($e->getErrors());
        }

    }
} 