<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('See that the browser can launch');
$I->amOnUrl("https://generalchicken.net");
$I->see("WordPress");