<?php  namespace Stevemo\Cpanel\Users\UseCases;

use Laracasts\Commander\CommandHandler;
use Stevemo\Cpanel\Events\EventableTrait;
use Stevemo\Cpanel\Events\UserCreated;
use Stevemo\Cpanel\Users\UserRepository;

class CreateUserCommandHandler implements CommandHandler {

    use EventableTrait;

    /**
     * @var
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
        $credentials = [
            'first_name' => $command->first_name,
            'last_name'  => $command->last_name,
            'email'      => $command->email,
            'password'   => $command->password
        ];

        $user = $this->repo->register($credentials,$command->activate);

        $this->assignToGroup($command->groups, $user);

        $this->dispatchEvent( new UserCreated($user));

        return $user;
    }

    /**
     * Assign the user to groups
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     * @param array $groupIds
     * @param $user
     *
     */
    private function assignToGroup(array $groupIds, $user)
    {
        foreach ( $groupIds as $groupId )
        {
            $this->repo->assignGroupById($groupId,$user);
        }

    }
}