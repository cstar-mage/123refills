<?php
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Allpagestyle extends Varien_Data_Form_Element_Text
{
    /**
     * Override field method to add js
     *
     * @param Varien_Data_Form_Element_Abstract $this
     * @return String
     */
    
	public function getHtml()
    {
        // Get the default HTML for this option
        //$html = parent::getHtml();
    	
    	$html .= "<div class='hor-scroll'>hi</div>";
    	return $html;
        
    }
}