<?php  namespace Stevemo\Cpanel\Sessions\UseCases;

class LoginUserCommand {

    public $login_attribute;
    public $password;
    public $remember;

    /**
     * @param $login_attribute
     * @param $password
     * @param $remember
     */
    function __construct($login_attribute, $password, $remember)
    {
        $this->login_attribute = $login_attribute;
        $this->password = $password;
        $this->remember = $remember;
    }

} 