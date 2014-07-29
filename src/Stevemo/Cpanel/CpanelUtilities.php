<?php  namespace Stevemo\Cpanel; 

use Illuminate\Container\Container;
use Illuminate\Events\Dispatcher;
use Cartalyst\Sentry\Users\UserExistsException;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Throttling\UserBannedException;
use Stevemo\Cpanel\Exceptions\LoginException;

class CpanelUtilities {

    /**
     * @var Container
     */
    private $app;

    /**
     * @var Dispatcher
     */
    private $event;

    /**
     * @param Container $app
     * @param Dispatcher $event
     */
    function __construct(Container $app, Dispatcher $event)
    {
        $this->event = $event;
        $this->app = $app;
    }



    /**
     * Get the currently authenticated user.
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     * @return \Cartalyst\Sentry\Users\UserInterface|null
     */
    public function getUser()
    {
        return $this->getSentry()->getUser();
    }

    /**
     * get a instance of Sentry
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     * @return \Cartalyst\Sentry\Sentry
     */
    public function getSentry()
    {
        return $this->app->make('sentry');
    }
} 