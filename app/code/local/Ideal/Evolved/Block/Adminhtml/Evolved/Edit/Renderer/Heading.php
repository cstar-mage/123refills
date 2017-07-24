<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Heading extends Varien_Data_Form_Element_Label
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    
    public function getElementHtml()
    {
        //$time = $this->getHtmlId();
        
    	$html = '<h4 id="'.$this->getHtmlId().'">'.$this->getLabel().'</h4>';


        return $html;
    }
}