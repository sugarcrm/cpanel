<?php namespace Stevemo\Cpanel\Registration\UseCases;

use Sentry;
use Event;
use Cartalyst\Sentry\Users\UserExistsException;
use Laracasts\Commander\CommandHandler;
use Laracasts\Validation\FormValidationException;

class RegisterUserCommandHandler implements CommandHandler {

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

            $user = Sentry::register($credentials);

            Event::fire('cpanel.user.register',[$user]);

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