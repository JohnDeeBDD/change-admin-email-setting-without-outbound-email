<?php
$I = new AcceptanceTester($scenario);

$I->loginAsAdmin();

//random email:
$newEmail = $I->generateRandomString() . "@testemail.com";

$I->amGoingTo("change the admin email");
$I->amOnPage("/wp-admin/options-general.php");
$I->fillField("new_admin_email", $newEmail);
$I->click("Test Email");

$I->expect("a email to have been sent and visable in the email log");
$I->amOnPage("/wp-admin/admin.php?page=email-log");
$pageSource = $I->grabPageSource();
$I->assertTrue(str_contains($pageSource, $newEmail));

//Cleanup email log:
$I->moveMouseOver( '.sent_date' );
$I->click(".delete");