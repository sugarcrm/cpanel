<?php  namespace Stevemo\Cpanel\Sessions\UseCases; 

use Cartalyst\Sentry\Throttling\UserBannedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException;
use Cartalyst\Sentry\Users\LoginRequiredException;
use Cartalyst\Sentry\Users\PasswordRequiredException;
use Cartalyst\Sentry\Users\UserNotActivatedException;
use Cartalyst\Sentry\Users\UserNotFoundException;
use Cartalyst\Sentry\Users\WrongPasswordException;
use Config;
use Laracasts\Commander\CommandHandler;
use Sentry;
use Stevemo\Cpanel\Events\EventableTrait;
use Stevemo\Cpanel\Events\UserLoggedIn;
use Stevemo\Cpanel\Exceptions\LoginException;

class LoginUserCommandHandler implements CommandHandler {

    use EventableTrait;

    /**
     * Sign in a user
     *
     * @author Steve Montambeault <http://stevemo.ca>
     *
     * @param $command
     * @return mixed|void
     * @throws \Stevemo\Cpanel\Exceptions\LoginException
     */
    public function handle($command)
    {
        try
        {
            $credentials = [
                Config::get('cartalyst/sentry::users.login_attribute') => $command->login_attribute,
                'password' => $command->password
            ];

            $user = Sentry::authenticate($credentials, $command->remember);

            $this->dispatchEvent( new UserLoggedIn($user));

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

}