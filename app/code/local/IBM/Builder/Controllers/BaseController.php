<?php

class IBM_Builder_Controllers_BaseController extends Mage_Adminhtml_Controller_Action
{
    public function preDispatch ()
    {
        Mage::app()->getRequest ()->setInternallyForwarded();
        return parent::preDispatch();
    }
    
    protected function _isAllowed()
    {
        return true;
    }
}