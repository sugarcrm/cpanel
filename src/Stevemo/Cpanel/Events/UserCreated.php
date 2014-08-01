<?php  namespace Stevemo\Cpanel\Events; 

class UserCreated {

    public $user;

    function __construct($user)
    {
        $this->user = $user;
    }


} 