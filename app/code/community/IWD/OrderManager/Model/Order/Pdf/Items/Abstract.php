<?php

/**
 * Class IWD_OrderManager_Model_Order_Pdf_Items_Abstract
 */
abstract class IWD_OrderManager_Model_Order_Pdf_Items_Abstract extends Mage_Sales_Model_Order_Pdf_Items_Abstract
{
    /**
     * @return array
     */
    public function getItemOptions()
    {
        $result = array();

        if ($options = $this->getOrderItem()->getProductOptions()) {
            if (isset($options['options'])) {
                $result = array_merge($result, $options['options']);
            }

            if (isset($options['additional_options'])) {
                $result = array_merge($result, $options['additional_options']);
            }

            if (isset($options['attributes_info'])) {
                $result = array_merge($result, $options['attributes_info']);
            }
        }

        return $result;
    }

    /**
     * @param $item
     * @return mixed
     */
    public function getSku($item)
    {
        if ($this->getOrderItem($item)->getProductOptionByCode('simple_sku')) {
            return $this->getOrderItem($item)->getProductOptionByCode('simple_sku');
        }

        return $item->getSku();
    }

    /**
     * @param null $item
     * @return null|Varien_Object
     */
    protected function getOrderItem($item = null)
    {
        if ($item instanceof Mage_Sales_Model_Order_Item) {
            return $item;
        }

        if ($item !== null) {
            return $item->getOrderItem();
        }

        if ($this->getItem() instanceof Mage_Sales_Model_Order_Item) {
            return $this->getItem();
        }

        return $this->getItem()->getOrderItem();
    }
}
