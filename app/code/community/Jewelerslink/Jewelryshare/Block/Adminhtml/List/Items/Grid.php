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
 * TheJewelerslink jewelryshare product grid container
 *
 * @category    Jewelerslink
 * @package     Jewelerslink_Jewelryshare
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Jewelerslink_Jewelryshare_Block_Adminhtml_List_Items_Grid  extends Mage_Adminhtml_Block_Widget_Grid
{
    /**
     * Initialize grid settings
     *
     */
    protected function _construct()
    {
        parent::_construct();

        $this->setId('jewelryshare_list_items');
        $this->setDefaultSort('id');
        $this->setUseAjax(true);
    }

    /**
     * Return Current work store
     *
     * @return Mage_Core_Model_Store
     */
    protected function _getStore()
    {
        return Mage::app()->getStore();
    }

    /**
     * Prepare product collection
     *
     * @return Jewelerslink_Jewelryshare_Block_Adminhtml_List_Items_Grid
     */
    protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->setStore($this->_getStore())
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('price')
            ->addAttributeToSelect('attribute_set_id')
            ->addAttributeToSelect('jewelry_imported');
        $this->setCollection($collection);

        return parent::_prepareCollection();
    }

    /**
     * Prepare grid columns
     *
     * @return Jewelerslink_Jewelryshare_Block_Adminhtml_List_Items_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('id', array(
            'header'            => Mage::helper('jewelryshare')->__('ID'),
            'sortable'          => true,
            'width'             => '60px',
            'index'             => 'entity_id'
        ));

        $this->addColumn('name', array(
            'header'            => Mage::helper('jewelryshare')->__('Product Name'),
            'index'             => 'name',
            'column_css_class'  => 'name'
        ));

        $this->addColumn('type', array(
            'header'            => Mage::helper('jewelryshare')->__('Type'),
            'width'             => '60px',
            'index'             => 'type_id',
            'type'              => 'options',
            'options'           => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));

        $entityTypeId =  Mage::helper('jewelryshare')->getProductEntityType();
        $sets           = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->setEntityTypeFilter($entityTypeId)
            ->load()
            ->toOptionHash();

        $this->addColumn('set_name', array(
            'header'            => Mage::helper('jewelryshare')->__('Attrib. Set Name'),
            'width'             => '100px',
            'index'             => 'attribute_set_id',
            'type'              => 'options',
            'options'           => $sets,
        ));

        $this->addColumn('sku', array(
            'header'            => Mage::helper('jewelryshare')->__('SKU'),
            'width'             => '80px',
            'index'             => 'sku',
            'column_css_class'  => 'sku'
        ));

        $this->addColumn('price', array(
            'header'            => Mage::helper('jewelryshare')->__('Price'),
            'align'             => 'center',
            'type'              => 'currency',
            'currency_code'     => $this->_getStore()->getCurrentCurrencyCode(),
            'rate'              => $this->_getStore()->getBaseCurrency()->getRate($this->_getStore()->getCurrentCurrencyCode()),
            'index'             => 'price'
        ));

        $source = Mage::getModel('eav/entity_attribute_source_boolean');
        $isImportedOptions = $source->getOptionArray();

        $this->addColumn('jewelry_imported', array(
            'header'    => Mage::helper('jewelryshare')->__('Publish In Jewelerslink'),
            'width'     => '100px',
            'index'     => 'jewelry_imported',
            'type'      => 'options',
            'options'   => $isImportedOptions
        ));

        return parent::_prepareColumns();
    }

    /**
     * Prepare massaction
     *
     * @return Jewelerslink_Jewelryshare_Block_Adminhtml_List_Items_Grid
     */
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('item_id');

        $this->getMassactionBlock()->addItem('enable', array(
            'label'         => Mage::helper('jewelryshare')->__('Publish to Jewelerslink'),
            'url'           => $this->getUrl('adminhtml/jewelryshare_items_grid/massEnable'),
         	//'selected'      => true,
        ));
        $this->getMassactionBlock()->addItem('disable', array(
            'label'         => Mage::helper('jewelryshare')->__("Don't publish to Jewelerslink"),
            'url'           => $this->getUrl('adminhtml/jewelryshare_items_grid/massDisable'),
        ));
        
        $this->getMassactionBlock()->addItem('jw_export', array(
        		'label'         => Mage::helper('jewelryshare')->__('Export published products to Jewelerslink'),
        		'url'           => $this->getUrl('adminhtml/jewelryshare_items_grid/massJwExport'),
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
