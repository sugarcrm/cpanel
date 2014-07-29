<?php namespace Stevemo\Cpanel\Controllers;

use View, Config, Input, Redirect, Lang;
use Stevemo\Cpanel\User\Repo\CpanelUserInterface;
use Stevemo\Cpanel\User\Form\UserFormInterface;


class CpanelController extends BaseController {

    /**
     * @var \Stevemo\Cpanel\User\Repo\CpanelUserInterface
     */
    private $users;

    /**
     * @var \Stevemo\Cpanel\User\Form\UserFormInterface
     */
    private $userForm;

    /**
     * @param CpanelUserInterface                         $users
     * @param \Stevemo\Cpanel\User\Form\UserFormInterface $userForm
     */
    public function __construct(CpanelUserInterface $users, UserFormInterface $userForm)
    {
        $this->users = $users;
        $this->userForm = $userForm;
    }


    /**
     * Show the dashboard
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return View::make('cpanel::cpanel.index');
    }

    /**
     * Register user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postRegister()
    {
        if( $this->userForm->register(Input::all(),false) )
        {
            return Redirect::route('cpanel.login')
                ->with('success', Lang::get('cpanel::users.register_success'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($this->userForm->getErrors());

    }
    
}