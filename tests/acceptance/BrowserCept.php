<?php
$I = new AcceptanceTester($scenario);
$I->wantTo('See that the browser can launch');
$I->amOnUrl("https://generalchicken.guru");
$I->see("WxyzordPress");