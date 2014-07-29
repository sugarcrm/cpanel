<?php

return array(

    // route prefix
    'prefix' => 'admin',

    //Generic Permissions
    'generic_permission' => array('view','create','update','delete'),

    'site_config' => array(
        'site_name'   => 'Cpanel',
        'title'       => 'My Admin Panel',
        'description' => 'Laravel 4 Admin Panel'
    ),

    'commands' => array(
        'login' => 'Stevemo\Cpanel\Sessions\UseCases\LoginUserCommand',
        'logout' => 'Stevemo\Cpanel\Sessions\UseCases\LogoutUserCommand',
        'register' => 'Stevemo\Cpanel\Registration\UseCases\RegisterUserCommand',
        'create_user' => 'Stevemo\Cpanel\Users\UseCases\CreateUserCommand',
    ),
);
