<?php
/*
 Plugin Name: Change Admin Email Mothership
 Plugin URI: https://generalchicken.guru/
 Version: 99
 Author: John Dee
 Author URI: https://generalchicken.guru/
*/

namespace ChangeAdminEmailMothership;

require_once (plugin_dir_path(__FILE__). 'src/ChangeAdminEmailMothership/autoloader.php');

$ChangeAdminEmailMothership = new ChangeAdminEmailMothership;
$ChangeAdminEmailMothership->enableTestEmailRoute();

$SettingsPage = new SettingsPage;
$SettingsPage->enable();

//https://plugins.svn.wordpress.org/change-admin-email-setting-without-outbound-email