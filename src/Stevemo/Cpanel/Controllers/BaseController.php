<?php namespace Stevemo\Cpanel\Controllers;

use Cpanel;
use Laracasts\Commander\CommanderTrait;
use View;
use Config;

class BaseController extends \Controller {

    use CommanderTrait;

    /**
     * Setup the layout used by the controller.
     *
     * @return void
     */
    protected function setupLayout()
    {
        if ( ! is_null($this->layout))
        {
            $this->layout = View::make($this->layout);
        }

        //share the config option to all the views
        $cpanel = Config::get('cpanel::site_config',[]);
        $cpanel['prefix'] = Config::get('cpanel::prefix','');
        View::share('cpanel', $cpanel);
        View::share('currentUser', Cpanel::getUser());
    }

    /**
     * get the validation service
     *
     * @author Steve Montambeault
     * @link   http://stevemo.ca
     *
     * @param  string $service
     * @param  array $inputs
     * @return Object
     */
    protected function getValidationService($service, array $inputs = [])
    {
        // TODO-Stevemo: remove this !!!!
        $class = '\\'.ltrim(Config::get("cpanel::validation.{$service}"), '\\');
        return new $class($inputs);
    }

}
