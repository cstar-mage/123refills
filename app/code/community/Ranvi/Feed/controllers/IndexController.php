<?php

class Ranvi_Feed_IndexController extends Mage_Core_Controller_Front_Action{
	
		public function indexAction(){
			
			$response = array('result'=>0);
			
			if($feed_id = $this->getRequest()->getParam('id')){
 				
	 			$feed = Mage::getModel('ranvi_feed/item')->load($feed_id);
	 			$start = intval($this->getRequest()->getParam('start'));
	 			$length = intval($this->getRequest()->getParam('length'));
	 			
	 			
	 			if($start >= 0 && $length >= 0){
	 				
	 				if($feed->getType() == 'csv'){
	 					
	 					$feed->writeTempFile($start, $length);
	 					
	 				}else{
	 					
	 					Mage::getModel('ranvi_feed/item_block_product', array('feed'=>$feed, 'content'=>''))->writeTempFile($start, $length);
	 					
	 				}
	 				
	 				$response['result'] = 1;
	 				
	 			}
	 		}
	 		
	 		$this->getResponse()->setBody(Zend_Json::encode($response));
			
		}
		
	}