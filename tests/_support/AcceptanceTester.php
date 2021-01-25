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
		//require_once('/var/www/html/wp-content/plugins/parler-wordpress-php/src/Parler/autoloader.php');
		//require_once('/var/www/html/wp-content/plugins/parler-wordpress-php/src/ParlerAdmin/autoloader.php');
		//require_once('//Applications/MAMP/htdocs/wp-content/plugins/parler-wordpress-php/src/Parler/autoloader.php');
		//require_once('//Applications/MAMP/htdocs/wp-content/plugins/parler-wordpress-php/src/ParlerAdmin/autoloader.php');
	}
}
