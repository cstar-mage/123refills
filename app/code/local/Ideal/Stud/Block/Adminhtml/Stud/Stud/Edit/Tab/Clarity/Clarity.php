<?php

class Ideal_Stud_Block_Adminhtml_Stud_Stud_Edit_Tab_Clarity_Clarity extends Mage_Adminhtml_Block_Widget implements Varien_Data_Form_Element_Renderer_Interface
{
    public function __construct()
    {
        
        $this->setTemplate('stud/stud/edit/tab/clarity/clarity.phtml');
    }

	public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        return $this->toHtml();
    }
	
}
 