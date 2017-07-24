<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_GoToCustomer extends IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Abstract
{
    protected function Grid()
    {
        if (isset($this->row['customer_id']) && !empty($this->row['customer_id'])) {
            $url = Mage::helper('adminhtml')->getUrl('adminhtml/customer/edit', array('id' => $this->row['customer_id']));
            return '<a href="' . $url . '" target="_blank">' . $this->_getValue($this->row) . '</a>';
        }

        return $this->_getValue($this->row);
    }

    protected function Export()
    {
        return $this->_getValue($this->row);
    }
}
