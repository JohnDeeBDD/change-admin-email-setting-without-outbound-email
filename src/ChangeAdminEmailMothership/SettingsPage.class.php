<?php

namespace ChangeAdminEmailMothership;

class SettingsPage{
    
    public function enable(){
        add_action( 'admin_menu', array($this, 'addMenuPage' ));
        $this->listenForAddBlacklistSubmission();
        if(isset($_GET['showBlacklist']))
        {
            $this->outputBlacklist();
        }
        
    }

    public function addMenuPage() {
        $user = wp_get_current_user();
        if ( (in_array( 'administrator', (array) $user->roles ) )  ) {
            add_menu_page( "mothership", "Mother Ship", "edit_posts","mothership", array($this, "renderMothershipAdminSettingsPage"));
        }   
    }

    public function renderMothershipAdminSettingsPage(){
        $nonceField = wp_create_nonce( 'useMothershipSettingsPage');
        $output = <<<OUTPUT
<div id = "wpbody" role = "main">
   <div id = "wpbody-content">
      <div class = "wrap">
         <h1>
Mothership
         </h1>
         <form method = "post">
<label>Enter a email to be blacklisted</label>
<input type="text" name="blacklistInput">
<input type="submit" name="blacklistSubmit">
<br />
<a href = "/wp-admin/admin.php?page=mothership&showBlacklist=TRUE">SHOW BLACKLISTED EMAILS</a>

         </form>
      </div>
      <!-- END: #wrap -->
   </div>
   <!-- END: #wpbody-content -->
</div>
<!-- END: #wpbody -->
OUTPUT;
        echo $output;
    }
    
    public function listenForAddBlacklistSubmission(){
        $blackList = array();
        if(isset($_POST['blacklistSubmit'])){
        //die("submitting!");
            if(get_option("generalchicken-blacklist")){
                $email = $_POST['blacklistInput'];
                $blackList = get_option('generalchicken-blacklist');
                array_push($blackList, $email);
                update_option('generalchicken-blacklist', $blackList);
            }
            else{
                $email = $_POST['blacklistInput'];
                array_push($blackList, $email);
                update_option('generalchicken-blacklist', $blackList);
            }
        }
    }
    
    public function outputBlacklist(){
        
            if(get_option("generalchicken-blacklist")){
               
                $blackList = get_option('generalchicken-blacklist');
                var_dump($blackList);
                die();
            }
    }
}