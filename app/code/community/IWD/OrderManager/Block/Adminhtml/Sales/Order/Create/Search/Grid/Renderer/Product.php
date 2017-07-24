<?php

class IWD_OrderManager_Block_Adminhtml_Sales_Order_Create_Search_Grid_Renderer_Product extends Mage_Adminhtml_Block_Sales_Order_Create_Search_Grid_Renderer_Product
{
    /**
     * @param   Varien_Object $row
     * @return  string
     */
    public function render(Varien_Object $row)
    {
        $product = Mage::getModel('catalog/product')->load($row->getId());
        if (!$product->isVisibleInSiteVisibility()) {
            return parent::render($row);
        } else {
            $productLink = $product->getProductUrl();

            return parent::render($row)
            . "<span class='f-right'>&nbsp;&nbsp;|&nbsp;&nbsp;</span>"
            . sprintf('<a href="%s" class="f-right" target="_blank">%s</a>', $productLink, Mage::helper('sales')->__('Preview'));
        }
    }
}
