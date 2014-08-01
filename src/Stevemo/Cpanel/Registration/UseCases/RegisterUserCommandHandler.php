<?php namespace Stevemo\Cpanel\Registration\UseCases;

use Cartalyst\Sentry\Users\UserExistsException;
use Laracasts\Commander\CommandHandler;
use Laracasts\Validation\FormValidationException;
use Stevemo\Cpanel\Events\EventableTrait;
use Stevemo\Cpanel\Events\UserRegistered;
use Stevemo\Cpanel\Users\UserRepository;

class RegisterUserCommandHandler implements CommandHandler {

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
     * @throws \Laracasts\Validation\FormValidationException
     * @return mixed
     */
    public function handle($command)
    {
        try
        {
            $credentials = [
                'first_name' => $command->first_name,
                'last_name'  => $command->last_name,
                'email'      => $command->email,
                'password'   => $command->password
            ];

            $user = $this->repo->register($credentials);

            $this->dispatchEvent( new UserRegistered($user) );

            return $user;
        }
        catch (UserExistsException $e)
        {
            throw new FormValidationException($e->getMessage(),$e->getMessage());
        }
        catch (LoginRequiredException $e)
        {
            throw new FormValidationException($e->getMessage(),$e->getMessage());
        }
        catch (PasswordRequiredException $e)
        {
            throw new FormValidationException($e->getMessage(),$e->getMessage());
        }
    }
}