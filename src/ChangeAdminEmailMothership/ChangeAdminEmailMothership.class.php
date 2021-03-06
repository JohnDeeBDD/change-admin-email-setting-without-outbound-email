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
                    'testEmail',
                ),
                'permission_callback' => function () {
                    return true;
                }
            )
        );
    }

    public function testEmail(){
        $to = $_REQUEST['email'];
        $domain = $_REQUEST['domain'];
        $subject = "TEST INBOUND EMAIL";
        $message = "This is an autogenerated message from generalchicken.guru, the creator of the WordPress plugin 'Change Admin Email'. Someone requested this test email from $domain. This confirms you're INBOUND email is working. If you did not request this message, it is safe to ignore. This plugin is free, and this email proves it works! Consider giving the plugin a review: https://wordpress.org/plugins/change-admin-email-setting-without-outbound-email/#reviews";
        if($this->isBlackListed($to)){
            return;
        }
        $this->addEmailUser();

        wp_mail( $to, $subject, $message );
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