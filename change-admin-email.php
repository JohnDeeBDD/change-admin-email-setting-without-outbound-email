<?php
/*
 Plugin Name: Change Admin Email Setting Without Outbound Email
 Plugin URI: https://wp-bdd.com/change-admin-email/
 Description: Restores functionality removed since WordPress 4.9. Allows the changing of the admin email by admins in single site without outbound email or recipient email credentials.
 Version: 1.2
 Author: John Dee
 Author URI: https://wp-bdd.com/
*/

$ChangeAdminEmailPlugin = new ChangeAdminEmailPlugin;

class ChangeAdminEmailPlugin{
    
    public function __construct(){
        
        //This plugin doesn't do anything unless it's WordPres version +4.9 and single site
        if($this->isWordPressMinimiumVersion("4.9.0") && (!( is_multisite()))){
            //pulls the default actions
            remove_action( 'add_option_new_admin_email', 'update_option_new_admin_email' );
            remove_action( 'update_option_new_admin_email', 'update_option_new_admin_email' );
            
            //When you actually complete the change, another email gets fired to the old address
            //this filter overides this:
            add_filter('send_site_admin_email_change_email', function(){return FALSE;}, 10, 3 );

            //hooks our own custom method to update the email
            add_action( 'add_option_new_admin_email', array($this, 'updateOptionAdminEmail'), 10, 2 );
            add_action( 'update_option_new_admin_email', array($this, 'updateOptionAdminEmail'), 10, 2 );
            
            //this fixes the text in English. Translators wanted for other languages.
            add_action('wp_after_admin_bar_render', array($this, 'modifyOptionsGeneralPHPForm'));
        }
    }
    
    public function updateOptionAdminEmail( $old_value, $value ) {
        update_option( 'admin_email', $value );
    }
    
    public function isWordPressMinimiumVersion($version){
        global $wp_version;
        if (version_compare($wp_version, $version, ">=")) {
            return TRUE;
        } else {
            return FALSE;
        }
    }
    
    //Changes the form on admin area options-general.php. Doesn't do anything unless on this page.
    public function modifyOptionsGeneralPHPForm(){
        if (function_exists('get_current_screen')) {
		$screen = get_current_screen();
        	if($screen->base == "options-general"){
            	     add_filter( 'gettext', array($this, 'filterText'), 10, 3 );
        	}
	}
    }
    
    //Changes the English text of WP core. Inspired by https://wordpress.stackexchange.com/questions/188332/override-default-wordpress-core-translation
    public function filterText( $translated, $original, $domain ) {
        if ( $translated == "This address is used for admin purposes. If you change this we will send you an email at your new address to confirm it. <strong>The new address will not become active until confirmed.</strong>"){
            $translated = __("This address is used for admin purposes.");
        }
        return $translated;
    }
    
}
