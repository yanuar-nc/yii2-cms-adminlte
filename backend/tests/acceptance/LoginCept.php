<?php
$I = new AcceptanceTester($scenario);
$I->am('tester');
$I->wantTo('login to website');
$I->lookForwardTo('access all website features');
$I->amOnPage('/site/login');
$I->see('Sign in');

$I->am('yanuar');
$I->fillField('LoginForm[username]','yanuar');
$I->fillField('LoginForm[password]','gr33nc**r3.');
$I->click('Sign In');
$I->see('Dashboard');

$page = $I->haveFriend('page');
$page->does(function(AcceptanceTester $I){
	$I->amOnPage('/page/index');
	$I->see('Page');
});