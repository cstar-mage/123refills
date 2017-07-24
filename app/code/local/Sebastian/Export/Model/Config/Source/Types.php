<?php

/**
 *
 * Copyright Sebastian Enzinger <sebastian@enzinger.de> www.sebastian-enzinger.de
 *
 * All rights reserved.
 *
**/

class Sebastian_Export_Model_Config_Source_Types
{

    public function toOptionArray()
    {
        return array(
            array('value'=>'XML', 'label'=>Mage::helper('adminhtml')->__('XML')),
            array('value'=>'CSV', 'label'=>Mage::helper('adminhtml')->__('CSV')),
            array('value'=>'Custom', 'label'=>Mage::helper('adminhtml')->__('Custom')),
        );
    }

}
