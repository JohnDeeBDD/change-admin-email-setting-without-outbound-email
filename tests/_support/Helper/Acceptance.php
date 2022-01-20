<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module{
    public function seeCookieMatches(  ) {
        //$this->getModule('WebDriver')->_initializeSession();
        $response = $this->getModule('WebDriver')->_backupSession();

        ob_start();
        var_dump($response );
        $result = ob_get_clean();
        echo("cookie: $result !!");
        echo("****************************");
    }
    
    public function restartWordPressDB() {
            $this->getModule('WPWebDriver')->_restart();
            $this->getModule('WPLoader')->_reconfigure([]);
            $this->getModule('WPDb')->_reconfigure([]);
    }
    
    
    public function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    }
}
