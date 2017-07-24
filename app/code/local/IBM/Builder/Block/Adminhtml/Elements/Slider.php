<?php

class IBM_Builder_Block_Adminhtml_Elements_Slider extends Mage_Adminhtml_Block_Widget
{
    protected function _construct()
    {
        parent::_construct();

        $this->setData('area', 'frontend');
        $this->setTemplate('ibmbuilder/elements/slider.phtml');
    }
}