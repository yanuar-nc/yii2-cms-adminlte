<?php
$I = new AcceptanceTester($scenario);
$I->am('tester');
$I->wantTo('see login page');
// $I->lookForwardTo('access all website features');
$I->amOnPage('/site/login');
$I->see('Sign in');

$I->am('wrongadmin');
$I->wantTo('try to login using wrong password');
$I->fillField('LoginForm[username]','admin');
$I->fillField('LoginForm[password]','wrongpassword');
$I->click('Sign In');
$I->see('Incorrect username or password.');

$I->amOnPage('/site/login');
$I->am('correctadmin');
$I->wantTo('try to login using correct password');
$I->fillField('LoginForm[username]','admin');
$I->fillField('LoginForm[password]','microad!234');
$I->click('Sign In');
$I->see('Dashboard');

$page = $I->haveFriend('page');
$page->does(function(AcceptanceTester $I){
	$I->amOnPage('/page/index');
	$I->see('Page');
});