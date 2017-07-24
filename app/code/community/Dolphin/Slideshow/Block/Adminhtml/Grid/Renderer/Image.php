<?php
class Dolphin_Slideshow_Block_Adminhtml_Grid_Renderer_Image extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    /* public function render(Varien_Object $row)
    {
        if($row->getData($this->getColumn()->getIndex())==""){
            return "";
        }
        else{
            $html = '<img ';
            $html .= 'id="' . $this->getColumn()->getId() . '" ';
            $html .= 'width="60" ';
            $html .= 'height="45" ';
            $html .= 'src="' . Mage::getBaseUrl("media") . Mage::helper('slideshow')->getThumbsPath($row->getData($this->getColumn()->getIndex())) . '"';
            $html .= 'class="grid-image ' . $this->getColumn()->getInlineCss() . '"/>';
            
            return $html;
        }
    } */
	
	public function render(Varien_Object $row)
	{
		if($row->getData($this->getColumn()->getIndex())==""){
			if($row->getData('desktop_img'))
			{
				$html = "<img src='". Mage::getBaseUrl('media') . DS .'wysiwyg/slideshow/'.$row->getData('desktop_img') ."' />";
				//$html = $row->getData('desktop_img');
			}
			else
			{
				return "";
			}
		}
		else{
			$helper = Mage::helper('cms');
			$processor = $helper->getPageTemplateProcessor();			
			$html = $processor->filter($row->getData($this->getColumn()->getIndex()));
			$html .= "<style>#slideshowGrid_table img { width:100%; height:auto; }</style>";
		}
		return $html;
	}
} 