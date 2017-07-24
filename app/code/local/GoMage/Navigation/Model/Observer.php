<?php
 /**
 * GoMage Advanced Navigation Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2011 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 2.1
 * @since        Class available since Release 1.0
 */
	
	class GoMage_Navigation_Model_Observer{
		
		public function loadAttribute($event){
			
			$attribute		= $event->getAttribute();
			$attribute_id	= (int)$attribute->getAttributeId();
			
			$connection = Mage::getSingleton('core/resource')->getConnection('read');
			
			$table = Mage::getSingleton('core/resource')->getTableName('gomage_navigation_attribute');
			
			$data = $connection->fetchRow("SELECT * FROM {$table} WHERE `attribute_id` = {$attribute_id};");
			
			$table = Mage::getSingleton('core/resource')->getTableName('gomage_navigation_attribute_option');
			
			$option_images = array();
			$_option_images = $connection->fetchAll("SELECT * FROM {$table} WHERE `attribute_id` = {$attribute_id};");
			
			foreach($_option_images as $imageInfo){
				
				$option_images[$imageInfo['option_id']] = $imageInfo;
				
			}
			
			$data['option_images'] = $option_images;
			
			if($data && is_array($data) && !empty($data)){
				
				$attribute->addData($data);
				
			}
			
			
		}
		
		public function moveImageFromTmp($file)
	    {

	        $ioObject = new Varien_Io_File();
	        $destDirectory = Mage::getBaseDir('media').'/option_image';
	        
	        try {
	            $ioObject->open(array('path'=>$destDirectory));
	        } catch (Exception $e) {
	            $ioObject->mkdir($destDirectory, 0777, true);
	            $ioObject->open(array('path'=>$destDirectory));
	        }

	        if (strrpos($file, '.tmp') == strlen($file)-4) {
	            $file = substr($file, 0, strlen($file)-4);
	        }

	        $destFile = Varien_File_Uploader::getNewFileName($file);
	        
	        $dest = $destDirectory .'/'. $destFile;

	        $ioObject->mv(
	            $this->_getMadiaConfig()->getTmpMediaPath($file),
	            $dest
	        );

	        return $destFile;
	    }
		
		public function saveAttribute($event){
			
			$connection = Mage::getSingleton('core/resource')->getConnection('read');
			$table = Mage::getSingleton('core/resource')->getTableName('gomage_navigation_attribute');
			
			$attribute_id		= (int)$event->getAttribute()->getAttributeId();
			$filter_type		= (int)$event->getAttribute()->getData('filter_type');
			$image_align		= (int)$event->getAttribute()->getData('image_align');
			$image_width		= (int)$event->getAttribute()->getData('image_width');
			$image_height		= (int)$event->getAttribute()->getData('image_height');
			$show_minimized		= (int)$event->getAttribute()->getData('show_minimized');
			$show_image_name	= (int)$event->getAttribute()->getData('show_image_name');
			$show_help			= (int)$event->getAttribute()->getData('show_help');
			$show_checkbox		= (int)$event->getAttribute()->getData('show_checkbox');
			$popup_text			= trim($event->getAttribute()->getData('popup_text'));
			$popup_width		= (int)$event->getAttribute()->getData('popup_width');
			$popup_height		= (int)$event->getAttribute()->getData('popup_height');
			$filter_reset		= (int)$event->getAttribute()->getData('filter_reset');
			$is_ajax		    = (int)$event->getAttribute()->getData('is_ajax');
			$inblock_height		= (int)$event->getAttribute()->getData('inblock_height');
			$filter_button		= (int)$event->getAttribute()->getData('filter_button');
						
			
			
			if($connection->fetchOne("SELECT COUNT(*) FROM {$table} WHERE `attribute_id` = {$attribute_id};") > 0){
				
				$connection->query("UPDATE {$table} SET 
					`filter_type`		= {$filter_type},
					`image_align`		= {$image_align},
					`image_width`		= {$image_width},
					`image_height`		= {$image_height},
					`show_minimized`	= {$show_minimized},
					`show_image_name`	= {$show_image_name},
					`show_checkbox`		= {$show_checkbox},
					`show_help`			= {$show_help},
					`popup_text`		= '{$popup_text}',
					`popup_width`		= {$popup_width},
					`popup_height`		= {$popup_height},
					`filter_reset`      = {$filter_reset}, 
					`is_ajax`      	    = {$is_ajax},
					`inblock_height`    = {$inblock_height},
					`filter_button`     = {$filter_button}
					
					WHERE `attribute_id` = {$attribute_id};
				");
				
			}else{
				
				$connection->query("INSERT INTO {$table} SET 
					`attribute_id`		= {$attribute_id}, 
					`filter_type`		= {$filter_type},
					`image_align`		= {$image_align},
					`image_width`		= {$image_width},
					`image_height`		= {$image_height},
					`show_minimized`	= {$show_minimized},
					`show_image_name`	= {$show_image_name},
					`show_checkbox`		= {$show_checkbox},
					`show_help`			= {$show_help},
					`popup_text`		= '{$popup_text}',
					`popup_width`		= {$popup_width},
					`popup_height`		= {$popup_height},
					`filter_reset`      = {$filter_reset},
					`is_ajax`      	    = {$is_ajax},
					`inblock_height`    = {$inblock_height},
					`filter_button`     = {$filter_button}
				");
				
			}
			
		}
		
		public function checkAjax(){
			
			if($layout = Mage::getSingleton('core/layout')){
				
				if(intval(Mage::app()->getFrontController()->getRequest()->getParam('ajax'))){
					
					$layout->removeOutputBlock('root');
					$layout->removeOutputBlock('core_profiler');
					
					if($layout->getBlock('catalogsearch.leftnav'))
                    {
						$navBlock = $layout->getBlock('catalogsearch.leftnav');
					}
                    elseif($layout->getBlock('catalog.leftnav'))
                    {
                        $navBlock = $layout->getBlock('catalog.leftnav');
                    }
                    elseif($layout->getBlock('gomage.enterprise.catalogsearch.leftnav'))
                    {
                        $navBlock = $layout->getBlock('gomage.enterprise.catalogsearch.leftnav');
                    }
                    elseif($layout->getBlock('gomage.enterprise.catalog.leftnav'))
                    {
                        $navBlock = $layout->getBlock('gomage.enterprise.catalog.leftnav');
                    }

					if(!($productsBlock = $layout->getBlock('search_result_list'))){
						$productsBlock = $layout->getBlock('product_list');
					}

					$LeftnavBlock = $layout->getBlock('gomage.navigation.left');
					$RightnavBlock = $layout->getBlock('gomage.navigation.right');

					$gomage_ajax = $layout->createBlock('gomage_navigation/ajax', 'gomage_ajax');
					$gomage_ajax->addData(

							array(
								'navigation'	    => ($navBlock ? Mage::getModel('core/url')->sessionUrlVar($navBlock->toHtml()) : ''),
								'product_list'	    => ($productsBlock ? Mage::getModel('core/url')->sessionUrlVar($productsBlock->toHtml()) : ''),
							    'navigation_left'	=> ($LeftnavBlock ? Mage::getModel('core/url')->sessionUrlVar($LeftnavBlock->toHtml()) : ''), 
							    'navigation_right'	=> ($RightnavBlock ? Mage::getModel('core/url')->sessionUrlVar($RightnavBlock->toHtml()) : ''),
							)
							
						);
						
					if (Mage::getStoreConfig('gomage_procart/qty_settings/category_page') && $productsBlock) {						
				        $gomage_ajax->addEvalJs("if (typeof(GomageProcartConfig) != 'undefined') {
				        	gomage_procart_product_list = " . $productsBlock->getProcartProductList() . ";
				        	GomageProcartConfig.initialize(gomage_procart_config);
					        };", "eval_js_procart");	
					}
						
					$layout->addOutputBlock('gomage_ajax', 'toJson');
					
				}
				
			}
			
		}
		
	protected function _getMadiaConfig()
    {
        return Mage::getSingleton('catalog/product_media_config');
    }

	static public function checkK($event){
			
			$key = Mage::getStoreConfig('gomage_activation/advancednavigation/key');
			
			Mage::helper('gomage_navigation')->a($key);
			
	}
	
	public function setContinueShoppingUrl($event){
	    $session = Mage::getSingleton('checkout/session');	    
	    $url = $session->getContinueShoppingUrl();
	    $url = str_replace('ajax=1', '', $url);
	    $session->setContinueShoppingUrl($url);
	}

		
}