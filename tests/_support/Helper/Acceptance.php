<?php
namespace Helper;

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Acceptance extends \Codeception\Module
{
    public function seeCookieMatches(  ) {
        //$this->getModule('WebDriver')->_initializeSession();
        $response = $this->getModule('WebDriver')->_backupSession();

        ob_start();
        var_dump($response );
        $result = ob_get_clean();
        echo("cookie: $result !!");
        echo("****************************");
    }
}
