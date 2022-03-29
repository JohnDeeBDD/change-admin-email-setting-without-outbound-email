<?php
$I = new AcceptanceTester($scenario);

$I->amGoingTo("deactive the plugin");
shell_exec("wp plugin deactivate change-admin-email-setting-without-outbound-email/change-admin-email");

$I->amGoingTo("create a pending site admin email change with the plugin deactivated");
$I->loginAsAdmin();
$newEmail = $I->generateRandomString() . "@testemail.com";
$I->amOnPage("/wp-admin/options-general.php");
$I->fillField("new_admin_email", $newEmail);
$I->click("Save Changes");

$I->expect("the WordPress site options 'adminhash' and 'new_admin_email' should now exist in the DB");
$adminhash = shell_exec("wp option get adminhash");
//if the CLI returns an array, then there is something in the hash data:
$I->assertTrue( str_contains($adminhash, "array"));
        
$I->amGoingTo("activate the plugin");
$I->expect("the plugin to remove the admin hash from the options db");

shell_exec("wp plugin activate change-admin-email-setting-without-outbound-email/change-admin-email");
$adminhash = shell_exec("wp option get adminhash");
$I->assertEquals( NULL, $adminhash);

//Cleanup email log:
$I->amOnPage("/wp-admin/admin.php?page=email-log");
$I->moveMouseOver( '.sent_date' );
$I->click(".delete");