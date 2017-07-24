<?php

class IWD_OrderManager_Block_Adminhtml_Cataloginventory_Product_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('cataloginventoryStockGrid');
        $this->_blockGroup = 'iwd_ordermanager';
        $this->_controller = 'adminhtml_cataloginventory_product';

        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        $collection = Mage::getModel('catalog/product')->getCollection()
            ->addAttributeToSelect('sku')
            ->addAttributeToSelect('name')
            ->addAttributeToSelect('attribute_set_id')
            ->addAttributeToSelect('type_id');

        $stocks = Mage::getModel('cataloginventory/stock')->getCollection();
        foreach ($stocks as $stock) {
            $collection->joinField('qty'.$stock->getId(),
                'cataloginventory/stock_item',
                'qty',
                'product_id=entity_id',
                '{{table}}.stock_id='.$stock->getId(),
                'left');
            $collection->joinField('is_in_stock_'.$stock->getId(),
                'cataloginventory/stock_item',
                'is_in_stock',
                'product_id=entity_id',
                '{{table}}.stock_id='.$stock->getId(),
                'left');
        }

        $this->setCollection($collection);

        parent::_prepareCollection();
        $this->getCollection()->addWebsiteNamesToResult();
        return $this;
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('iwd_ordermanager');

        $this->addColumn('entity_id',
            array(
                'header'=> $helper->__('ID'),
                'width' => '50px',
                'type'  => 'number',
                'index' => 'entity_id',
            ));

        $this->addColumn('name',
            array(
                'header'=> $helper->__('Name'),
                'index' => 'name',
            ));

        $this->addColumn('type',
            array(
                'header'=> $helper->__('Type'),
                'width' => '150px',
                'index' => 'type_id',
                'type'  => 'options',
                'options' => Mage::getSingleton('catalog/product_type')->getOptionArray(),
            ));

        $sets = Mage::getResourceModel('eav/entity_attribute_set_collection')
            ->setEntityTypeFilter(Mage::getModel('catalog/product')->getResource()->getTypeId())
            ->load()
            ->toOptionHash();

        $this->addColumn('set_name',
            array(
                'header'=> $helper->__('Attrib. Set Name'),
                'width' => '100px',
                'index' => 'attribute_set_id',
                'type'  => 'options',
                'options' => $sets,
            ));

        $this->addColumn('sku',
            array(
                'header'=> $helper->__('SKU'),
                'width' => '80px',
                'index' => 'sku',
            ));

        $stocks = Mage::getModel('cataloginventory/stock')->getCollection();
        foreach ($stocks as $stock) {
            $id = $stock->getId();
            $this->addColumn('qty' . $id, array(
                'header' => $stock->getStockName(),
                'align' => 'right',
                'width' => '50px',
                'index' => 'qty' . $id,
                'filter_index' => 'qty' . $id,
                'type' => 'number',
                'editable' => true,
                'sortable' => true,
                'renderer'=>'IWD_OrderManager_Block_Adminhtml_Cataloginventory_Product_Grid_Renderer_Qty'
            ));
        }

        return parent::_prepareColumns();
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/catalog_product/edit', array(
                'store'=>$this->getRequest()->getParam('store'),
                'id'=>$row->getId())
        );
    }
}