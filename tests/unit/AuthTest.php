<?php

//require_once("/var/www/html/wp-content/plugins/legit/src/Mothership/autoloader.php");
//require_once("/var/www/html/wp-content/plugins/legit/src/Legit/autoloader.php");

class AuthTest extends \Codeception\TestCase\WPTestCase{


    /**
     * @test
     * request mothership confirmation email
     */
    public function doRequestMothershipConfirmationEmailTest(){
        $this->assertEquals(1, 1);
    }
}