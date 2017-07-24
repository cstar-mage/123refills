<?php

class IWD_OrderManager_Block_Adminhtml_Flags_Flags_Renderer_Icon extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Action
{
    public function render(Varien_Object $row)
    {
        /**
         * @var $row IWD_OrderManager_Model_Flags_Flags
         */
        return $row->getIconHtml();
    }
}