<?php 
$I = new FunctionalTester($scenario);

$I->am('a guest');
$I->wantTo('register for an account');

$I->amOnPage('/admin/register');

$I->fillField('first_name','Foo');
$I->fillField('last_name','Bar');
$I->fillField('email','foo@example.com');
$I->fillField('password','secret');
$I->fillField('password_confirmation','secret');
$I->click('Sign me up');

$I->seeInDatabase('users',['email' => 'foo@example.com']);
$I->seeCurrentUrlEquals('/admin/login');
$I->see('Congratulation! You are now registered.');
