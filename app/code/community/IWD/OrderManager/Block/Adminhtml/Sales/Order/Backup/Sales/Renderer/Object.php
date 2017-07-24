<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Backup_Sales_Renderer_Object extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    private $result = "";

    public function render(Varien_Object $row)
    {
        $deletedObject = unserialize($row['object']);

        $this->result = "";

        if (isset($deletedObject['increment_id'])) {
            $this->result .= '<b>#' . $deletedObject['increment_id'] . ' (id ' . $deletedObject['entity_id'] . ') </b>';
        }
        if (isset($deletedObject['status'])) {
            $this->result .= '[' . $deletedObject['status'] . ']';
        }
        if (isset($deletedObject['order_id'])) {
            $this->result .= '<br>OrderID: ' . $deletedObject['order_id'] . '';
        }
        if (isset($deletedObject['customer_email'])) {
            $this->result .= '<br><b>' . Mage::helper('core')->__('User Login') . ': ' . $deletedObject['customer_email'] . '</b>';
        }

        $this->_arrPriceRowToDescription('Subtotal', $deletedObject, 'subtotal');
        $this->_arrPriceRowToDescription('Shipping Amount', $deletedObject, 'shipping_amount');
        $this->_arrPriceRowToDescription('Discount Amount', $deletedObject, 'discount_amount');
        $this->_arrPriceRowToDescription('Tax Amount', $deletedObject, 'tax_amount');
        $this->_arrPriceRowToDescription('Grand Total', $deletedObject, 'grand_total');
        $this->_arrPriceRowToDescription('Total Paid', $deletedObject, 'total_paid');
        $this->_arrPriceRowToDescription('Total Refunded', $deletedObject, 'total_refunded');
        $this->_arrPriceRowToDescription('Total Due', $deletedObject, 'total_due');

        return $this->result;
    }

    protected function _arrPriceRowToDescription($param, $val, $index)
    {
        if (isset($val[$index])) {
            $this->result .= '<br>' . Mage::helper('core')->__($param) . ': ' . '<span class="price">'
                . Mage::helper('core')->currency($val[$index], true, false) . '</span>';
        }
    }
}
