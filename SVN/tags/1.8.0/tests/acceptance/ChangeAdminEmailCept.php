<?php

$I = new AcceptanceTester($scenario);

$I->loginAsAdmin();
$I->amOnPage("/wp-admin/options-general.php");


$formFieldName = "admin_email";
//The name of the field changes in 4.9. So we have to detect the field name:
try{
    $formFieldName = $I->grabValueFrom($formFieldName);
    $formFieldName = "admin_email";
}
    catch(\PHPUnit_Framework_AssertionFailedError $f){
        $formFieldName = "new_admin_email";
    }
    
$startingEmail = $I->grabValueFrom($formFieldName);
$testEmails = array("email1@test.dev", "email2@test.dev");
    
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