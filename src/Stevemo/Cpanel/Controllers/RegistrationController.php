<?php  namespace Stevemo\Cpanel\Controllers; 

use View;

class RegistrationController extends BaseController {

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
} 