<?php  namespace Stevemo\Cpanel\Users\UseCases; 

use Laracasts\Validation\FormValidator;

class CreateUserValidator extends FormValidator {

    /**
     * validation rules for the Registration form
     * @var array
     */
    protected $rules = [
        'first_name' => 'required',
        'last_name'  => 'required',
        'email'      => 'required|email|unique:users',
        'password'   => 'required|confirmed'
    ];

} 