<?php

class IWD_OrderManager_Block_System_Config_Form_Fieldset_Color extends Mage_Adminhtml_Block_System_Config_Form_Field
{
    const XML_PATH_ORDER_GRID_STATUS_COLOR = 'iwd_ordermanager/grid_order/status_color';

    protected $statusColorElement = "";

    public function getStatusColor()
    {
        return Mage::getStoreConfig(self::XML_PATH_ORDER_GRID_STATUS_COLOR);
    }

    protected function _getElementHtml(Varien_Data_Form_Element_Abstract $element)
    {
        $this->prependColorElement();
        $this->addItemsToColorElement();
        $this->appendColorElement();

        return $this->statusColorElement;
    }

    protected function addItemsToColorElement()
    {
        $statuses = Mage::getSingleton('sales/order_config')->getStatuses();

        foreach ($statuses as $code => $label) {
            $this->addListItemToColorElement($code, $label);
        }
    }

    protected function addListItemToColorElement($code, $label)
    {
        $clearButton = $this->getClearColorButton();
        $this->statusColorElement .= '<li id="' . $code . '"><span class="color-box">' . $label . '</span>' . $clearButton . '</li>';
    }

    protected function getClearColorButton()
    {
        $clearText = Mage::helper('iwd_ordermanager')->__('Clear color');
        return '<span class="clear-color" title="' . $clearText . '">X<span>';
    }

    protected function prependColorElement()
    {
        $this->statusColorElement .= '<ul id="order_status_color">';
    }

    protected function appendColorElement()
    {
        $this->statusColorElement .= '</ul><input type="hidden" id="iwd_ordermanager_grid_order_status_color"
        name="groups[grid_order][fields][status_color][value]" value="' . $this->getStatusColor() . '" />';
    }
}