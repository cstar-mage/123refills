<?php

/**
 *
 * Copyright Sebastian Enzinger <sebastian@enzinger.de> www.sebastian-enzinger.de
 *
 * All rights reserved.
 *
**/
 
class Sebastian_Export_Block_Sales_Order_Grid extends Mage_Adminhtml_Block_Sales_Order_Grid
{
    
    protected function _prepareMassaction()
    {
        parent::_prepareMassaction();
        $this->getMassactionBlock()->addItem('exportorders', array(
             'label'=> Mage::helper('export')->__('Export orders'),
             'url'  => $this->getUrl('export'),
        ));
    }
}