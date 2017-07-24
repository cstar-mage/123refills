<?php
$installer = $this;
$setup = new Mage_Eav_Model_Entity_Setup('core_setup');
$installer->startSetup();						
							
$setup->addAttribute('catalog_product', 'stud_shape', array(
			 'label'             => 'Stud Shape',
			 'type'              => 'varchar',
			 'input'             => 'select',
			 'backend'           => 'eav/entity_attribute_backend_array',
			 'frontend'          => '',	
			 'source'            => 'stud/source_option',
			 'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
			 'visible'           => true,
			 'required'          => false,
			 'user_defined'      => true,
			 'searchable'        => false,
			 'filterable'        => false,
			 'comparable'        => false,
			 'option'            => array ('value' => array('optionone' => array('Asscher'),
									 'optiontwo' => array('Baguette'),
									 'optionthree' => array('Cushion'),		
			 						 'optionfour' => array('Emerald'),
			 					     'optionfive' => array('Heart'),
							 		 'optionsix' => array('Marquise'),
							 		 'optionseven' => array('Oval'),
							 	     'optioneight' => array('Pear'),
							 		 'optionnine' => array('Princess'),
							 		 'optionten' => array('Radiant'),
							 		 'optioneleven' => array('Round'),
							 		 'optiontwelve' => array('Trillion'),
								)
							),
			 'visible_on_front'  => false,
			 'visible_in_advanced_search' => false,
			 'unique'            => false
));
 
$setup->addAttribute('catalog_product', 'stud_carat', array(
		'label'             => 'Stud Carat',
		'type'              => 'varchar',
		'input'             => 'select',
		'backend'           => 'eav/entity_attribute_backend_array',
		'frontend'          => '',
		'source'            => 'stud/source_option',
		'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'           => true,
		'required'          => false,
		'user_defined'      => true,
		'searchable'        => false,
		'filterable'        => false,
		'comparable'        => false,
		'option'            => array ('value' => array('optionone' => array('0.50'),
				'optiontwo' => array('0.66'),
				'optionthree' => array('0.75'),
				'optionfour' => array('1'),
				'optionfive' => array('1.25'),
				'optionsix' => array('1.50'),
				'optionseven' => array('2'),
				'optioneight' => array('2.50'),
				'optionnine' => array('3'),			
			)
		),
		'visible_on_front'  => false,
		'visible_in_advanced_search' => false,
		'unique'            => false
));

$setup->addAttribute('catalog_product', 'stud_clarity', array(
		'label'             => 'Stud Clarity',
		'type'              => 'varchar',
		'input'             => 'select',
		'backend'           => 'eav/entity_attribute_backend_array',
		'frontend'          => '',
		'source'            => 'stud/source_option',
		'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'           => true,
		'required'          => false,
		'user_defined'      => true,
		'searchable'        => false,
		'filterable'        => false,
		'comparable'        => false,
		'option'            => array ('value' => array('optionone' => array('ind'),
				'optiontwo' => array('si'),
				'optionthree' => array('vs'),				
		)
		),
		'visible_on_front'  => false,
		'visible_in_advanced_search' => false,
		'unique'            => false
));

$setup->addAttribute('catalog_product', 'stud_color', array(
		'label'             => 'Stud Color',
		'type'              => 'varchar',
		'input'             => 'select',
		'backend'           => 'eav/entity_attribute_backend_array',
		'frontend'          => '',
		'source'            => 'stud/source_option',
		'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'           => true,
		'required'          => false,
		'user_defined'      => true,
		'searchable'        => false,
		'filterable'        => false,
		'comparable'        => false,
		'option'            => array ('value' => array('optionone' => array('fg'),
				'optiontwo' => array('hi'),
				'optionthree' => array('jk'),
		)
		),
		'visible_on_front'  => false,
		'visible_in_advanced_search' => false,
		'unique'            => false
));

$setup->addAttribute('catalog_product', 'stud_cut', array(
		'label'             => 'Stud Cut',
		'type'              => 'varchar',
		'input'             => 'select',
		'backend'           => 'eav/entity_attribute_backend_array',
		'frontend'          => '',
		'source'            => 'stud/source_option',
		'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'           => true,
		'required'          => false,
		'user_defined'      => true,
		'searchable'        => false,
		'filterable'        => false,
		'comparable'        => false,
		'option'            => array ('value' => array('optionone' => array('Ideal-Excellent Cut'),
				'optiontwo' => array('Very Good Cut'),				
		)
		),
		'visible_on_front'  => false,
		'visible_in_advanced_search' => false,
		'unique'            => false
));


$setup->addAttribute('catalog_product', 'stud_metal', array(
		'label'             => 'Stud Metal',
		'type'              => 'varchar',
		'input'             => 'select',
		'backend'           => 'eav/entity_attribute_backend_array',
		'frontend'          => '',
		'source'            => 'stud/source_option',
		'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'           => true,
		'required'          => false,
		'user_defined'      => true,
		'searchable'        => false,
		'filterable'        => false,
		'comparable'        => false,
		'option'            => array ('value' => array('optionone' => array('14k Rose Gold'),
				'optiontwo' => array('14k White Gold'),
				'optionthree' => array('14k Yellow Gold'),
				'optionfour' => array('18k Rose Gold'),
				'optionfive' => array('18k White Gold'),
				'optionsix' => array('18k Yellow Gold'),
				'optionseven' => array('Platinum'),
		)
		),
		'visible_on_front'  => false,
		'visible_in_advanced_search' => false,
		'unique'            => false
));

$setup->addAttribute('catalog_product', 'stud_setting_style', array(
		'label'             => 'Stud Setting Style',
		'type'              => 'varchar',
		'input'             => 'select',
		'backend'           => 'eav/entity_attribute_backend_array',
		'frontend'          => '',
		'source'            => 'stud/source_option',
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

$setup->addAttribute('catalog_product', 'stud_backing_type', array(
		'label'             => 'Stud Backing Type',
		'type'              => 'varchar',
		'input'             => 'select',
		'backend'           => 'eav/entity_attribute_backend_array',
		'frontend'          => '',
		'source'            => 'stud/source_option',
		'global'            => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
		'visible'           => true,
		'required'          => false,
		'user_defined'      => true,
		'searchable'        => false,
		'filterable'        => false,
		'comparable'        => false,
		'option'            => array ('value' => array('optionone' => array('Push-Back'),
				'optiontwo' => array('Screw Back'),
		)
		),
		'visible_on_front'  => false,
		'visible_in_advanced_search' => false,
		'unique'            => false
));

$installer->endSetup();