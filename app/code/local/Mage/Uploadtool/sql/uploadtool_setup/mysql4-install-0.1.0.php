<?php

$installer = $this;

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$installer->startSetup();


/*$installer->run("

-- DROP TABLE IF EXISTS {$this->getTable('uploadtool')};
CREATE TABLE {$this->getTable('uploadtool')} ( 
  `uploadtool_id` int(11) unsigned NOT NULL auto_increment,
  `title` varchar(255) NOT NULL default '',
  `filename` varchar(255) NOT NULL default '',
  `content` text NOT NULL default '',
  `status` smallint(6) NOT NULL default '0',
  `created_time` datetime NULL,
  `update_time` datetime NULL,
  PRIMARY KEY (`uploadtool_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

    ");*/

$setup->addAttribute('catalog_product', 'diamond_carat', array(
    'group'         => 'General',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Carat',
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


/*$setup->addAttribute('catalog_product', 'diamond_clarity ', array(
    'group'         => 'General',
    'input'         => 'select',
    'type'          => 'text',
	'source'        => 'Uploadtool/product_attribute_source_clarity',
    'label'         => 'clarity',
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
));*/


/*$setup->addAttribute('catalog_product', 'diamond_color', array(
    'group'         => 'General',
    'input'         => 'select',
    'type'          => 'text',
	'source'        => 'Uploadtool/product_attribute_source_color',
    'label'         => 'Diamond Color',
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
*/

/*$setup->addAttribute('catalog_product', 'diamond_cut ', array(
    'group'         => 'General',
    'input'         => 'select',
    'type'          => 'text',
	'source'        => 'Uploadtool/product_attribute_source_cut',
    'label'         => 'Cut',
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
));*/


/*$setup->addAttribute('catalog_product', 'diamond_cutlet', array(
    'group'         => 'General',
    'input'         => 'select',
    'type'          => 'text',
	'source'        => 'Uploadtool/product_attribute_source_cutlet',
    'label'         => 'Cutlet',
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
));*/


$setup->addAttribute('catalog_product', 'diamond_depth', array(
    'group'         => 'General',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Depth',
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

/*$setup->addAttribute('catalog_product', 'diamond_fluor', array(
    'group'         => 'General',
    'input'         => 'select',
    'type'          => 'text',
	'source'        => 'Uploadtool/product_attribute_source_fluor',
    'label'         => 'Fluor',
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
));*/

/*$setup->addAttribute('catalog_product', 'diamond_girdle', array(
    'group'         => 'General',
    'input'         => 'select',
    'type'          => 'text',
	'source'        => 'Uploadtool/product_attribute_source_girdle',
    'label'         => 'Girdle',
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
));*/


/*$setup->addAttribute('catalog_product', 'diamond_polish', array(
    'group'         => 'General',
    'input'         => 'select',
    'type'          => 'text',
	'source'        => 'Uploadtool/product_attribute_source_polish',
    'label'         => 'Polish',
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
*/

/*$setup->addAttribute('catalog_product', 'diamond_shape', array(
    'group'         => 'General',
    'input'         => 'select',
    'type'          => 'text',
	'source'        => 'Uploadtool/product_attribute_source_shape',
    'label'         => 'Shape',
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
*/

/*$setup->addAttribute('catalog_product', 'diamond_symmetry', array(
    'group'         => 'General',
    'input'         => 'select',
    'type'          => 'text',
	'source'        => 'Uploadtool/product_attribute_source_symmetry',
    'label'         => 'Symmetry',
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
));*/


$setup->addAttribute('catalog_product', 'diamond_table', array(
    'group'         => 'General',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Table',
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


$setup->addAttribute('catalog_product', 'crown_angle', array(
    'group'         => 'General',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Crown Angle',
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


$setup->addAttribute('catalog_product', 'crown_height', array(
    'group'         => 'General',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Crown Height',
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


$setup->addAttribute('catalog_product', 'pavilion_height', array(
    'group'         => 'General',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Pavilion Height ',
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


$setup->addAttribute('catalog_product', 'dimension_heigth', array(
    'group'         => 'General',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Dimension - Height',
    'backend'       => '',
	'user_defined'      => true,
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'searchable' => 0,
    'filterable' => 0,
    'comparable'    => 0,
    'visible_on_front' => 1,
    'visible_in_advanced_search'  => 1,
    'is_html_allowed_on_front' => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));


$setup->addAttribute('catalog_product', 'dimension_length', array(
    'group'         => 'General',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => ' 	 Dimension - Length',
    'backend'       => '',
	'user_defined'      => true,
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'searchable' => 0,
    'filterable' => 0,
    'comparable'    => 0,
    'visible_on_front' => 1,
    'visible_in_advanced_search'  => 1,
    'is_html_allowed_on_front' => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));


$setup->addAttribute('catalog_product', 'dimension_width', array(
    'group'         => 'General',
    'input'         => 'text',
    'type'          => 'text',
    'label'         => 'Dimension - Width',
    'backend'       => '',
	'user_defined'      => true,
    'visible'       => 1,
    'required'      => 0,
    'user_defined' => 1,
    'searchable' => 0,
    'filterable' => 0,
    'comparable'    => 0,
    'visible_on_front' => 1,
    'visible_in_advanced_search'  => 1,
    'is_html_allowed_on_front' => 0,
    'global'        => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
));



$installer->endSetup(); 