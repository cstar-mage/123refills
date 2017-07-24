<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Flags extends IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Abstract
{
    protected function Export()
    {
        $this->_getValue($this->row);
    }

    protected function Grid()
    {
        $flagType = str_replace('iwd_om_flags_', '', $this->getColumn()->getIndex());
        $flagId = $this->_getValue($this->row);
        $orderId = $this->row->getData('entity_id');
        $orderIncrementId = $this->row->getData('increment_id');

        $flag = Mage::getModel('iwd_ordermanager/flags_flags')->load($flagId);
        $html = $flag->getIconHtmlWithHint();

        return sprintf(
            '<a class="iwd-om-flag-cell" href="javascript:void(0);" title="" data-order-id="%s" data-order-increment-id="%s" data-flag-type="%s">%s</a>',
            $orderId,
            $orderIncrementId,
            $flagType,
            $html
        );
    }
}
