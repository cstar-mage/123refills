<?php

$installer = $this;

$installer->startSetup();

$setup = new Mage_Eav_Model_Entity_Setup('core_setup');

$setup->addAttribute('catalog_category', 'img_alt', array(
						'group'             => 'General Information',
                        'type'              => 'varchar',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Image Alt',
                        'input'             => 'text',
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

$setup->addAttribute('catalog_category', 'thumbnail_alt', array(
						'group'             => 'General Information',
                        'type'              => 'varchar',
                        'backend'           => '',
                        'frontend'          => '',
                        'label'             => 'Thumbnail Image Alt',
                        'input'             => 'text',
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

$installer->endSetup(); 