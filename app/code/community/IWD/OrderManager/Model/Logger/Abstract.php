<?php

/**
 * Class IWD_OrderManager_Model_Logger_Abstract
 */
class IWD_OrderManager_Model_Logger_Abstract extends Mage_Core_Model_Abstract
{
    const BR = "&nbsp;<br/>";

    protected $deleteLogSuccess = array();
    protected $deleteLogError = array();
    protected $notices = array();
    protected $changesLog = array();
    protected $orderAddressLog = array();
    protected $editedOrderItems = array();
    protected $addedOrderItems = array();
    protected $orderedItemsName = array();
    protected $removeOrderItems = array();

    protected $newTotals = array();
    protected $logOutput = "";
    protected $logNotices = "";

    protected $orderParams = array(
        'order_status' => "Changed status from '%s' to '%s'",
        'order_state' => "Changed state from '%s' to '%s'",
        'order_store_name' => "Changed purchased from store '%s' to '%s'",
        'created_at' => "Changed order date from '%s' to '%s'",
        'order_increment_id' => "Changed order number from '%s' to '%s'",

        'payment_method' => "Payment method was changed from '%s' to '%s'",
        'shipping_method' => "Shipping method was changed from '%s' to '%s'",
        'shipping_amount' => "Shipping amount was changed from '%s' to '%s'",

        'customer_group_id' => "Order customer group was changed from '%s' to '%s'",
        'customer_prefix' => "Order customer prefix was changed from '%s' to '%s'",
        'customer_firstname' => "Order customer first name was changed from '%s' to '%s'",
        'customer_middlename' => "Order customer middle name was changed from '%s' to '%s'",
        'customer_lastname' => "Order customer last name was changed from '%s' to '%s'",
        'customer_suffix' => "Order customer suffix was changed from '%s' to '%s'",
        'customer_email' => "Order customer e-mail was changed from '%s' to '%s'",
    );

    /**
     * add to log
     *
     * @param $orderItem
     * @param $description
     * @param $old
     * @param null $new
     */
    public function addOrderItemEdit($orderItem, $description, $old, $new = null)
    {
        $description = Mage::helper('iwd_ordermanager')->__($description);
        $id = $orderItem->getId();
        $this->orderedItemsName[$id] = $orderItem->getName();

        if ($new === null) {
            $this->editedOrderItems[$id][] = sprintf(' - %s: "%s"', $description, $old) . self::BR;
            return;
        }

        if ($old != $new) {
            $this->editedOrderItems[$id][] = sprintf(' - %s: "%s" to "%s"', $description, $old, $new) . self::BR;
        }
    }

    /**
     * @param $orderItem
     */
    public function addOrderItemAdd($orderItem)
    {
        $this->addedOrderItems[$orderItem->getId()] = $orderItem->getName();
        $this->orderedItemsName[$orderItem->getId()] = $orderItem->getName();
    }

    /**
     * @param $orderItem
     * @param bool|false $refund
     */
    public function addOrderItemRemove($orderItem, $refund = false)
    {
        $this->removeOrderItems[$orderItem->getId()] = $refund;
        $this->orderedItemsName[$orderItem->getId()] = $orderItem->getName();
    }

    /**
     * @param $item
     * @param $oldValue
     * @param $newValue
     */
    public function addChangesToLog($item, $oldValue, $newValue)
    {
        if ($newValue != $oldValue) {
            $this->changesLog[$item] = array(
                "new" => $newValue,
                "old" => $oldValue,
            );
        }
    }

    /**
     * @param $addressType
     * @param $filed
     * @param $title
     * @param $oldValue
     * @param $newValue
     */
    public function addAddressFieldChangesToLog($addressType, $filed, $title, $oldValue, $newValue)
    {
        if ($newValue != $oldValue) {
            if ($filed == "region_id") {
                $filed = "region";
                $newValue = Mage::getModel('directory/region')->load($newValue)->getName();
                $oldValue = Mage::getModel('directory/region')->load($oldValue)->getName();

                if (isset($this->orderAddressLog[$addressType][$filed]['new'])
                    && !empty($this->orderAddressLog[$addressType][$filed]['new'])
                ) {
                    $newValue = $this->orderAddressLog[$addressType][$filed]['new'];
                }

                if (isset($this->orderAddressLog[$addressType][$filed]['old'])
                    && !empty($this->orderAddressLog[$addressType][$filed]['old'])
                ) {
                    $oldValue = $this->orderAddressLog[$addressType][$filed]['old'];
                }
            }

            if ($filed == "country_id") {
                $filed = "country";
                $newValue = Mage::getModel('directory/country')->loadByCode($newValue)->getName();
                $oldValue = Mage::getModel('directory/country')->loadByCode($oldValue)->getName();
            }

            $this->orderAddressLog[$addressType][$filed] = array(
                "new" => $newValue,
                "old" => $oldValue,
                "title" => $title
            );
        }
    }

    /**
     * @param $item
     * @param $itemIncrementId
     */
    public function itemDeleteSuccess($item, $itemIncrementId)
    {
        $this->deleteLogSuccess[$item][] = $itemIncrementId;
    }

    /**
     * @param $item
     * @param $itemIncrementId
     */
    public function itemDeleteError($item, $itemIncrementId)
    {
        $this->deleteLogError[$item][] = $itemIncrementId;
    }

    /**
     * @param $noticeId
     * @param $message
     */
    public function addNoticeMessage($noticeId, $message)
    {
        $this->notices[$noticeId] = $message;
    }

    /**
     * @param $item
     */
    protected function addInfoAboutSuccessAddedItemsToMessage($item)
    {
        $count = isset($this->deleteLogSuccess[$item]) ? count($this->deleteLogSuccess[$item]) : 0;

        if ($count > 0) {
            if ($count == 1) {
                $message = Mage::helper('iwd_ordermanager')->__("The sale %s #%s has been deleted successfully.");
                $itemTitle = Mage::helper('iwd_ordermanager')->__($item);
                $message = sprintf($message, $itemTitle, $this->deleteLogSuccess[$item][0]);
            } else {
                $message = Mage::helper('iwd_ordermanager')->__("%i %s have been deleted successfully: %s");
                $ids = '#' . implode(', #', $this->deleteLogSuccess[$item]);
                $itemTitle = Mage::helper('iwd_ordermanager')->__($item);
                $message = sprintf($message, $count, $itemTitle, $ids);
            }

            Mage::getSingleton('adminhtml/session')->addSuccess($message);
        }
    }

    /**
     * @param $item
     */
    protected function addInfoAboutErrorAddedItemsToMessage($item)
    {
        $count = isset($this->deleteLogError[$item]) ? count($this->deleteLogError[$item]) : 0;

        if ($count > 0) {
            if ($count == 1) {
                $message = Mage::helper('iwd_ordermanager')->__("The sale %s #%s can not be deleted.");
                $itemTitle = Mage::helper('iwd_ordermanager')->__($item);
                $message = sprintf($message, $itemTitle, $this->deleteLogError[$item][0]);
            } else {
                $message = Mage::helper('iwd_ordermanager')->__("%i %s can not be deleted: %s");
                $ids = '#' . implode(', #', $this->deleteLogError[$item]);
                $itemTitle = Mage::helper('iwd_ordermanager')->__($item);
                $message = sprintf($message, $count, $itemTitle, $ids);
            }

            Mage::getSingleton('adminhtml/session')->addError($message);
        }
    }

    /**
     * output
     */
    public function addMessageToPage()
    {
        $items = array('order', 'invoice', 'shipment', 'creditmemo');
        foreach ($items as $item) {
            $this->addInfoAboutSuccessAddedItemsToMessage($item);
            $this->addInfoAboutErrorAddedItemsToMessage($item);
        }

        foreach ($this->notices as $notice) {
            Mage::getSingleton('adminhtml/session')->addNotice($notice);
        }
    }

    /**
     * @param null $orderId
     * @return null
     */
    public function getLogOutput($orderId = null)
    {
        if (empty($this->logOutput)) {
            $this->logOutput = "";
            $this->addToLogOutputInfoAboutOrderChanges();
            $this->addToLogOutputInfoAboutOrderAddress();
            $this->addToLogOutputInfoAboutOrderItems();
            $this->addtoLogOutputInfoAboutOrderTotals($orderId);
            $this->addToLogOutputNotices();
        }

        return null;
    }

    /**
     * @return void
     */
    protected function addToLogOutputInfoAboutOrderChanges()
    {
        $helper = Mage::helper('iwd_ordermanager');
        foreach ($this->orderParams as $itemCode => $itemMessage) {
            if (isset($this->changesLog[$itemCode])) {
                $this->logOutput .= sprintf(
                        $helper->__($itemMessage),
                        $this->changesLog[$itemCode]['old'],
                        $this->changesLog[$itemCode]['new']
                    ) . self::BR;
            }
        }
    }

    /**
     * @return void
     */
    protected function addToLogOutputInfoAboutOrderAddress()
    {
        $helper = Mage::helper('iwd_ordermanager');

        foreach (array("billing", "shipping") as $addressType) {
            if (isset($this->orderAddressLog[$addressType]) && !empty($this->orderAddressLog[$addressType])) {
                $this->logOutput .= $helper->__("Order {$addressType} address updated: ") . self::BR;
                foreach ($this->orderAddressLog[$addressType] as $id => $field) {
                    $this->logOutput .= sprintf(
                            ' - %s from "%s" to "%s"',
                            $field['title'],
                            $field['old'],
                            $field['new']
                        ) . self::BR;
                }
            }
        }
    }

    /**
     * @return void
     */
    protected function addToLogOutputInfoAboutOrderItems()
    {
        $helper = Mage::helper('iwd_ordermanager');

        /*** add order items ***/
        if (!empty($this->addedOrderItems)) {
            foreach ($this->addedOrderItems as $itemId => $itemName) {
                $this->logOutput .= "<b>{$itemName}</b> {$helper->__('was added')}" . self::BR;
            }
        }

        /*** edit order items ***/
        if (!empty($this->editedOrderItems)) {
            foreach ($this->editedOrderItems as $itemId => $edited) {
                $this->logOutput .= '<b>' . $this->orderedItemsName[$itemId] . '</b> ' . $helper->__('was edited') . ':' . self::BR;
                foreach ($edited as $e) {
                    $this->logOutput .= $e;
                }
            }
        }

        /*** remove order items ***/
        if (!empty($this->removeOrderItems)) {
            foreach ($this->removeOrderItems as $itemId => $refunded) {
                $message = ($refunded) ? $helper->__('was removed (refunded)') : $helper->__('was removed');
                $this->logOutput .= "<b>{$this->orderedItemsName[$itemId]}</b> {$message}" . self::BR;
            }
        }
    }

    /**
     * @param $orderId
     * @return void
     */
    public function addtoLogOutputInfoAboutOrderTotals($orderId)
    {
        if (empty($orderId) || empty($this->newTotals)) {
            return;
        }

        $order = Mage::getModel('sales/order')->load($orderId);
        $helper = Mage::helper('iwd_ordermanager');

        $baseGrandTotal = isset($this->newTotals['base_grand_total']) ? $this->newTotals['base_grand_total'] : 0;
        $oldGrandTotal = Mage::helper('core')->currency($order->getBaseGrandTotal(), true, false);
        $newGrandTotal = Mage::helper('core')->currency($baseGrandTotal, true, false);
        $changes = Mage::helper('core')->currency($baseGrandTotal - $order->getBaseGrandTotal(), true, false);

        $this->logOutput .= self::BR .
            $helper->__('Old grand total: ') . $oldGrandTotal . self::BR .
            $helper->__('New grand total: ') . $newGrandTotal . self::BR .
            $helper->__('Changes: ') . $changes . self::BR;
    }

    /**
     * @param $totals
     * @return void
     */
    public function addNewTotalsToLog($totals)
    {
        $this->newTotals = $totals;
    }

    /**
     * @param $message
     */
    public function addNoticeToLog($message)
    {
        $this->logNotices .= $message . self::BR;
    }

    /**
     * @return string
     */
    public function addToLogOutputNotices()
    {
        if (empty($this->logNotices)) {
            return $this->logOutput;
        }

        return $this->logOutput .= self::BR . $this->logNotices;
    }

    /**
     * @param $message
     * @return string
     */
    public function addToLog($message)
    {
        return $this->logOutput .= $message;
    }
}
