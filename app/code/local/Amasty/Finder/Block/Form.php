<?php
/**
 * @copyright   Copyright (c) 2009-2012 Amasty (http://www.amasty.com)
 */
class Amasty_Finder_Block_Form extends Mage_Core_Block_Template
{
    protected $_finderModel = null;
    protected $_parentDropdownId = 0;
    protected $_isApplied = false;

    /**
     * @return Amasty_Finder_Model_Finder
     */
    public function getFinder()
    {
        if (is_null($this->_finderModel)){
            $this->_finderModel = Mage::getModel('amfinder/finder')
                ->load($this->getId());

        }
        return $this->_finderModel;
    }

    public function getDropdownAttributes($dropdown)
    {
        $html = sprintf('name="finder[%s]" id="finder-%s--%s"',
            $dropdown->getId(), $this->getId(), $dropdown->getId());

        $parentValueId  = $this->getFinder()->getSavedValue($this->_parentDropdownId);
        $currentValueId = $this->getFinder()->getSavedValue($dropdown->getId());   
                  
        if ($this->_isHidden($dropdown) && (!$parentValueId) && (!$currentValueId))
            $html .= 'disabled="disabled"';

        return $html;
    }

    public function getDropdownValues($dropdown)
    {
        $values   = array();


        $parentValueId  = $this->getFinder()->getSavedValue($this->_parentDropdownId);
        $currentValueId = $this->getFinder()->getSavedValue($dropdown->getId());
        
        if ($this->_isHidden($dropdown) && (!$parentValueId) && (!$currentValueId)){
            return $values;
        }
        
        $values = $dropdown->getValues($parentValueId, $currentValueId);

        $this->_parentDropdownId = $dropdown->getId();

        
        return $values;
    }

    public function isButtonsVisible()
    {
        $cnt = count($this->getFinder()->getDropdowns());
        
        // we have just 1 dropdown. show thw button
        if (1 == $cnt){
            return true;
        }
        
        // at least one value is selected and we allow partial search
        if ($this->getFinder()->getSavedValue('current') && Mage::getStoreConfig('amfinder/general/partial_search')){
            return true;
        }
        
        // all values are selected.
        if (($this->getFinder()->getSavedValue('last'))){
            return true;
        }
        
        return false; 

    }

    public function getAjaxUrl()
    {
        $url = Mage::getUrl('amfinder/index/options');
        return $url;
    }
    
    public function getBackUrl()
    {
        //  no params   
        //  category type CMS -> amfinder / amshopby
        //  cms page including homepage -> amfinder / amshopby

        //  with params
        //  amfinder/amshopby page with params -> amfinder / amshopby amshopby with params
        //  normal category page with pagams -> the same category
        //  landing page -> the same landing page           
        
        $customUrl = Mage::getStoreConfig('amfinder/general/custom_category');
        if ($this->getFinder()->getCustomUrl()){
            $customUrl = $this->getFinder()->getCustomUrl();
        }
        
        if ($customUrl){
            $url = Mage::helper('core/url')->getCurrentUrl();
            // from some different url to custom url
            if (!strpos($url, $customUrl)){
                $url  = Mage::getUrl($customUrl);
            }
            // in other case just use the current url
            return $url; 
        }
        
    	$url = Mage::getUrl('amfinder');
    	if (Mage::helper('ambase')->isModuleActive('Amasty_Shopby')){
            $url = Mage::getBaseUrl() . Mage::getStoreConfig('amshopby/seo/key');
    	}        
        
    	//not category page
    	$category = Mage::registry('current_category');
    	if (!$category){
    	    return $url;
    	}

    	if ($category->getDisplayMode() == Mage_Catalog_Model_Category::DM_PAGE){
    	    return $url;
    	}
    	
    	$url = Mage::helper('core/url')->getCurrentUrl();
    	
    	return $url;
    }    
   
    public function getActionUrl()
    {
        $url = Mage::getUrl('amfinder/index/search');
        return $url;
    }

    protected function _isHidden($dropdown)
    {
        //it's not the first dropdown && value is not selected
        return ($dropdown->getPos() && !$this->getFinder()->getSavedValue($dropdown->getId()));
    }

    protected function _toHtml()
    {
        $this->apply();
        
        $id = $this->getId();
        if (!$id){
            return 'Please specify the Parts Finder ID';
        }

        $finder = $this->getFinder();
        if (!$finder->getId()){
            return 'Please specify an exiting Parts Finder ID';
        }

        return parent::_toHtml();
    }
    
    // we need this method to be able to use the finder in the layout updates
    public function apply()
    {
        if ($this->_isApplied) {
            return $this;
        }
        $this->_isApplied = true;

        $tpl = $this->getTemplate();
        if (!$tpl){
            $tpl = $this->getFinder()->getTemplate();
            if (!$tpl) {
                $tpl = 'vertical';
            }
            $this->setTemplate('amfinder/' . $tpl . '.phtml');
        }
        
        $finder = $this->getFinder();
        $urlParam = $this->getRequest()->getParam('find');
        
        // XSS disabling
        $filter = array("<", ">");
        $urlParam = str_replace ($filter, "|", $urlParam);
        $urlParam = htmlspecialchars($urlParam);
        
        if ($urlParam){
            $urlParam = $finder->parseUrlParam($urlParam);
            $current  = $finder->getSavedValue('current');
                    
            if ($urlParam && ($current != $urlParam)){ // url has higher priority than session
                $dropdowns = $finder->getDropdownsByCurrent($urlParam);
                $finder->saveFilter($dropdowns);            
            }            
        }

        $finder->applyFilter();

        if (isset($_GET['debug'])){
            $session = Mage::getSingleton('catalog/session');
            $name    = 'amfinder_' . $this->getId();
            print_r($session->getData($name));
        }

        return $this;        
    }
    
    public function getCurrentCategoryId()
    {
        $category = Mage::registry('current_category');
        if ($category){
            return $category->getId();
        }  
              
        return 0;
    }
}
