<?php

/**
 * Class IWD_OrderManager_Helper_Downloadable
 */
class IWD_OrderManager_Helper_Downloadable extends Mage_Core_Helper_Abstract
{
    /**
     * @param $orderItem
     * @return false|null|string
     */
    public function getSupportPeriodDate($orderItem)
    {
        if (!Mage::getConfig()->getModuleConfig('IWD_Downloadable')->is('active', 'true')) {
            return null;
        }

        $purchasedItems = $this->getPurchasedItems($orderItem->getId());

        if (!empty($purchasedItems)) {
            $supportDate = $purchasedItems->getFirstItem();
            if (isset($supportDate)) {
                $supportDate = $supportDate->getSupportAt();
            }

            if (isset($supportDate)) {
                $supportDate = Mage::getModel('core/date')->timestamp($supportDate);
                return date('Y-m-d', $supportDate);
            }
        }

        return null;
    }

    /**
     * @param $orderItem
     * @return null|string
     */
    public function getSupportPeriod($orderItem)
    {
        if (!Mage::getConfig()->getModuleConfig('IWD_Downloadable')->is('active', 'true')) {
            return null;
        }

        $purchasedItems = $this->getPurchasedItems($orderItem->getId());

        if (!empty($purchasedItems)) {
            $supportPeriod = array();

            foreach ($purchasedItems as $item) {
                $supportAtDate = $item->getSupportAt();
                $supportDate = Mage::getModel('core/date')->timestamp($supportAtDate);

                $dNow = new DateTime('now');
                $dSupport = new DateTime(date('Y-m-d', $supportDate));
                $dDiff = $dNow->diff($dSupport);

                $style = $dDiff->format('%R') == '-' ? "color:red" : "color:green";

                $supportPeriod[] =
                    '<span style="' . $style . '">'
                    . date('Y-m-d', $supportDate) . " (" . $dDiff->format('%R') . $dDiff->days . " days)"
                    . '<span>';
            }

            return implode(', ', $supportPeriod);
        }

        return null;
    }

    /**
     * @param $orderItem
     * @return null|string
     */
    public function getCountOfDownloads($orderItem)
    {
        if (!Mage::getConfig()->getModuleConfig('IWD_Downloadable')->is('active', 'true')) {
            return null;
        }

        $items = Mage::getModel("iwd_downloadable/downloadcount")->getCollection()
            ->addFieldToFilter('order_item_id', $orderItem->getId());

        $versions = Mage::getModel('iwd_downloadable/versions');
        if (!empty($items)) {
            $counts = array();
            foreach ($items as $item) {
                $counts[] = $versions->load($item->getVersionId())->getVersion() . " (" . $item->getCount() . ")";
            }

            return implode(', ', $counts);
        }

        return "";
    }

    /**
     * @param $orderItemId
     * @param $supportDate
     * @return void
     */
    public function updateSupportPeriod($orderItemId, $supportDate)
    {
        if (!Mage::getConfig()->getModuleConfig('IWD_Downloadable')->is('active', 'true')) {
            return;
        }

        $purchasedItems = $this->getPurchasedItems($orderItemId);

        if (!empty($purchasedItems)) {
            foreach ($purchasedItems as $item) {
                $supportDate = Mage::getModel('core/date')->timestamp($supportDate);
                $item->setSupportAt($supportDate)->save();
            }
        }
    }

    /**
     * @param $orderItemId
     * @return mixed
     */
    protected function getPurchasedItems($orderItemId)
    {
        return Mage::getModel("downloadable/link_purchased_item")->getCollection()
            ->addFieldToFilter('order_item_id', $orderItemId)
            ->addFieldToFilter(
                'link_title',
                array('in' => array(
                    IWD_Downloadable_Block_Customer_Products_List::COMMUNITY,
                    IWD_Downloadable_Block_Customer_Products_List::ENTERPRISE
                ))
            );
    }
}
