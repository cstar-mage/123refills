<?php

$installer = $this;


$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();


$setup->addAttributeGroup('catalog_product', 'Default', 'Call for Price', 1000);

$setup->addAttribute('catalog_product', 'mfm_cfp', array(

    'group'         => 'Call for Price',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Replace Price Message/Call',
    'backend'       => '',
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'searchable' => 0,
    'filterable' => 0,
    'comparable'    => 0,
    'visible_on_front' => 0,
    'visible_in_advanced_search'  => 0,
    'is_html_allowed_on_front' => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
));

$installer->run("
CREATE TABLE IF NOT EXISTS {$this->getTable('mfmc_mfmcallforprice')} (
  `id` int(10) unsigned NOT NULL auto_increment,
  `product_id` int(10) unsigned default NULL,
  `hide_price` tinyint(3) unsigned default NULL,
  `message` varchar(255) default NULL,
  PRIMARY KEY  (`id`),
  KEY `id` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
");

$installer->endSetup(); 