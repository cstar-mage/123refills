<?php
class Ideal_Diamondsearch_Block_Adminhtml_Diamondsearch_Edit_Tab_Slider_Fancycolor
 extends Mage_Adminhtml_Block_Widget
 implements Varien_Data_Form_Element_Renderer_Interface
{
    public function __construct()
    {
        $this->setTemplate('diamondsearch/edit/tab/slider/fancycolor.phtml');
    }

	public function render(Varien_Data_Form_Element_Abstract $element)
    {
        $this->setElement($element);
        return $this->toHtml();
    }
	
}
