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
	
	class GoMage_Navigation_Block_Layer_View extends Mage_Catalog_Block_Layer_View{
		
		public function getPopupStyle(){
			
			return (string) Mage::getStoreConfig('gomage_navigation/filter/popup_style');
			
		}
		
		public function getSliderType(){
			
			return (string) Mage::getStoreConfig('gomage_navigation/filter/slider_type');
			
		}
		
		public function getSliderStyle(){
			
			return (string) Mage::getStoreConfig('gomage_navigation/filter/slider_style');
			
		}
		
		public function getIconStyle(){
			
			return (string) Mage::getStoreConfig('gomage_navigation/filter/icon_style');
			
		}
		
		public function getButtonStyle(){
			
			return (string) Mage::getStoreConfig('gomage_navigation/filter/button_style');
			
		}
		
		public function getFilterStyle(){
			
			return (string) Mage::getStoreConfig('gomage_navigation/filter/style');
			
		}
		
		/**
    	 * Prepare child blocks
 	    *
 	    * @return Mage_Catalog_Block_Layer_View
	     */
	    protected function _prepareLayout(){
	    	
	    	$filterableAttributes = $this->_getFilterableAttributes();
	    	
	    	$collection = $this->getLayer()->getProductCollection();
	    	
	    	$base_select = array();
	    	
	    	if($this->getRequest()->getParam('price') || $this->getRequest()->getParam('price_from') || $this->getRequest()->getParam('price_to')){
	    	
	    	$base_select['price'] = clone $collection->getSelect();
	    	
	    	}
	    	
	    	if($this->getRequest()->getParam('cat')){
	    	
	    	$base_select['cat'] = clone $collection->getSelect();
	    	
	    	}
	    	
	        foreach ($filterableAttributes as $attribute) {
	            	            	            
	            $code = $attribute->getAttributeCode();
	            
	            if($this->getRequest()->getParam($code, false)){
					
					$base_select[$code] = clone $collection->getSelect();
					
				}
	            
	        }
	        
	        $this->getLayer()->setBaseSelect($base_select);

	        parent::_prepareLayout();
	        	        	        
	        if(Mage::helper('gomage_navigation')->isGomageNavigation()){
	        	
	            $styles_block = $this->getLayout()->createBlock('core/template', 'advancednavigation_styles')->setTemplate('gomage/navigation/header/styles.php');
	        
	            $this->getLayout()->getBlock('head')->setChild('advancednavigation_styles', $styles_block);
	            
	        	$this->getLayout()->getBlock('head')->addjs('gomage/advanced-navigation.js');
	        	$this->getLayout()->getBlock('head')->addCss('css/gomage/advanced-navigation.css');
	        	
	        	$this->unsetChild('layer_state');	        
	        }
	    }
	    
    	protected function _toHtml()
        {
            if(Mage::helper('gomage_navigation')->isGomageNavigation()){
                $this->setTemplate('gomage/navigation/layer/view.phtml');
            }
            return parent::_toHtml();
        }
	    
    	protected function _getCategoryFilter()
        {
            if(Mage::helper('gomage_navigation')->isGomageNavigation() && 
               Mage::getStoreConfigFlag('gomage_navigation/category/active')){
                if (!Mage::getStoreConfig('gomage_navigation/category/show_shopby'))            
                    return false;
                else
                    return parent::_getCategoryFilter();   
            }else{
                return parent::_getCategoryFilter();
            }                 
        }
	    
	    /**
	     * Retrieve active filters
	     *
	     * @return array
	     */
	    public function getActiveFilters()
	    {
	        $filters = $this->getLayer()->getState()->getFilters();
	        if (!is_array($filters)) {
	            $filters = array();
	        }
	        return $filters;
	    }
	    
	    public function getResetFirlerUrl($filter, $ajax = false)
	    {
	        $filterState = array();
	        	        
	        
	        foreach ($filter->getItems() as $item) {
	            
	            try
	            {
    	            $slider_item = in_array($item->getFilter()->getAttributeModel()->getFilterType(), 
                	                   array(GoMage_Navigation_Model_Layer::FILTER_TYPE_INPUT,
                	                         GoMage_Navigation_Model_Layer::FILTER_TYPE_SLIDER,
                    				    	 GoMage_Navigation_Model_Layer::FILTER_TYPE_SLIDER_INPUT,
                    				    	 GoMage_Navigation_Model_Layer::FILTER_TYPE_INPUT_SLIDER));
	            }	
	            catch(Exception $e){
    	            	
    	            $slider_item = false;
    	            	
    	        }			    	 
	            
	            if ($item->getActive() || $slider_item)
	            {
    	        	try{
    	        		
    		        	switch($item->getFilter()->getAttributeModel()->getFilterType()):

    		        		case (GoMage_Navigation_Model_Layer::FILTER_TYPE_INPUT):	
    				    	case (GoMage_Navigation_Model_Layer::FILTER_TYPE_SLIDER):
    				    	case (GoMage_Navigation_Model_Layer::FILTER_TYPE_SLIDER_INPUT):
    				    	case (GoMage_Navigation_Model_Layer::FILTER_TYPE_INPUT_SLIDER):    
    		        			
    				    	    $_from	= Mage::app()->getFrontController()->getRequest()->getParam($item->getFilter()->getRequestVar().'_from', $item->getFilter()->getMinValueInt());
   	                            $_to	= Mage::app()->getFrontController()->getRequest()->getParam($item->getFilter()->getRequestVar().'_to', $item->getFilter()->getMaxValueInt());
   	                            
   	                            if (($_from != $item->getFilter()->getMinValueInt()) || ($_to != $item->getFilter()->getMaxValueInt()))
   	                            {
   	                                if (!isset($filterState[$item->getFilter()->getRequestVar().'_from']))
   	                                {    				    	    
            		        			$filterState[$item->getFilter()->getRequestVar().'_from'] = null;
            		        			$filterState[$item->getFilter()->getRequestVar().'_to'] = null;
   	                                }
   	                            }
    		        			
    		        		break;
    		        		
    		        		default:
    		        	
    		            		$filterState[$item->getFilter()->getRequestVar()] = $item->getFilter()->getCleanValue();
    		            		
    		            	break;
    		            
    		            endswitch;
    		            
    	            }catch(Exception $e){
    	            	
    	            	$filterState[$item->getFilter()->getRequestVar()] = $item->getFilter()->getCleanValue();
    	            	
    	            }
	            }
	        }
	        
	        if (!count($filterState))
	           return false;
	        
	        $params['_nosid']       = true;   
	        $params['_current']     = true;
	        $params['_use_rewrite'] = true;
	        $params['_query']       = $filterState;
	        $params['_escape']      = true;
	        
	        $params['_query']['ajax'] = null;
		    
		    if($ajax){
		    	
		    	$params['_query']['ajax'] = true;
		    	
		    	
		    }
	        
	        return Mage::getUrl('*/*/*', $params);
	    }

	    /**
	     * Retrieve Clear Filters URL
	     *
	     * @return string
	     */
	    public function getClearUrl($ajax = false)
	    {
	        $filterState = array();
	        foreach ($this->getActiveFilters() as $item) {
	        	
	        	try{
	        		
		        	switch($item->getFilter()->getAttributeModel()->getFilterType()):
				    	
				    	case (GoMage_Navigation_Model_Layer::FILTER_TYPE_INPUT):
				    	case (GoMage_Navigation_Model_Layer::FILTER_TYPE_SLIDER):
				    	case (GoMage_Navigation_Model_Layer::FILTER_TYPE_SLIDER_INPUT):
				    	case (GoMage_Navigation_Model_Layer::FILTER_TYPE_INPUT_SLIDER):    
		        			
		        			$filterState[$item->getFilter()->getRequestVar().'_from'] = null;
		        			$filterState[$item->getFilter()->getRequestVar().'_to'] = null;
		        			
		        		break;
		        		
		        		default:
		        	
		            		$filterState[$item->getFilter()->getRequestVar()] = $item->getFilter()->getCleanValue();
		            		
		            	break;
		            
		            endswitch;
		            
	            }catch(Exception $e){
	            	
	            	$filterState[$item->getFilter()->getRequestVar()] = $item->getFilter()->getCleanValue();
	            	
	            }
	        }
	        $params['_nosid']       = true;
	        $params['_current']     = true;
	        $params['_use_rewrite'] = true;
	        $params['_query']       = $filterState;
	        $params['_escape']      = true;
	        
	        $params['_query']['ajax'] = null;
		    
		    if($ajax){
		    	
		    	$params['_query']['ajax'] = true;
		    	
		    	
		    }
	        
	        return Mage::getUrl('*/*/*', $params);
	    }
		
	}