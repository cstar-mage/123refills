<?php 
$installer = $this;

$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$setup->addAttribute('catalog_category', 'description_bottom', array(
		'group'             => 'General Information',
		'type'              => 'varchar',
		'backend'           => '',
		'frontend'          => '',
		'label'             => 'Description bottom',
		'input'             => 'textarea',
		'class'             => '',
		'source'            => '',
		'global'            => 0,
		'visible'           => 1,
		'required'          => 0,
		'user_defined'      => 0,
		'default'           => '',
		'searchable'        => 0,
		'filterable'        => 0,
		'comparable'        => 0,
		'visible_on_front'  => 0,
		'is_wysiwyg_enabled' => 1,
		'unique'            => 0,
		'position'          => 1,
));

$setup->updateAttribute('catalog_category', 'description_bottom', 'is_wysiwyg_enabled', 1);

$installer->endSetup();

?>