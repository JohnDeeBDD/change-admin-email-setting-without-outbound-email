<?php

$I = new AcceptanceTester($scenario);

$I->loginAsAdmin();
$I->amOnPage("/wp-admin/options-general.php");

$formFieldName = "new_admin_email";
$startingEmail = $I->grabValueFrom($formFieldName);
$testEmails = array(" ", "email2@test.dev");
    
foreach($testEmails as $email){
    $I->fillField($formFieldName, $email);
    $I->click("Save Changes");
    $newAdminEmailField = $I->grabValueFrom($formFieldName);
    $I->assertEquals($email, $newAdminEmailField);
}

$I->fillField($formFieldName, $startingEmail);
$I->click("Save Changes");
$newAdminEmailField = $I->grabValueFrom($formFieldName);
$I->assertEquals($startingEmail, $newAdminEmailField);