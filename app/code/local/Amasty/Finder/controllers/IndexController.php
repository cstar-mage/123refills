<?php
/**
 * @copyright   Copyright (c) 2009-2012 Amasty (http://www.amasty.com)
 */
class Amasty_Finder_IndexController extends Mage_Core_Controller_Front_Action
{
	public function newsearchAction(){

		$id  = $this->getRequest()->getParam('finder_id1');
        $finder = Mage::getModel('amfinder/finder')->load($id);
        //print_r($finder);
		//$finder = Mage::getModel('amfinder/finder')->setId($id);	
   		$dropdowns = $this->getRequest()->getParam('finder');		
		/*echo "<pre>";
		print_r($dropdowns);
		echo "</pre>";*/
  		//exit;

        /*$products = Mage::getModel('amfinder/value')->getCollection()
            ->joinAllFor($finder);			*/
		/*$products = Mage::getModel('amfinder/value')->getCollection();            
		echo "<pre>";	
        print_r($products->getData());   
		echo "</pre>";*/
		/*$products1 = $this->setCollection($products);
		echo "<pre>";	
        print_r($products1);   
		echo "</pre>";*/
            
		/*$collection = Mage::getModel('amfinder/value')->getCollection();  
		echo "<pre>";
		print_r($collection->getData());
		echo "</pre>"; */
		/* echo "<pre>";
		print_r($dropdowns);  
		echo "<br>";
		echo $this->getRequest()->getParam('category_id');   */
		
		if ($dropdowns){
            $finder->saveFilter($dropdowns, $this->getRequest()->getParam('category_id'));							
        }
		//echo $this->getRequest()->getParam('category_id');
		//exit; 
		//return true;  		
	} 
    public function searchAction()
    {

		$id     = $this->getRequest()->getParam('finder_id');		
        $finder = Mage::getModel('amfinder/finder')->setId($id);
        
        $dropdowns = $this->getRequest()->getParam('finder');		
        if ($dropdowns){
            $finder->saveFilter($dropdowns, $this->getRequest()->getParam('category_id'));
	    }
       // exit;
        $backUrl = $this->getRequest()->getParam('back_url');
        $backUrl = $this->_getModifiedBackUrl($finder, $backUrl);
       
        if ($this->getRequest()->getParam('reset')){
            $finder->resetFilter();
            
            if (Mage::getStoreConfig('amfinder/general/reset_home')){
                $backUrl ='/'; 
            } else {
                $backUrl = $finder->removeGet($backUrl, 'find');
            }         
        }
			$this->getResponse()->setRedirect($backUrl);		
    }
    
    // AJAX action to show next dropdown
    public function optionsAction()
    {
        $parentId   = Mage::app()->getRequest()->getParam('parent_id');
        $dropdownId = Mage::app()->getRequest()->getParam('dropdown_id');
        $options    = array();
        
        if ($parentId && $dropdownId) {
            $dropdown = Mage::getModel('amfinder/dropdown')->load($dropdownId);
            $options  = $dropdown->getValues($parentId);
        }
        
        if (version_compare(Mage::getVersion(), '1.4.1.0') < 0) {
            $options = Zend_Json::encode($options);  
        }
        else{
            $options = Mage::helper('core')->jsonEncode($options);  
        }

        $this->getResponse()->setBody($options);
    }


    public function indexAction()
    {
        // init category
        $categoryId = (int) Mage::app()->getStore()->getRootCategoryId();
        if (!$categoryId) {
            $this->_forward('noRoute');
            return;
        }
        
        $category = Mage::getModel('catalog/category')
            ->setStoreId(Mage::app()->getStore()->getId())
            ->load($categoryId);

        Mage::register('current_category', $category);
        Mage::getSingleton('catalog/session')->setLastVisitedCategoryId($category->getId());

        // need to prepare layer params
        try {
            Mage::dispatchEvent('catalog_controller_category_init_after',
                array('category' => $category, 'controller_action' => $this));
        }
        catch (Mage_Core_Exception $e) {
            Mage::logException($e);
            return;
        }
        // observer can change value
        if (!$category->getId()){
            $this->_forward('noRoute');
            return;
        }

        $this->loadLayout();
        $this->checkAddRwdBlocks();
        $this->renderLayout();
    }
    
    /**
     * Replaces or add find parameter in the search results url
     *
     * @param Amasty_Finder_Model_Finder $finder
     * @param string $backUrl
     * @return string new 
     */
    protected function _getModifiedBackUrl($finder, $backUrl)
    {
        $path  = $backUrl;
        $query = array();
        
        if (strpos($backUrl, '?')){
            list($path, $query) = explode('?', $backUrl, 2);
            if ($query){
                $query = explode('&', $query); 
                $params = array();
                foreach ($query as $pair){
                    if (strpos($pair, '=')){
                        $pair = explode('=', $pair);
                        $params[$pair[0]] = $pair[1];
                    }  
                }
                $query = $params;  
            }
        }
        
        $query['find'] = $finder->createUrlParam();
        if (!$query['find'] || !Mage::getStoreConfig('amfinder/general/seo_urls')){
            $query['find'] = null;    
        }
        
        $query = http_build_query($query);
        $query = str_replace('%2F', '/', $query);
        if ($query){
            $query = '?' . $query;
        }
        
        $backUrl = $path . $query;
        
        return $backUrl;
    }

    /*add compatibility with rwd theme*/
    protected function checkAddRwdBlocks()
    {
        $package = Mage::getDesign()->getPackageName();
        if ($package != 'rwd' && $package != 'evolved') {
            return;
        }

        $productList = $this->getLayout()->getBlock('product_list');

        $nameAfter = $this->getLayout()->createBlock('core/text_list', 'product_list.name.after');
        $productList->setChild('name.after', $nameAfter);

        $after = $this->getLayout()->createBlock('core/text_list', 'product_list.after');
        $productList->setChild('after', $after);

        $nav = $this->getLayout()->getBlock('catalog.leftnav');
        $stateRenderers = $this->getLayout()->createBlock('core/text_list', 'catalog.leftnav.state.renderers');
        $nav->setChild('state_renderers', $stateRenderers);
    }  
}
