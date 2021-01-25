<?php

$I = new AcceptanceTester($scenario);

$I->amGoingTo("deactive the plugin");
shell_exec ("wp plugin deactivate change-admin-email-setting-without-outbound-email/change-admin-email" );

$I->amGoingTo("create a pending site admin email change");
$I->loginAsAdmin();
$newEmail = "newemail@test.com";
$I->amOnPage("/wp-admin/options-general.php");
$I->fillField("new_admin_email", $newEmail);
$I->click("Save Changes");

$I->expect("the WordPress site options 'adminhash' and 'new_admin_email' should now exist in the DB");
$adminhash = get_option( "adminhash" );
$I->assertNotFalse($adminhash);
$newEmailFromDB = get_option( "new_admin_email");
$I->assertEquals($newEmail, $newEmailFromDB);

$I->amGoingTo("activate the plugin");
shell_exec ("wp plugin activate change-admin-email-setting-without-outbound-email/change-admin-email" );
$I->reloadPage();
$I->expect("when the plugin is activated, the two DB options are removed");
$I->expect("the two options should NOT be in the DB");
$adminhash = get_option( "adminhash" );
$I->assertFalse($adminhash, "getting this option should return 'false', because it should be non-existent!");
$newEmailFromDB = get_option( "new_admin_email");
$I->assertFalse($newEmailFromDB, "getting this option should return 'false', because it should be non-existent!");