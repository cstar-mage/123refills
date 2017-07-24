<?php 
class Ideal_Dataspin_Block_Adminhtml_Dataspin_Edit_Tab_Products extends Mage_Adminhtml_Block_Widget_Grid
{
	  public function __construct()
	  {
	      parent::__construct();
	      $this->setId('dataspin_products');
	      $this->setDefaultSort('entity_id');
	      $this->setDefaultDir('DESC');
	      $this->setUseAjax(true);
	      $this->setSaveParametersInSession(true);
		
	  }
	
	  protected function _getStore()
	  {
	  	$storeId = (int) $this->getRequest()->getParam('store', 0);
	  	return Mage::app()->getStore($storeId);
	  }
	  
	  protected function _prepareCollection()
	  {
	    $store = $this->_getStore();
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('dataspin_applied')
            ->addAttributeToSelect('attribute_set_id')
            ->addAttributeToSelect('type_id');

        if (Mage::helper('catalog')->isModuleEnabled('Mage_CatalogInventory')) {
            $collection->joinField('qty',
                'cataloginventory/stock_item',
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id=1',
                'left');
        }
        if ($store->getId()) {
            //$collection->setStoreId($store->getId());
            $adminStore = Mage_Core_Model_App::ADMIN_STORE_ID;
            $collection->addStoreFilter($store);
            $collection->joinAttribute(
                'name',
                'catalog_product/name',
                'entity_id',
                null,
                'inner',
                $adminStore
            );
            $collection->joinAttribute(
                'custom_name',
                'catalog_product/name',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'status',
                'catalog_product/status',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'visibility',
                'catalog_product/visibility',
                'entity_id',
                null,
                'inner',
                $store->getId()
            );
            $collection->joinAttribute(
                'price',
                'catalog_product/price',
                'entity_id',
                null,
                'left',
                $store->getId()
            );
        }
        else {
            $collection->addAttributeToSelect('price');
            $collection->joinAttribute('status', 'catalog_product/status', 'entity_id', null, 'inner');
            $collection->joinAttribute('visibility', 'catalog_product/visibility', 'entity_id', null, 'inner');
        }

        $this->setCollection($collection);

        parent::_prepareCollection();
        $this->getCollection()->addWebsiteNamesToResult();
        return $this;
	  }
	
	 protected function _prepareMassaction()
     {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('dataspin_products[]');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('catalog')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('catalog')->__('Are you sure?')
        ));

         
        return $this;
    }	

	  protected function _prepareColumns()
	  {
  	
  		/*
	  	$this->addColumn('in_products', array(
	  			'header_css_class' => 'a-center',
	  			'type'      => 'checkbox',
	  			'name'      => 'in_products',
	  			'values'    => $this->_getSelectedProducts(),
	  			'align'     => 'center',
	  			'index'     => 'entity_id'
	  	)); */
  	
	  	$this->addColumn('entity_id', array(
            'header'    => Mage::helper('catalog')->__('ID'),
            'sortable'  => true,
            'width'     => 60,
            'index'     => 'entity_id'
        )); 
	  	
	  	$this->addColumn('dataspin_applied',array(
	  			'header'=> Mage::helper('catalog')->__('Data Spin Applied?'),
	  			'width' => '50px',
	  			'align' => 'right',
	  			'index' => 'dataspin_applied',
	  			'type'=> 	'options',
	  			'options' => Mage::getSingleton('adminhtml/system_config_source_yesno')->toArray(),
	  	));
	  	
	  	$this->addColumn('sku', array(
	  			'header'    => Mage::helper('catalog')->__('SKU'),
	  			'width'     => 80,
	  			'index'     => 'sku'
	  	));
	  	
	  	$this->addColumn('product_name', array(
	  			'header'    => Mage::helper('catalog')->__('Name'),
	  			'index'     => 'name'
	  	));
	  	
	  	$this->addColumn('price', array(
	  			'header'        => Mage::helper('catalog')->__('Price'),
	  			'type'          => 'currency',
	  			'currency_code' => (string) Mage::getStoreConfig(Mage_Directory_Model_Currency::XML_PATH_CURRENCY_BASE),
	  			'index'         => 'price'
	  	));
	  	
        $this->addColumn('type', array(
            'header'    => Mage::helper('catalog')->__('Type'),
            'width'     => 100,
            'index'     => 'type_id',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_type')->getOptionArray(),
        ));

        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
            ->load()
            ->toOptionHash();

        $this->addColumn('set_name', array(
            'header'    => Mage::helper('catalog')->__('Attrib. Set Name'),
            'width'     => 130,
            'index'     => 'attribute_set_id',
            'type'      => 'options',
            'options'   => $sets,
        ));

        $this->addColumn('status', array(
            'header'    => Mage::helper('catalog')->__('Status'),
            'width'     => 90,
            'index'     => 'status',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_status')->getOptionArray(),
        ));

        $this->addColumn('visibility', array(
            'header'    => Mage::helper('catalog')->__('Visibility'),
            'width'     => 90,
            'index'     => 'visibility',
            'type'      => 'options',
            'options'   => Mage::getSingleton('catalog/product_visibility')->getOptionArray(),
        ));

        
        
      //$this->addExportType('*/*/exportCsvDiamondscore', Mage::helper('dataspin')->__('CSV'));	
      //$this->addExportType('*/*/exportXmlDiamondscore', Mage::helper('dataspin')->__('XML'));
	  
      return parent::_prepareColumns();
  	}
	
	/*
	protected function _getSelectedProducts()
	{
		$products = $this->getInProducts();
		if (!is_array($products)) {
		    $products = array_keys($this->getSelectedProducts());
		}
		return $products;
	}
	
	
	  public function getSelectedProducts() 
	  {
		$products = array();
		if(Mage::registry('dataspin_data')) {
			$selected = Mage::registry('dataspin_data')->getSelectedProducts();
		}
		if (!is_array($selected)){
		    $selected = array();
		}
		foreach ($selected as $product) {
		    $products[$product->getId()] = array('position' => $product->getPosition());
		}
		return $products;
	  }
	 
         */
	
	  //public function getRowUrl($row)
	  //{
	  //    return false;//$this->getUrl('*/*/edit', array('id' => $row->getId()));
	  //}
	  public function getRowUrl() {
		return '#';
	  }
    
	  public function getGridUrl() {
		return $this->getUrl('*/*/productgrid', array('_current' => true));
	  }
	
	 
	

}