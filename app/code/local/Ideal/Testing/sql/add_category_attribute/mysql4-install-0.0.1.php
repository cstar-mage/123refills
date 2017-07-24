<?php
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$this->startSetup();


$setup->addAttribute('catalog_category', 'category_header_txt', array(
                        'type'              => 'varchar',
                        'frontend'          => '',
     					'backend'       => '',
                        'label'             => 'Header Text',
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
                        'unique'            => 0,
                        'position'          => 1,
));


$setup->addAttribute('catalog_product', 'header_txt', array(
		'group'         => 'Custom Tab',
		'input'         => 'textarea',
		'type'          => 'text',
		'label'         => 'Header Text',
		'backend'       => '',
		'user_defined'      => true,
		'visible'       => 1,
		'required'      => 0,
		'user_defined' => 1,
		'searchable' => 1,
		'filterable' => 0,
		'comparable'    => 0,
		'visible_on_front' => 1,
		'visible_in_advanced_search'  => 1,
		'is_html_allowed_on_front' => 0,
		'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));

$this->endSetup();


	$installer = $this;
	$installer->startSetup();
	$table = $this->getTable('cms_page');
	$query = 'ALTER TABLE `' . $table . '` ADD COLUMN `cms_header_text` TEXT CHARACTER SET utf8 DEFAULT NULL';
	$connection = Mage::getSingleton('core/resource')->getConnection('core_write');
	try {
		$connection->query($query);
	} catch (Exception $e) {

	}

	$installer->endSetup();
?>