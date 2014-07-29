<?php namespace Stevemo\Cpanel\Controllers;

use View, Config, Redirect, Lang, Input;
use Sentry;

class UsersController extends BaseController {

    /**
     * Show all the users
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = Sentry::findAllUsers();
        return View::make('cpanel::users.index', compact('users'));
    }

    /**
     * Show a user profile
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $id
     * @return Response
     */
    public function show($id)
    {
        try
        {
            $throttle = $this->users->getUserThrottle($id);
            $user = $throttle->getUser();
            $permissions = $user->getMergedPermissions();

            return View::make('cpanel::users.show')
                ->with('user',$user)
                ->with('permissions',$permissions)
                ->with('throttle',$throttle);
        }
        catch ( UserNotFoundException $e)
        {
            return Redirect::route('cpanel.users.index')
                ->with('error', $e->getMessage());
        }
    }

    /**
     * Display add user form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $groups = Sentry::findAllGroups();

        return View::make('cpanel::users.create',compact('groups'));
    }

    /**
     * Display the user edit form
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function edit($id)
    {
        try
        {
            $user = $this->users->findById($id);
            $groups = $this->groups->findAll();

            $userPermissions = $user->getPermissions();
            $genericPermissions = $this->permissions->generic();
            $modulePermissions = $this->permissions->module();

            //get only the group id the user belong to
            $userGroupsId = array_pluck($user->getGroups()->toArray(), 'id');

            return View::make('cpanel::users.edit')
                ->with('user',$user)
                ->with('groups',$groups)
                ->with('userGroupsId',$userGroupsId)
                ->with('genericPermissions',$genericPermissions)
                ->with('modulePermissions',$modulePermissions)
                ->with('userPermissions',$userPermissions);
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('cpanel.users.index')
                ->with('error',$e->getMessage());
        }
    }

    /**
     * Create a new user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @return Response
     */
    public function store()
    {
        $this->execute(Config::get('cpanel::commands.create_user'));
        $inputs = Input::except('groups', 'activate');
        $inputs['groups'] = Input::get('groups', []);
        $inputs['activate'] = Input::get('activate', false);

        if ( $this->userForm->create($inputs) )
        {
            return Redirect::route('cpanel.users.index')
                ->with('success', Lang::get('cpanel::users.create_success'));
        }

        return Redirect::back()
            ->withInput()
            ->withErrors($this->userForm->getErrors());
    }

    /**
     * Update user information
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update($id)
    {
        try
        {
            $credentials = Input::except('groups');
            $credentials['groups'] = Input::get('groups', array());
            $credentials['id'] = $id;


            if( $this->userForm->update($credentials) )
            {
                return Redirect::route('cpanel.users.index')
                    ->with('success', Lang::get('cpanel::users.update_success'));
            }

            return Redirect::back()
                ->withInput()
                ->withErrors($this->userForm->getErrors());
        }
        catch ( UserNotFoundException $e)
        {
            return Redirect::route('cpanel.users.index')
                    ->with('error', $e->getMessage());
        }
    }

    /**
     * Delete a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        $currentUser = $this->users->getUser();

        if ($currentUser->id === (int) $id)
        {
            return Redirect::back()
                ->with('error', Lang::get('cpanel::users.delete_denied') );
        }

        try
        {
            $this->users->delete($id);
            return Redirect::route('cpanel.users.index')
                ->with('success',Lang::get('cpanel::users.delete_success'));
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('cpanel.users.index')
                ->with('error',$e->getMessage());
        }
    }

    /**
     * deactivate a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putDeactivate($id)
    {
        try
        {
            $this->users->deactivate($id);
            return Redirect::route('cpanel.users.index')
                ->with('success',Lang::get('cpanel::users.deactivation_success'));
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('cpanel.users.index')
                ->with('error',$e->getMessage());
        }
    }

    /**
     * Activate a user
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param $id
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function putActivate($id)
    {
        try
        {
            if ($this->users->activate($id))
            {
                // User activation passed
                return Redirect::route('cpanel.users.index')
                    ->with('success',Lang::get('cpanel::users.activation_success'));
            }
            else
            {
                // User activation failed
                return Redirect::route('cpanel.users.index')
                    ->with('error',Lang::get('cpanel::users.activation_fail'));
            }
        }
        catch (UserNotFoundException $e)
        {
            return Redirect::route('cpanel.users.index')
                ->with('error',$e->getMessage());
        }
    }

}
