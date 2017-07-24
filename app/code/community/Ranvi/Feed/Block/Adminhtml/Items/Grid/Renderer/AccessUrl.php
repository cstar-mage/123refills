<?php

class Ranvi_Feed_Block_Adminhtml_Items_Grid_Renderer_AccessUrl extends  Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract{

	

	public function render(Varien_Object $feed){

		

		if($url = $feed->getUrl()){

			return sprintf('<a href="%s" target="_blank">%s</a>', $url, $url);

		}

		

	}

}