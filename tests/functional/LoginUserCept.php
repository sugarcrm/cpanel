<?php 
$I = new FunctionalTester($scenario);

$I->am('a register user');
$I->wantTo('Login into the Cpanel');

$I->signIn();

$I->seeCurrentUrlEquals('/admin');
$I->see('You are now logged in.');

$I->assertTrue(Sentry::check());
