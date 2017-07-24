<?php

class IWD_OrderManager_Model_Observer_Flags
{
    /**
     * @param Varien_Event_Observer $observer
     */
    public function assignFlagsToOrder(Varien_Event_Observer $observer)
    {
        /**
         * @var $order Mage_Sales_Model_Order
         */
        $order = $observer->getEvent()->getOrder();
        $orderId = $order->getId();

        $flags = $this->getFlags($order);
        $typeFlagRelation = $this->getTypeFlagRelation($flags);

        foreach ($typeFlagRelation as $typeId => $flagId) {
            Mage::getModel('iwd_ordermanager/flags_orders')->addNewRelation($flagId, $orderId, $typeId);
        }
    }

    /**
     * @param $flags array
     * @return array
     */
    protected function getTypeFlagRelation($flags)
    {
        $typeFlagRelation = array();
        foreach ($flags as $flagId) {
            $types = IWD_OrderManager_Model_Flags_Flags::getAssignTypesForFlag($flagId);
            foreach ($types as $typeId) {
                $typeFlagRelation[$typeId] = $flagId;
            }
        }

        return $typeFlagRelation;
    }

    /**
     * @param $order Mage_Sales_Model_Order
     * @return array
     */
    protected function getFlags($order)
    {
        $flagsStatus = Mage::getModel('iwd_ordermanager/flags_autoapply')->getCollection()
            ->addFieldToFilter('apply_type', IWD_OrderManager_Model_Flags_Autoapply::TYPE_ORDER_STATUS)
            ->addFieldToFilter('method_key', $order->getStatus())
            ->getColumnValues('flag_id');

        $flagsPayments = Mage::getModel('iwd_ordermanager/flags_autoapply')->getCollection()
            ->addFieldToFilter('apply_type', IWD_OrderManager_Model_Flags_Autoapply::TYPE_PAYMENT_METHOD)
            ->addFieldToFilter('method_key', $order->getPayment()->getMethod())
            ->getColumnValues('flag_id');

        $flagsShipping = Mage::getModel('iwd_ordermanager/flags_autoapply')->getCollection()
            ->addFieldToFilter('apply_type', IWD_OrderManager_Model_Flags_Autoapply::TYPE_SHIPPING_METHOD)
            ->addFieldToFilter('method_key', $order->getShippingMethod())
            ->getColumnValues('flag_id');

        $flags = array_merge($flagsStatus, $flagsPayments, $flagsShipping);
        $flags = array_unique($flags);

        return $flags;
    }

    /**
     * @param Varien_Event_Observer $observer
     */
    public function assignFlagAfterChangeStatus(Varien_Event_Observer $observer)
    {
        /**
         * @var $order Mage_Sales_Model_Order
         */
        $order = $observer->getEvent()->getOrder();
        $oldStatus = $order->getOrigData('status');
        $newStatus = $order->getData('status');

        if ($oldStatus != $newStatus) {
            $flags = Mage::getModel('iwd_ordermanager/flags_autoapply')->getCollection()
                ->addFieldToFilter('apply_type', IWD_OrderManager_Model_Flags_Autoapply::TYPE_ORDER_STATUS)
                ->addFieldToFilter('method_key', $newStatus)
                ->getColumnValues('flag_id');

            $typeFlagRelation = $this->getTypeFlagRelation($flags);
            $orderId = $order->getId();

            foreach ($typeFlagRelation as $typeId => $flagId) {
                Mage::getModel('iwd_ordermanager/flags_orders')->addNewRelation($flagId, $orderId, $typeId);
            }
        }
    }
}
