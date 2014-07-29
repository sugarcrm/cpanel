<?php  namespace Stevemo\Cpanel\Users\UseCases;

class CreateUserCommand {

    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $password_confirmation;
    public $groups;
    public $activate;


    function __construct(
        $activate = false,
        $email,
        $first_name,
        $groups = [],
        $last_name,
        $password,
        $password_confirmation
    )
    {
        $this->activate = $activate;
        $this->email = $email;
        $this->first_name = $first_name;
        $this->groups = $groups;
        $this->last_name = $last_name;
        $this->password = $password;
        $this->password_confirmation = $password_confirmation;
    }


} 