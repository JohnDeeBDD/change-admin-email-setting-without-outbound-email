<?php

namespace ChangeAdminEmailMothership;

class ChangeAdminEmailMothership
{
    public function enableTestEmailRoute(){
        add_action('rest_api_init', array($this, 'doRegisterRoutes'));
    }

    public function doRegisterRoutes()
    {
        register_rest_route(
            'change-admin-email-plugin/v1',
            'test-email',
            array(
                'methods' => array('POST', 'GET'),
                'callback' => array(
                    new ChangeAdminEmailMothership(),
                    'doSendTestEmail',
                ),
                'permission_callback' => function () {
                    return true;
                }
            )
        );
    }

    public function doSendTestEmail(){
        $to = $_REQUEST['email'];
        $domain = $_REQUEST['domain'];
        $subject = "TEST INBOUND EMAIL";
        $from = "";
        //$message = "This is an autogenerated message from generalchicken.guru, the creator of the WordPress plugin 'Change Admin Email'. Someone requested this test email from $domain. This confirms you're INBOUND email is working. If you did not request this message, it is safe to ignore. This plugin is free, and this email proves it works! Consider giving the plugin a review: https://wordpress.org/plugins/change-admin-email-setting-without-outbound-email/#reviews";
        $message = file_get_contents('/var/www/generalchicken.guru/wp-content/plugins/change-admin-email-setting-without-outbound-email/src/ChangeAdminEmailMothership/Email.html');
        $message = str_replace("{domain}", $domain, $message);

        if($this->isBlackListed($to)){
            return;
        }
        $this->addEmailUser();
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";

// Create email headers
        $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();

        wp_mail( $to, $subject, $message, $headers );


/*
        $to = $_REQUEST['email'];
        $domain = $_REQUEST['domain'];
        $subject = "Free gift: WordPress plugin 'Email Tunnel' from General Chicken";
        //$from = "johndeebdd@gmail.com";
        //$message = "This is an autogenerated message from generalchicken.guru, the creator of the WordPress plugin 'Change Admin Email'. Someone requested this test email from $domain. This confirms you're INBOUND email is working. If you did not request this message, it is safe to ignore. This plugin is free, and this email proves it works! Consider giving the plugin a review: https://wordpress.org/plugins/change-admin-email-setting-without-outbound-email/#reviews";
        $message = file_get_contents('/var/www/generalchicken/wp-content/plugins/change-admin-email-setting-without-outbound-email/src/ChangeAdminEmailMothership/EmailTunnelEmail.html');
        //$this->addEmailUser();
        // To send HTML mail, the Content-type header must be set
        $headers  = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $headers .= 'From: '.$from."\r\n".
            'Reply-To: '.$from."\r\n" .
            'X-Mailer: PHP/' . phpversion();

        wp_mail( $to, $subject, $message, $headers );
*/
    }

    public function addEmailUser(){
        $username = $this->getUsernameFromEmail($_REQUEST['email']);
        $site = $_REQUEST['domain'];
        $email = $_REQUEST['email'];
        $args = [
            'user_login'    => $username,
            'user_url'      => $site,
            'user_email'    => $email,
            'first_name'    => "Auto",
            'last_name'     => "Added",
            'description'   => "This user was added via the Change Admin Email plugin."
        ];
        wp_insert_user( $args);
        return;
    }

    public function isBlackListed($emailFragment){
        $blackList = get_option( 'generalchicken-blacklist');


        foreach($blackList as $blackItem) {
            if (strpos($emailFragment, $blackItem) !== false) {
                return TRUE;
            }
        }
        return FALSE;
    }

    public function getUsernameFromEmail($email){
        $parts = explode("@", $email);
        $username = $parts[0];
        return $username;
    }

    public function listenForAddBlacklist(){
        if(isset($_POST['blacklistInput'])){
            
        }
    }
}
