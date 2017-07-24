<?php
$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();						
$setup->addAttributeGroup('catalog_product', 'Default', 'Eternity Information', 2000);							
$setup->addAttribute('catalog_product', 'eternity_shape', array(
			 'label'             => 'Eternity Shape',
		     'group'             => 'Eternity Information',
			 'type'              => 'varchar',
			 'input'             => 'select',
			 'backend'           => 'eav/entity_attribute_backend_array',
			 'frontend'          => '',	
			 'source'            => 'eternity/source_option',
			 'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			 'visible'           => true,
			 'required'          => false,
			 'user_defined'      => true,
			 'searchable'        => false,
			 'filterable'        => false,
			 'comparable'        => false,
			 'option'            => array ('value' => array('optionone' => array('Round'),
									 'optiontwo' => array('Emerald'),
									 'optionthree' => array('Radiant'),		
			 						 'optionfour' => array('Princess'),
			 					     'optionfive' => array('Asscher'),							 	
								)
							),
			 'visible_on_front'  => false,
			 'visible_in_advanced_search' => false,
			 'unique'            => false
));
 
$setup->addAttribute('catalog_product', 'eternity_carat', array(
		'label'             => 'Eternity Carat',
		'group'             => 'Eternity Information',
		'type'              => 'varchar',
		'input'             => 'select',
		'backend'           => 'eav/entity_attribute_backend_array',
		'frontend'          => '',
		'source'            => 'eternity/source_option',
		'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'           => true,
		'required'          => false,
		'user_defined'      => true,
		'searchable'        => false,
		'filterable'        => false,
		'comparable'        => false,
		'option'            => array ('value' => array('optionone' => array('0.05ct'),
				'optiontwo' => array('0.10ct'),
				'optionthree' => array('0.15ct'),
				'optionfour' => array('0.20ct'),
				'optionfive' => array('0.25ct'),
				'optionsix' => array('0.33ct'),
				'optionseven' => array('0.40ct'),
				'optioneight' => array('0.50ct'),						
			)
		),
		'visible_on_front'  => false,
		'visible_in_advanced_search' => false,
		'unique'            => false
));

$setup->addAttribute('catalog_product', 'eternity_quality', array(
		'label'             => 'Eternity Quality',
		'group'             => 'Eternity Information',
		'type'              => 'varchar',
		'input'             => 'select',
		'backend'           => 'eav/entity_attribute_backend_array',
		'frontend'          => '',
		'source'            => 'eternity/source_option',
		'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'           => true,
		'required'          => false,
		'user_defined'      => true,
		'searchable'        => false,
		'filterable'        => false,
		'comparable'        => false,
		'option'            => array ('value' => array('optionone' => array('F VS2'),
				'optiontwo' => array('G SI1'),
				'optionthree' => array('JK IND'),				
		)
		),
		'visible_on_front'  => false,
		'visible_in_advanced_search' => false,
		'unique'            => false
));

$setup->addAttribute('catalog_product', 'eternity_metal', array(
		'label'             => 'Eternity Metal',
		'group'             => 'Eternity Information',
		'type'              => 'varchar',
		'input'             => 'select',
		'backend'           => 'eav/entity_attribute_backend_array',
		'frontend'          => '',
		'source'            => 'eternity/source_option',
		'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'           => true,
		'required'          => false,
		'user_defined'      => true,
		'searchable'        => false,
		'filterable'        => false,
		'comparable'        => false,
		'option'            => array ('value' => array('optionone' => array('14K White Gold'),
				'optiontwo' => array('Platinum'),
				'optionthree' => array('18K White Gold'),
		)
		),
		'visible_on_front'  => false,
		'visible_in_advanced_search' => false,
		'unique'            => false
));

$setup->addAttribute('catalog_product', 'eternity_setting_style', array(
		'label'             => 'Eternity Setting Style',
		'group'             => 'Eternity Information',
		'type'              => 'varchar',
		'input'             => 'select',
		'backend'           => 'eav/entity_attribute_backend_array',
		'frontend'          => '',
		'source'            => 'eternity/source_option',
		'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'           => true,
		'required'          => false,
		'user_defined'      => true,
		'searchable'        => false,
		'filterable'        => false,
		'comparable'        => false,
		'option'            => array ('value' => array('optionone' => array('3-Prong Martini'),
				'optiontwo' => array('4-Prong Basket'),
				'optionthree' => array('4-Prong Crown'),
				'optionfour' => array('Bezel'),
				'optionfive' => array('Halo'),
				'optionsix' => array('Lever Back'),			
		)
		),
		'visible_on_front'  => false,
		'visible_in_advanced_search' => false,
		'unique'            => false
));

$setup->addAttribute('catalog_product', 'eternity_ringsize', array(
		'label'             => 'Eternity Ring Size',
		'group'             => 'Eternity Information',
		'type'              => 'varchar',
		'input'             => 'select',
		'backend'           => 'eav/entity_attribute_backend_array',
		'frontend'          => '',
		'source'            => 'eternity/source_option',
		'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'           => true,
		'required'          => false,
		'user_defined'      => true,
		'searchable'        => false,
		'filterable'        => false,
		'comparable'        => false,
		'option'            => array ('value' => array('optionone' => array('3.5'),
				'optiontwo' => array('3.75'),
				'optionthree' => array('4'),
				'optionfour' => array('4.25'),
				'optionfive' => array('4.5'),
				'optionsix' => array('4.75'),
				'optionseven' => array('5'),
				'optioneight' => array('5.25'),
				'optionnine' => array('5.5'),
				'optionten' => array('5.75'),
				'optioneleven' => array('6'),
				'optiontwelve' => array('6.25'),
				'optionthirteen' => array('6.5'),
				'optionfourteen' => array('6.75'),
				'optionfifteen' => array('7'),
				'optionsixteen' => array('7.25'),
				'optionseventeen' => array('7.5'),
				'optioneighteen' => array('7.75'),
				'optionnighteen' => array('8'),
		)
		),
		'visible_on_front'  => false,
		'visible_in_advanced_search' => false,
		'unique'            => false
));

$installer->endSetup();