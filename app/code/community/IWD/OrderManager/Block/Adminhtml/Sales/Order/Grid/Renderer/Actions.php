<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Actions extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row)
    {
        if (Mage::helper('iwd_ordermanager')->isGridExport()) {
            return "";
        }

        $orderId = $row['entity_id'];
        return $this->Grid($orderId);
    }

    private function Grid($orderId)
    {
        $viewUrl = $this->getUrl('*/sales_order/view', array('order_id' => $orderId));
        $helper = Mage::helper('core');

        return '<div class="ordered_items action_cell">' .
        '<a class="action_icon action_view_ordered_items" href="javascript:void(0);" title="' . $helper->__('Ordered items') . '" id="ordered_items_' . $orderId . '"><i class="fa fa-file-text-o" aria-hidden="true"></i></a>' .
        '<a class="action_icon action_view_product_items" href="javascript:void(0);" title="' . $helper->__('More about products') . '" id="product_items_' . $orderId . '"><i class="fa fa-shopping-cart" aria-hidden="true"></i></a>' .
        '<a class="action_icon action_view_order" href="' . $viewUrl . '" title="' . $helper->__('View order') . '"><i class="fa fa-search" aria-hidden="true"></i></a>' .
        '</div>';
    }
}
