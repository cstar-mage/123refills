<?php

class IWD_OrderManager_Block_System_Config_Form_Fieldset_Runarchive extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $archiveTitle = Mage::helper('iwd_ordermanager')->__("Archive All");
        $restoreTitle = Mage::helper('iwd_ordermanager')->__("Restore All");

        $secure = Mage::app()->getStore()->isCurrentlySecure();
        $archiveLink = Mage::helper("adminhtml")->getUrl('adminhtml/sales_archive_order/archivemanually', array('_secure' => $secure));
        $restoreLink = Mage::helper("adminhtml")->getUrl('adminhtml/sales_archive_order/restoremanually', array('_secure' => $secure));

        return '<button style="margin-right:120px;" type="button" onclick="setLocation(\'' . $archiveLink . '\')">' . $archiveTitle . '</button>' .
        '<button type="button" onclick="setLocation(\'' . $restoreLink . '\')">' . $restoreTitle . '</button>';
    }
}