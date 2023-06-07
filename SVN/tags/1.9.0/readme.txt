=== Change Admin Email ===
Contributors: johndeebdd
Donate link: https://generalchicken.net/
Tags: rollback, email, admin_email
Requires at least: 4.9
Tested up to: 5.0.2
Requires PHP: 5.3
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Stable tag: trunk

A new "feature" of WordPress 4.9 is that the administrator cannot change the site admin email without outgoing email setup on the server, and recipient email credentials. This plugin restores the admin\'s ability to change this setting without sending a confirmation email.

== Description ==
This plugin restores the functionality as it was before version 4.9 on single sites. This may be required on sites without email access or for testing purposes, i.e. on localhost. It does not effect the API at all.

## Usage
Once activated, you do not need to do anything. You can change the admin email without outbound email traffic. 

== Screenshots ==
1. The general settings screen before WordPress version 4.9
2. The general settings screen after WordPress ersion 4.9

== Development ==
## Behavior Driven Developent Testing Bonus for Developers
This plugin is distributed with Behavior Driven Development tests written for Codeception. Visit [GeneralChicken.net](https://generalchicken.netm) for more information.

== Installation ==
Clone or copy the file into your plugins directory, then activate the plugin from the admin menu. No other settings required.
