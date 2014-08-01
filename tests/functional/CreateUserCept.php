<?php 
$I = new FunctionalTester($scenario);
$I->am('a Cpanel Admin');
$I->wantTo('create a new user');

$I->signIn();

$I->amOnPage('/admin/users/create');

$I->fillField('first_name','John');
$I->fillField('last_name','Doe');
$I->fillField('email','johndoe@example.com');
$I->fillField('password','secret');
$I->fillField('password_confirmation','secret');
$I->selectOption('activate','1');
$I->selectOption('groups[]','3');
$I->click('Save');

$I->seeInDatabase('users',['email' => 'johndoe@example.com','first_name' => 'John']);
$I->seeCurrentUrlEquals('/admin/users');
$I->see('User created.');
