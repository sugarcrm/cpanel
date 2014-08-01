<?php namespace Codeception\Module;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class FunctionalHelper extends \Codeception\Module
{

    public function signIn()
    {
        $I = $this->getModule('Laravel4');

        $I->amOnPage('/admin/login');
        $I->fillField('loginAttribute', 'joe@example.com');
        $I->fillField('password', 'secret');
        $I->click('Sign In');
    }

}