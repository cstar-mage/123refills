<?php

class Ranvi_Feed_Block_Adminhtml_Items_Grid_Renderer_Datetime extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Datetime{

		

		public function render(Varien_Object $row)

	    {

	        if('0000-00-00 00:00:00' == $this->_getValue($row)){

	            

	        	return $this->getColumn()->getDefault();

	        	

	        }

	        return parent::render($row);

	    }

		

	}