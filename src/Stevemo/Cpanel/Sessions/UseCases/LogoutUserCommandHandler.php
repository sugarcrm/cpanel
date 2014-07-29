<?php  namespace Stevemo\Cpanel\Sessions\UseCases; 

use Laracasts\Commander\CommandHandler;
use Stevemo\Cpanel\Events\EventableTrait;
use Sentry;
use Stevemo\Cpanel\Events\UserLoggedOut;

class LogoutUserCommandHandler implements CommandHandler {

    use EventableTrait;

    /**
     * Handle the command
     *
     * @param $command
     * @return mixed
     */
    public function handle($command)
    {
        Sentry::logout();
        $this->dispatchEvent( new UserLoggedOut($command->user) );
    }
}