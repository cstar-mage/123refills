<?php

/**
 *
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Resource_Setup
    extends Mage_Catalog_Model_Resource_Eav_Mysql4_Setup
{

    private $_categoryAttributes
        = array(
            'dynamic_attributes'        => array(
                'label'                   => 'dynamic_attributes',
                'type'                    => 'text',
                'source'                  => '',
                'default'                 => '',
                'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                'visible'                 => false,
                'required'                => false,
                'user_defined'            => false,
                'visible_on_front'        => true,
                'used_in_product_listing' => true,
            ),
            'parent_dynamic_attributes' => array(
                'label'                   => 'parent_dynamic_attributes',
                'type'                    => 'text',
                'source'                  => '',
                'default'                 => '',
                'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                'visible'                 => false,
                'required'                => false,
                'user_defined'            => false,
                'visible_on_front'        => true,
                'used_in_product_listing' => true,
            ),
            'ignore_parent_dynamic'     => array(
                'label'                   => 'Ignore Parent Dynamic Rules',
                'type'                    => 'int',
                'source'                  => 'eav/entity_attribute_source_boolean',
                'default'                 => '0',
                'input'                   => 'select',
                'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                'visible'                 => true,
                'required'                => false,
                'user_defined'            => false,
                'visible_on_front'        => false,
                'used_in_product_listing' => false,
            ),
            'dynamic_rebuild_datetime'     => array(
                'label'                   => 'Last Dynamic Rebuild Date and Time',
                'type'                    => 'datetime',
                'source'                  => '',
                'default'                 => '',
                'input'                   => 'date',
                'global'                  => Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_STORE,
                'visible'                 => false,
                'required'                => false,
                'user_defined'            => false,
                'visible_on_front'        => false,
                'used_in_product_listing' => false,
            ),
        );

    /**
     * Create Product attributes for select list
     *
     * @param string $attribute_code
     * @param array  $optionsArray
     *
     *
     *
     * $installer->addAttribute('catalog_product', 'in_store_only', array(
     * 'group'             => 'General',
     * 'type'              => 'int',
     * 'backend'           => '',
     * 'frontend'          => '',
     * 'label'             => 'In Store Only',
     * 'note'              => '',
     * 'input'             => 'select',
     * 'class'             => '',
     * 'source'            => 'eav/entity_attribute_source_boolean',
     * 'global'            =>
     * Mage_Catalog_Model_Resource_Eav_Attribute::SCOPE_GLOBAL,
     * 'visible'           => true,
     * 'required'          => false,
     * 'user_defined'      => false,
     * 'default'           => '0',
     * 'searchable'        => true,
     * 'filterable'        => true,
     * 'comparable'        => false,
     * 'visible_on_front'  => true,
     * 'unique'            => false,
     * 'apply_to'          => 'simple,virtual,configurable,bundle',
     * 'is_configurable'   => false,
     * ));
     */
    public function addAttributeOptions($attributeCode, array $optionsArray)
    {
        $tableOptions = $this->getTable('eav_attribute_option');
        $tableOptionValues = $this->getTable('eav_attribute_option_value');
        $attributeId = (int)$this->getAttribute(
            'catalog_product', $attributeCode, 'attribute_id'
        );
        foreach ($optionsArray as $sortOrder => $label) {
            // add option
            $data = array(
                'attribute_id' => $attributeId,
                'sort_order'   => $sortOrder,
            );
            $this->getConnection()->insert($tableOptions, $data);

            // add option label
            $optionId = (int)$this->getConnection()->lastInsertId(
                $tableOptions, 'option_id'
            );
            $data = array(
                'option_id' => $optionId,
                'store_id'  => 0,
                'value'     => $label,
            );
            $this->getConnection()->insert($tableOptionValues, $data);
        }
    }

    public function getDefaultEntities()
    {
        $entities = array();

        $defaultAttributeOptions = array(
            'group'    => 'General Information',
            'required' => false,
        );

        /* Build Catalog Attributes */
        $entities['catalog_category'] = array(
            'entity_model'                => 'catalog/category',
            'attribute_model'             => 'catalog/resource_eav_attribute',
            'table'                       => 'catalog/category',
            'additional_attribute_table'  => 'catalog/eav_attribute',
            'entity_attribute_collection' => 'catalog/category_attribute_collection',
            'attributes'                  => array(),
        );
        foreach ($this->_categoryAttributes as $name => $options) {
            /* Override values provided by the defaults */
            $attributeOptions = $defaultAttributeOptions;
            foreach ($options as $k => $v) {
                $attributeOptions[$k] = $v;
            }
            $entities['catalog_category']['attributes'][$name]
                = $attributeOptions;
        }

        return $entities;
    }

}
