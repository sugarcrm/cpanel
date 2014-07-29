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
        'logout_user' => 'Stevemo\Cpanel\Sessions\UseCases\LogoutUserCommand',
        'register_user' => 'Stevemo\Cpanel\Registration\UseCases\RegisterUserCommand',
    ),
);
