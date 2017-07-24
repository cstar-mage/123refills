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
            ->addAttributeToSelect('gender')
            ->addAttributeToSelect('product_type')
            ->addAttributeToSelect('primary_stone')
            ->addAttributeToSelect('manufacturer')
            //->addAttributeToSelect('description')
			->addAttributeToSelect('thumbnail')
            ->addStoreFilter($this->getRequest()->getParam('store'))
            ->joinField('position',
                'catalog/category_product',
                'position',
                'product_id=entity_id',
                'category_id='.(int) $this->getRequest()->getParam('id', 0),
                'left');
        
        $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
        
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

		$this->addColumn('thumbnail', array(
				'header'    => Mage::helper('catalog')->__('Thumbnail'),
				'width'     => '150px',
				'type'      => 'image',
				'index'     => 'thumbnail',
				'renderer' => 'Mage_Adminhtml_Block_Catalog_Category_Tab_Renderer_Productimage'
		
		));
		
        $this->addColumn('name', array(
            'header'    => Mage::helper('catalog')->__('Name'),
            'index'     => 'name',
        	'width'     => '200px',
        ));
        
        /* $this->addColumn('description', array(
        		'header'    => Mage::helper('catalog')->__('Description'),
        		'index'     => 'description',
        		'type'      => 'text'
        )); */

        $this->addColumn('sku', array(
            'header'    => Mage::helper('catalog')->__('SKU'),
            'width'     => '80px',
            'index'     => 'sku'
        ));
        
        $this->addColumn('product_type', array(
        		'header'    => Mage::helper('catalog')->__('Product Type'),
        		'index'     => 'product_type',
        		'width'     => '100px',
        		'type'      =>  'options',
        		'options' => $this->_getAttributeOptions('product_type'),
        ));
        
        $this->addColumn('price', array(
            'header'    => Mage::helper('catalog')->__('Price'),
            'type'  => 'currency',
            'width'     => '1',
            'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
            'index'     => 'price'
        ));
        
        $this->addColumn('primary_stone', array(
        		'header'    => Mage::helper('catalog')->__('Primary Stone'),
        		'index'     => 'primary_stone',
        		'width'     => '100px',
        		'type'      =>  'options',
        		'options' => $this->_getAttributeOptions('primary_stone'),
        ));
        
        $this->addColumn('manufacturer', array(
        		'header'    => Mage::helper('catalog')->__('Manufacturer'),
        		'index'     => 'manufacturer',
        		'width'     => '100px',
        		'type'      =>  'options',
        		'options' => $this->_getAttributeOptions('manufacturer'),
        ));
        
        $this->addColumn('status', array(
        		'header'    => Mage::helper('catalog')->__('Status'),
        		'index'     => 'status',
        		'width'     => '100px',
        		'type'      =>  'options',
        		'options' 	=> array(0=>'Disabled',1=>'Enabled'),
        ));
        
        $this->addColumn('gender', array(
        		'header'    => Mage::helper('catalog')->__('Gender'),
        		'index'     => 'gender',
        		'width'     => '100px',
        		'type'      =>  'options',
        		'options' => $this->_getAttributeOptions('gender'),
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

    protected function _getAttributeOptions($arg_attribute)
    {
    	//$attribute = Mage::getModel('eav/config')->getAttribute('catalog_product', $attribute_code);
    	//$options = array();
    
    	$attribute_model        = Mage::getModel('eav/entity_attribute');
    	$attribute_options_model= Mage::getModel('eav/entity_attribute_source_table') ;
    	$attribute_code         = $attribute_model->getIdByCode('catalog_product', $arg_attribute);
    	$attribute              = $attribute_model->load($attribute_code);
    
    	$attribute_table        = $attribute_options_model->setAttribute($attribute);
    	$options                = $attribute_options_model->getAllOptions(false);
    	$arg_options = array();
    
    	foreach( $options as $option ) {
    		$arg_options[$option['value']] = $option['label'];
    	}
    
    	return $arg_options;
    }
    
}

