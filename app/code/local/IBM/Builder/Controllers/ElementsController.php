<?php

class IBM_Builder_ElementsController extends Mage_Core_Controller_Front_Action
{
    public function getElementHtmlAction()
    {
        $element = $this->getRequest()->getParam('type');
        
        $elementBlock = Mage::getBlockSingleton('IBMBuilder/Adminhtml_Elements_'.ucfirst($element));
        
        return $this->getResponse()->setBody($elementBlock->toHtml());
    }
}