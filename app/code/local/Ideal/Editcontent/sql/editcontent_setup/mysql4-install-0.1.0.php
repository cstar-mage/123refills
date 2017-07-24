<?php

$installer = $this;

$installer->startSetup();

$installer->run("
UPDATE `cms_page` SET
`content` = replace(`content`, ' with Magento Store', '')
WHERE `identifier` = 'no-route'
		");

$installer->endSetup(); 