<?php  namespace Stevemo\Cpanel\Sessions\UseCases; 

use Laracasts\Commander\CommandHandler;
use Stevemo\Cpanel\Events\EventableTrait;
use Stevemo\Cpanel\Events\UserLoggedOut;
use Stevemo\Cpanel\Users\UserRepository;

class LogoutUserCommandHandler implements CommandHandler {

    use EventableTrait;

    /**
     * @var UserRepository
     */
    protected $repo;

    /**
     * @param UserRepository $repo
     */
    function __construct(UserRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Handle the command
     *
     * @param $command
     * @return mixed
     */
    public function handle($command)
    {
        $this->repo->logout();
        $this->dispatchEvent( new UserLoggedOut($command->user) );
    }
}