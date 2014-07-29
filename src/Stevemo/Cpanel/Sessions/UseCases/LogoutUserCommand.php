<?php  namespace Stevemo\Cpanel\Sessions\UseCases; 

class LogoutUserCommand {

    /**
     * @var \Cartalyst\Sentry\Users\UserInterface
     */
    public $user;

    /**
     * @param \Cartalyst\Sentry\Users\UserInterface     $user
     */
    function __construct($user)
    {
        $this->user = $user;
    }

} 