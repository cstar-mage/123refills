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
 * @category   Mage
 * @package    Mage_Adminhtml
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Product in category grid
 *
 * @category   Mage
 * @package    Mage_Adminhtml
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Mage_Adminhtml_Block_Catalog_Category_Tab_Product extends Mage_Adminhtml_Block_Widget_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('catalog_category_products');
        $this->setDefaultSort('entity_id');
        $this->setUseAjax(true);
    }

    public function getCategory()
    {
        return Mage::registry('category');
    }

    protected function _addColumnFilterToCollection($column)
    {
        // Set custom filter for in category flag
        if ($column->getId() == 'in_category') {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            if ($column->getFilter()->getValue()) {
                $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$productIds));
            }
            elseif(!empty($productIds)) {
                $this->getCollection()->addFieldToFilter('entity_id', array('nin'=>$productIds));
            }
        }
        else {
            parent::_addColumnFilterToCollection($column);
        }
        return $this;
    }

    protected function _prepareCollection()
    {
        if ($this->getCategory()->getId()) {
            $this->setDefaultFilter(array('in_category'=>1));
        }
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('price')
			->addAttributeToSelect('thumbnail')
			->addAttributeToSelect('manufacturer')
			->addAttributeToSelect('product_type')
			->addAttributeToSelect('primary_stone')
			->addAttributeToSelect('status')
            ->addStoreFilter($this->getRequest()->getParam('store'))
            ->joinField('position',
                'catalog/category_product',
                'position',
                'product_id=entity_id',
                'category_id='.(int) $this->getRequest()->getParam('id', 0),
                'left');
        $this->setCollection($collection);

        if ($this->getCategory()->getProductsReadonly()) {
            $productIds = $this->_getSelectedProducts();
            if (empty($productIds)) {
                $productIds = 0;
            }
            $this->getCollection()->addFieldToFilter('entity_id', array('in'=>$productIds));
        }

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
    	
    	$this->addColumn('thumbnail', array(
    			'header'    => Mage::helper('catalog')->__('Thumbnail'),
    			'width'     => '150',
    			'type'      => 'image',
    			'index'     => 'thumbnail',
    			'filter'    => false,
    			'renderer' => 'Mage_Adminhtml_Block_Catalog_Category_Tab_Renderer_Image'
    	
    	));
    	
        if (!$this->getCategory()->getProductsReadonly()) {
            $this->addColumn('in_category', array(
                'header_css_class' => 'a-center',
                'type'      => 'checkbox',
                'name'      => 'in_category',
                'values'    => $this->_getSelectedProducts(),
                'align'     => 'center',
                'index'     => 'entity_id'
            ));
        }
        $this->addColumn('entity_id', array(
            'header'    => Mage::helper('catalog')->__('ID'),
            'sortable'  => true,
            'width'     => '60',
            'index'     => 'entity_id'
        ));
		
        $this->addColumn('name', array(
            'header'    => Mage::helper('catalog')->__('Name'),
            'index'     => 'name'
        ));
        $this->addColumn('sku', array(
            'header'    => Mage::helper('catalog')->__('SKU'),
            'width'     => '80',
            'index'     => 'sku'
        ));
        $this->addColumn('price', array(
            'header'    => Mage::helper('catalog')->__('Price'),
            'type'  => 'currency',
            'width'     => '1',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index'     => 'price'
        ));
        
        $manufacturer_options = $this->_getAttributeOptions('manufacturer');
        $this->addColumn('manufacturer', array(
        		'header'    => Mage::helper('catalog')->__('Vendor'),
        		'width'     => '100px',
        		'type'  => 'options',
        		'index'     => 'manufacturer',
        		'options' => $manufacturer_options
        ));
        
        $product_type_options = $this->_getAttributeOptions('product_type');
        $this->addColumn('product_type', array(
        		'header'    => Mage::helper('catalog')->__('Product Type'),
        		'width'     => '100px',
        		'type'  => 'options',
        		'index'     => 'product_type',
        		'options' => $product_type_options
        ));
        
        $this->addColumn('status', array(
        		'header'    => Mage::helper('catalog')->__('Status'),
        		'width'     => '80',
        		'index'     => 'status',
        		'type'      =>  'options',
        		'options' => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));
        
        $primary_stone_options = $this->_getAttributeOptions('primary_stone');
        $this->addColumn('primary_stone', array(
        		'header'    => Mage::helper('catalog')->__('Primary Stone'),
        		'width'     => '100px',
        		'type'  => 'options',
        		'index'     => 'primary_stone',
        		'options' => $primary_stone_options
        ));
                
        $this->addColumn('position', array(
            'header'    => Mage::helper('catalog')->__('Position'),
            'width'     => '1',
            'type'      => 'number',
            'index'     => 'position',
            'editable'  => !$this->getCategory()->getProductsReadonly()
            //'renderer'  => 'adminhtml/widget_grid_column_renderer_input'
        ));

        return parent::_prepareColumns();
    }

    public function _getAttributeOptions($attribute_code) {
        
    	$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $attribute_code);
        $options = array();
        foreach( $attribute->getSource()->getAllOptions(true, true) as $option ) {
        	if(!$option['value']) {
        		continue;
        	}
        	$options[$option['value']] = $option['label'];
        }
    	return $options;
    }
    
    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    protected function _getSelectedProducts()
    {
        $products = $this->getRequest()->getPost('selected_products');
        if (is_null($products)) {
            $products = $this->getCategory()->getProductsPosition();
            return array_keys($products);
        }
        return $products;
    }
    
    /*protected function _filterNewstyleCondition($collection, $column)
    {
    	if (!$value = $column->getFilter()->getValue()) {
    		return;
    	}
    	$this->getCollection()->addFieldToFilter('thumbnail', array('finset' => $value));
    }*/

}

