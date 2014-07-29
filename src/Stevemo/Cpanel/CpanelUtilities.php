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
     * Attempts to authenticate the given user
     * according to the passed credentials.
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     * @param array $credentials
     * @param bool $remember
     * @throws Exceptions\LoginException
     *
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function authenticate(array $credentials, $remember = false)
    {
        try
        {
            $user = $this->getSentry()->authenticate($credentials,$remember);
            $this->event->fire('cpanel.user.login',[$user]);
            return $user;
        }
        catch (LoginRequiredException $e)
        {
            throw new LoginException($e->getMessage());
        }
        catch (PasswordRequiredException $e)
        {
            throw new LoginException($e->getMessage());
        }
        catch (WrongPasswordException $e)
        {
            throw new LoginException($e->getMessage());
        }
        catch (UserNotActivatedException $e)
        {
            throw new LoginException($e->getMessage());
        }
        catch (UserNotFoundException $e)
        {
            throw new LoginException($e->getMessage());
        }
        catch (UserSuspendedException $e)
        {
            throw new LoginException($e->getMessage());
        }
        catch (UserBannedException $e)
        {
            throw new LoginException($e->getMessage());
        }

    }

    /**
     * Logout the current user
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     */
    public function logout()
    {
        $user = $this->getSentry()->getUser();
        $this->getSentry()->logout();
        $this->event->fire('cpanel.user.logout',[$user]);
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