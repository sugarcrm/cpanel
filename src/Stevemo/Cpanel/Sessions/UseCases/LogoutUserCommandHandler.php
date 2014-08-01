<?php  namespace Stevemo\Cpanel\Sessions\UseCases; 

use Cartalyst\Sentry\Sentry;
use Laracasts\Commander\CommandHandler;
use Stevemo\Cpanel\Events\EventableTrait;
use Stevemo\Cpanel\Events\UserLoggedOut;

class LogoutUserCommandHandler implements CommandHandler {

    use EventableTrait;

    /**
     * @var Sentry
     */
    protected $sentry;

    /**
     * @param Sentry $sentry
     */
    function __construct(Sentry $sentry)
    {
        $this->sentry = $sentry;
    }

    /**
     * Handle the command
     *
     * @param $command
     * @return mixed
     */
    public function handle($command)
    {
        $this->sentry->logout();
        $this->dispatchEvent( new UserLoggedOut($command->user) );
    }
}