<?php  namespace Stevemo\Cpanel\Users; 

use Illuminate\Container\Container;

class UserRepository {

    /**
     * @var Container
     */
    protected $container;

    /**
     * @var \Cartalyst\Sentry\Sentry
     */
    protected $sentry;

    /**
     * @param Container $container
     */
    function __construct(Container $container)
    {
        $this->container = $container;
        $this->sentry = $this->getSentry();
    }

    /**
     * Authenticate a user;
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     * @param array $credentials
     * @param bool $remember
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function authenticate(array $credentials, $remember = false)
    {
        return $this->sentry->authenticate($credentials, $remember);
    }

    /**
     * Logout the current user
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     */
    public function logout()
    {
        return $this->sentry->logout();
    }

    /**
     * Register a user
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     * @param array $credentials
     * @param bool $activate
     * @return \Cartalyst\Sentry\Users\UserInterface
     */
    public function register(array $credentials, $activate = false)
    {
        return $this->sentry->register($credentials,$activate);
    }

    /**
     * assign the user to a group
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     * @param $groupId
     * @param $user
     * @return mixed
     */
    public function assignGroupById($groupId, $user)
    {
        $group = $this->sentry->findGroupById($groupId);
        $user->addGroup($group);
        return $user;
    }


    /**
     * Get sentry instance
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     * @return \Cartalyst\Sentry\Sentry
     */
    public function getSentry()
    {
        return $this->container->make('sentry');
    }
} 