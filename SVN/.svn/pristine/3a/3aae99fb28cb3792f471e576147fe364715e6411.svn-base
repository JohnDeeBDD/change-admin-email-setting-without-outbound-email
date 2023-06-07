<?php
/*
 Plugin Name: Change Admin Email Setting Without Outbound Email
 Plugin URI: https://generalchicken.guru/change-admin-email/
 Description: Restores functionality removed since WordPress v4.9. Allows admin to change the admin email setting - without having outbound email enabled on the site, or recipient email credentials.
 Version: 3.3
 Author: John Dee
 Author URI: https://generalchicken.guru/
*/

namespace ChangeAdminEmail;

$ChangeAdminEmailPlugin = new ChangeAdminEmailPlugin;
$ChangeAdminEmailPlugin->run();

class ChangeAdminEmailPlugin{

    public function verifyNonce(){
        if (!wp_verify_nonce($_POST['change-admin-email-test-email-nonce'], 'change-admin-email')) {
            wp_die('Something is very wrong here.');
        }
    }

    //In the case that the admin has requested a pending email change BEFORE they activated the plugin,
    //and they have not actually clicked the email, or couldn't receive it for whatever reason,
    //then there will still be a "pending email change". This function kills the pending change.
    public function removePendingEmail(){
        delete_option("adminhash");
        delete_option("new_admin_email");
    }

    public function run(){
        add_action('init', array($this, 'removePendingEmail'));
        add_action('admin_notices', [new AdminNotice(), 'displayAdminNotice']);

        remove_action( 'add_option_new_admin_email', 'update_option_new_admin_email' );
        remove_action( 'update_option_new_admin_email', 'update_option_new_admin_email' );

        //When you actually complete the change, another email gets fired to the old address
        //this filter overrides this:
        add_filter('send_site_admin_email_change_email', function(){return FALSE;}, 10, 3 );

        //At this point, the only reason our nonce should be submitted, is that the user is requesting us to send
        //them an email. We must check the nonce first before this action is completed:
        if(isset($_POST['change-admin-email-test-email-nonce'])){
            add_action('init', array($this, 'verifyNonce'));
            add_action('init', array($this, 'testEmail'));
            //hooks our own custom method to update the email

        }
        add_action( 'add_option_new_admin_email', array($this, 'updateOptionAdminEmail'), 10, 2 );
        add_action( 'update_option_new_admin_email', array($this, 'updateOptionAdminEmail'), 10, 2 );

        add_action('wp_after_admin_bar_render', array($this, 'modifyOptionsGeneralForm'));
    }

    public function testEmail(){
        $email = $_POST['new_admin_email'];
        $domain = site_url();
        $url = "https://generalchicken.guru/wp-json/change-admin-email-plugin/v1/test-email";
        $response = wp_remote_post( $url, array(
                'method'      => 'POST',
                'body'        => array(
                    'email' => $email,
                    'domain' => $domain
                ),
            )
        );
        AdminNotice::displaySuccess(__('Check your email inbox. A test message has been sent to you.'));
    }

    public function updateOptionAdminEmail( $old_value, $value ) {
        update_option( 'admin_email', $value );
    }

    //Changes the form on admin area options-general.php. Doesn't do anything unless on this page.
    public function modifyOptionsGeneralForm(){
        if (function_exists('get_current_screen')) {
            $screen = get_current_screen();
            if($screen->base == "options-general"){
                add_filter( 'gettext', array($this, 'filterText'), 10, 3 );
                echo($this->returnjQuery());
            }
        }
    }

    //We use a little jQuery to modify the admin screen:
    public function returnjQuery(){
        $nonce = wp_create_nonce('change-admin-email');
        $output = <<<OUTPUT
<script>
jQuery(document).ready(function(){
    var insertInputButton = "<input type = 'submit' class = 'button button-primary' name = 'changeAdminEmailSubmit' id = 'changeAdminEmailSubmitButton' value = 'Test Email' />";
    jQuery(insertInputButton).insertAfter("#new-admin-email-description");
    
    jQuery( "#changeAdminEmailSubmitButton" ).click(function( event ) {
        event.preventDefault();
        var insertThisNonce = "<input type = 'hidden' name = 'changeAdminEmailAction' value = 'changeEmail' /><input type = 'hidden' name = 'change-admin-email-test-email-nonce' value = '$nonce' />";
        jQuery(insertThisNonce).insertAfter("#new-admin-email-description");
        jQuery("#submit").click();
	});
});
</script>
OUTPUT;
        return $output;
    }

    //Changes the English text of WP core. Inspired by https://wordpress.stackexchange.com/questions/188332/override-default-wordpress-core-translation
    public function filterText( $translated, $original, $domain ) {
        if ( $translated == "This address is used for admin purposes. If you change this, an email will be sent to your new address to confirm it. <strong>The new address will not become active until confirmed.</strong>"){
            $translated = __("This address is used for admin purposes.");
        }
        return $translated;
    }
}

//inspired by https://wordpress.stackexchange.com/questions/152033/how-to-add-an-admin-notice-upon-post-save-update
class AdminNotice{
    const NOTICE_FIELD = 'my_admin_notice_message';
    public function displayAdminNotice(){
        $option      = get_option(self::NOTICE_FIELD);
        $message     = isset($option['message']) ? $option['message'] : false;
        $noticeLevel = ! empty($option['notice-level']) ? $option['notice-level'] : 'notice-error';
        if ($message) {
            echo "<div class='notice {$noticeLevel} is-dismissible'><p>{$message}</p></div>";
            delete_option(self::NOTICE_FIELD);
        }
    }
    public static function displayError($message){self::updateOption($message, 'notice-error');}
    public static function displayWarning($message){self::updateOption($message, 'notice-warning');}
    public static function displayInfo($message){self::updateOption($message, 'notice-info');}
    public static function displaySuccess($message){self::updateOption($message, 'notice-success');}
    protected static function updateOption($message, $noticeLevel){
        update_option(self::NOTICE_FIELD, [
            'message' => $message,
            'notice-level' => $noticeLevel
        ]);
    }
}