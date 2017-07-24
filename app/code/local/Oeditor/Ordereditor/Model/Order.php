<?php
/**
 * Magento Order Editor Module
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the License Version.
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 *
 * @category   Order Editor
 * @package    Oeditor_Ordereditor
 * @copyright  Copyright (c) 2010 
 * @version    0.6.2
*/ 

class Oeditor_Ordereditor_Model_Order extends Mage_Sales_Model_Order
{
	protected $_addresses = null;
	protected $_nitems;

	public function isVirtual()
    {
		$isVirtual = true;
        $countItems = 0;
        foreach ($this->getItemsCollection() as $_item) {

            if ($_item->isDeleted() || $_item->getParentItemId()) {
                continue;
            }
            $countItems ++;
            if (!$_item->getProduct()->getIsVirtual()) {
                $isVirtual = false;
            }
        }
        return $countItems == 0 ? false : $isVirtual;
    }

    public function removeItem($itemId)
    {
		$this->getItemById($itemId)->delete();
        return $this;
    }
	 
}