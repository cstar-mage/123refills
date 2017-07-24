<?php

class IWD_OrderManager_Block_Adminhtml_Cataloginventory_Product_Grid_Renderer_Qty extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    protected $row;

    public function render(Varien_Object $row)
    {
        $this->row = $row;

        $export = Mage::helper('iwd_ordermanager')->isGridExport();
        if ($export) {
            return parent::render($row);
        }

        $productId = $row->getData('entity_id');
        $stockId = str_replace("qty", '', $this->getColumn()->getIndex());
        $qty = $this->_getValue($row) * 1;

        $isInStock = $row->getData('is_in_stock_'.$stockId) ? 'checked="checked"' : '';

        $class = Mage_CatalogInventory_Model_Stock::DEFAULT_STOCK_ID == $stockId ? 'inventory_qty_default' : 'inventory_qty';
        $id = Mage_CatalogInventory_Model_Stock::DEFAULT_STOCK_ID == $stockId ? 'id="inventory_qty_default_' . $productId . '"' : '';

        $element = sprintf("<input title='Is in stock?' type='checkbox' %s value='1' class='is-in-stock' name='stock[%s][%s][is_in_stock]'/>", $isInStock, $productId, $stockId);
        if ($row->getData('type_id') != 'configurable') {
            $element .= sprintf("<input type='text' class='input-text %s' %s name='stock[%s][%s][qty]' value='%s' data-product-id='%s' title='Qty'>", $class, $id, $productId, $stockId, $qty, $productId);
        }
        return $element;
    }
}