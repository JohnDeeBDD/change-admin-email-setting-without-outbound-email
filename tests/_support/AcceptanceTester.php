<?php


/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method void pause()
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use _generated\AcceptanceTesterActions;

	public function __construct(\Codeception\Scenario $scenario)
	{
		parent::__construct($scenario);
		require_once('/var/www/html/wp-content/plugins/parler-wordpress-php/src/Parler/autoloader.php');
		require_once('/var/www/html/wp-content/plugins/parler-wordpress-php/src/ParlerAdmin/autoloader.php');
		//require_once('//Applications/MAMP/htdocs/wp-content/plugins/parler-wordpress-php/src/Parler/autoloader.php');
		//require_once('//Applications/MAMP/htdocs/wp-content/plugins/parler-wordpress-php/src/ParlerAdmin/autoloader.php');
	}

    public function loginToParler(){
        //who am I?
        $I = /* am */ $this;

        $I->amGoingTo("log into the Parler staging server");

//this cookie must be captured from Chrome:
        $accountCookie = file_get_contents("account.cookie");

        $I->amOnUrl("https://staging.parler.com/feed");
        $I->setCookie('stagingaccount', $accountCookie);
		//var_dump($accountCookie);
		//echo"!!!!!";die();
//Go to the feed:
        $I->amOnUrl("https://staging.parler.com/feed");
        $I->wait(3);
    }

    public function loadJQueryAndExecute($jQuery){
        //who am I?
        $I = /* am */ $this;
        //from: https://stackoverflow.com/questions/10113366/load-jquery-with-javascript-and-use-jquery
        $js = <<<js
(function() {
    var script = document.createElement("SCRIPT");
    script.src = 'https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js';
    script.type = 'text/javascript';
    script.onload = function() {
        var $ = window.jQuery;
        $jQuery
    };
    document.getElementsByTagName("head")[0].appendChild(script);
})();
js;
        $I->executeJS($js);
    }

    public function createStubParlerPost($stubURL){
        //who am I?
        $I = /* am */ $this;
        //$I->amOnUrl($stubURL);
        $I->fillField(['id' => 'create-post--input'], $stubURL);
        $I->wait(3);

        $I->click("//button[@id='submit-post-button']");
        $I->wait(5);
    }

    public function cleanupStubPost(){
        //who am I?
        $I = /* am */ $this;
        $I->loginToParler();

        $I->amGoingTo("click the chevron with jQuery");
        $jQuery =

            <<<jQuery
    jQuery(".circle-mat-button").click();
jQuery;

        $I->loadJQueryAndExecute($jQuery);
        $I->wait(2);

        $I->click("Delete Post");
        $I->wait(5);
    }
}
