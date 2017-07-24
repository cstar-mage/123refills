<?php
/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category    
 * @package     _storage
 * @copyright   Copyright (c) 2011 Magento Inc. (http://www.magentocommerce.com)
 * @license     http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */


/**
 * TheJewelerslink jewelryshare attribute map Grid
 *
 * @category    Jewelerslink
 * @package     Jewelerslink_Jewelryshare
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Jewelerslink_Jewelryshare_Block_Adminhtml_List_Codes_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Initialize grid settings
     *
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setId('jewelryshare_list_codes');
        $this->setUseAjax(true);
    }

    /**
     * Prepare codes collection
     *
     * @return Jewelerslink_Jewelryshare_Block_Adminhtml_List_Codes_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getResourceModel('jewelerslink_jewelryshare/codes_collection')->setOrder('import_code', 'ASC');
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    /**
     * Configuration of grid
     *
     * @return $this
     */
    protected function _prepareColumns()
    {
        $this->addColumn('import_code', array(
            'header'=> Mage::helper('jewelryshare')->__('JewelersLink Code'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'import_code'
        ));

        $this->addColumn('eav_code', array(
            'header'=> Mage::helper('jewelryshare')->__('Site attribute code'),
            'width' => '80px',
            'type'  => 'text',
            'index' => 'eav_code'
        ));

        $source = Mage::getModel('eav/entity_attribute_source_boolean');
        $isImportedOptions = $source->getOptionArray();

        $this->addColumn('jewelry_imported', array(
            'header' => Mage::helper('jewelryshare')->__('Publish In Jewelerslink'),
            'width' => '100px',
            'index' => 'jewelry_imported',
            'type'  => 'options',
            'options' => $isImportedOptions
        ));
        
        $this->addColumn('use_in_update', array(
        		'header' => Mage::helper('jewelryshare')->__('Use In Update Product'),
        		'width' => '100px',
        		'index' => 'use_in_update',
        		'type'  => 'options',
        		'options' => $isImportedOptions
        ));
        
        $this->addColumn('action',
        		array(
        				'header'    => Mage::helper('jewelryshare')->__('Action'),
        				'width'     => '50px',
        				'type'      => 'action',
        				'getter'     => 'getId',
        				'actions'   => array(
        						array(
        							'caption' => Mage::helper('jewelryshare')->__('Edit'),
        							'url'       => array('base'=> '*/*/editForm'),
        							'onclick' => 'openNewImportWindow(this.href);return false;',
        							'field'   => 'code_id'
        						)
        				),
        				'filter'    => false,
        				'sortable'  => false,
        				'index'     => 'code_id',
        ));
        return parent::_prepareColumns();
    }
    
    /**
     * Prepare massaction
     *
     * @return $this
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('code_id');
        $this->getMassactionBlock()->setFormFieldName('code_id');

        $this->getMassactionBlock()->addItem('assign_jewelry_imported', array(
        		'label'         => Mage::helper('jewelryshare')->__('Assign Publish In Jewelerslink'),
        		'url'           => $this->getUrl('adminhtml/jewelryshare_codes_grid/massPublishInJewelerslink'),
        		'additional'   => array(
        				'visibility'    => array(
        						'name'     => 'jewelry_imported',
        						'type'     => 'select',
        						'class'    => 'required-entry',
        						'label'    => Mage::helper('jewelryshare')->__('Publish In Jewelerslink'),
        						'values'   => array('' => '', '1' => 'Yes','0'=> 'No')
        				)
        		)
        ));
        
        $this->getMassactionBlock()->addItem('assign_use_in_update', array(
            'label'         => Mage::helper('jewelryshare')->__('Assign Use In Update'),
            'url'           => $this->getUrl('*/adminhtml_jewelryshare_codes_grid/massUseInUpdate'),
       		'additional'   => array(
       				'visibility'    => array(
       						'name'     => 'use_in_update',
       						'type'     => 'select',
       						'class'    => 'required-entry',
       						'label'    => Mage::helper('jewelryshare')->__('Use In Update Product'),
       						'values'   => array('' => '', '1' => 'Yes','0'=> 'No')
       				)
       		)
        ));
        
        $this->getMassactionBlock()->addItem('delete', array(
            'label'         => Mage::helper('jewelryshare')->__('Delete'),
            'url'           => $this->getUrl('*/jewelryshare_codes_grid/delete'),
        ));

        return $this;
    }

    /**
     * Return Grid URL for AJAX query
     *
     * @return string
     */
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }
}
