<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Images extends IWD_OrderManager_Block_Adminhtml_Sales_Order_Grid_Renderer_Abstract
{
    protected function Grid()
    {
        $orderId = $this->getOrderId();
        $order = Mage::getModel('sales/order')->load($orderId);
        $orderItemCollection = $order->getAllVisibleItems();
        $helper = Mage::helper('iwd_ordermanager/image');
        $count = 0;
        $cell = "<div class='iwd_om_prod_images hide'>";

        foreach ($orderItemCollection as $item) {
            try {
                $productId = $item->getProductId();
                $product = Mage::getModel('catalog/product')->load($productId);
                try {
                    $urlSmallImage = $helper->init($product, 'small_image')->resize(50);
                } catch (Exception $e) {
                    $urlSmallImage = Mage::getDesign()->getSkinUrl(Mage::helper('iwd_ordermanager/image')->getPlaceholder(), array('_area' => 'frontend'));
                }

                try {
                    $urlBigImage = $helper->init($product, 'image')->resize(200);
                } catch (Exception $e) {
                    $urlBigImage = Mage::getDesign()->getSkinUrl(Mage::helper('iwd_ordermanager/image')->getPlaceholder(), array('_area' => 'frontend'));
                }

                if ($count % 3 == 0) {
                    $class = ($count < 3) ? "show" : "";
                    $cell .= "<div class='iwd_om_image_row $class'>";
                }

                $cell .= '<span class="iwd_om_prod_image" data-big-image="' . $urlBigImage . '"><img src="' . $urlSmallImage . '"/></span>';
                if ($count % 3 == 2) {
                    $cell .= "</div>";
                }
                $count++;
            } catch (Exception $e) {
                IWD_OrderManager_Model_Logger::log($e->getMessage());
            }
        }

        $cell .= $count > 3 ? sprintf('</div><a class="iwd_order_grid_more show row-%s" href="javascript:void(0);" data-row-id="%s" title="%s"></a>',
            $orderId, $orderId, Mage::helper('iwd_ordermanager')->__('Show/hide'))
            : '</div>';

        return $cell;
    }

    protected function Export()
    {
        return "";
    }
}
