<?php  namespace Stevemo\Cpanel\Users; 

use Cartalyst\Sentry\Sentry;

class UserRepository {

    /**
     * @var \Cartalyst\Sentry\Sentry
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


} 