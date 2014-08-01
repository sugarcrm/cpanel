<?php  namespace Stevemo\Cpanel\Sessions\UseCases;

class LoginUserCommand {

    public $loginAttribute;
    public $password;
    public $remember;
    public $loginName;

    /**
     * @param $loginAttribute
     * @param $password
     * @param $remember
     * @param $loginName
     */
    function __construct($loginAttribute, $password, $remember, $loginName)
    {
        $this->loginAttribute = $loginAttribute;
        $this->password = $password;
        $this->remember = $remember;
        $this->loginName = $loginName;
    }

} 