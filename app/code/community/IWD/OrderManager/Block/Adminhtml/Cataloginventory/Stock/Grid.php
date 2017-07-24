<?php

class IWD_OrderManager_Block_Adminhtml_Cataloginventory_Stock_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('cataloginventoryStockGrid');
        $this->_blockGroup = 'iwd_ordermanager';
        $this->_controller = 'adminhtml_cataloginventory_stock';

        $this->setDefaultSort('id');
        $this->setDefaultDir('DESC');
        $this->setUseAjax(true);
    }

    protected function _prepareCollection()
    {
        if (Mage::helper('iwd_ordermanager')->isMultiInventoryEnable()) {
            $collection = Mage::getModel('cataloginventory/stock')->getCollection()
                ->addFieldToFilter('stock_id', array('neq' => 1));

            $this->setCollection($collection);
        }

        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {
        $helper = Mage::helper('iwd_ordermanager');

        $this->addColumn('stock_id', array(
            'header' => $helper->__('ID'),
            'align' => 'right',
            'width' => '50px',
            'index' => 'stock_id',
            'filter_index' => 'stock_id',
            'type' => 'number',
            'sortable' => true
        ));

        $this->addColumn('stock_name', array(
            'header' => $helper->__('Source'),
            'align' => 'left',
            'index' => 'stock_name',
            'type' => 'text',
            'filter_index' => 'stock_name',
            'sortable' => true
        ));

        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $helper = Mage::helper('iwd_ordermanager');

        $this->setMassactionIdField('stock_id');
        $this->getMassactionBlock()->setFormFieldName('stock');

        $this->getMassactionBlock()->addItem('delete', array(
            'label' => $helper->__('Delete Stock'),
            'url' => $this->getUrl('*/*/massDelete'),
            'confirm' => $helper->__('Are you sure?')
        ));

        return $this;
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('stock_id' => $row->getId()));
    }

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current' => true));
    }
}