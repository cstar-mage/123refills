<?php
class Ideal_Diamondsearch_Controller_Router extends Mage_Core_Controller_Varien_Router_Standard
{
    /**
     * Initialize Controller Router
     *
     * @param Varien_Event_Observer $observer
     */
    public function initControllerRouters($observer)
    {
        /* @var $front Mage_Core_Controller_Varien_Front */
        $front = $observer->getEvent()->getFront();
        $front->addRouter('diamondsearch', $this);
        //$front->addRouter('gemsearch', $this);
    }

    /**
     * Validate and Match Manufacturer Page and modify request
     *
     * @param Zend_Controller_Request_Http $request
     * @return bool
     */
    public function match(Zend_Controller_Request_Http $request)
    {
        if (!Mage::isInstalled()) {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect(Mage::getUrl('install'))
                ->sendResponse();
            exit;
        }
        $router = 'diamondsearch';
        $identifier = trim(str_replace('/diamondsearch/', '', $request->getPathInfo()), '/');

        $condition = new Varien_Object(
            array(
                'identifier' => $identifier,
                'continue'   => true
            )
        );
        $identifier = $condition->getIdentifier();
		
		if ($condition->getRedirectUrl()) {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect($condition->getRedirectUrl())
                ->sendResponse();
            $request->setDispatched(true);
            return true;
        }
        if (!$condition->getContinue()) {
            return false;
        }
        
		/* DEFAULT STARTS */
        $diamond=explode("-",$identifier);
        $stockKey= array_search('stock', $diamond);
        $cert= array_search('cert', $diamond);
        $diff=$cert-$stockKey;
        if($diff==2)
        {
			$key=$stockKey+1;
			$stocknum=$diamond[$key];
		}
		else
		{
			preg_match('/stock-(.*?)-cert/', $identifier, $match);
			$stocknum=trim($match[1]);
		}
		$stocknum = urldecode($stocknum);
		
		$allowedIdentifier = "diamondsearch";
		if( Mage::getStoreConfig("diamondsearch/general_settings/frontend_url") )
			$allowedIdentifier = Mage::getStoreConfig("diamondsearch/general_settings/frontend_url");
		
		if($stocknum == ""){
			if($identifier == $allowedIdentifier){
				$request->setModuleName('diamondsearch')
						->setControllerName('index')
						->setActionName('index');
				$request->setAlias(
						Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
						$router.'/'.$identifier
					);
				return true;
			}else return false;
		}
		
		$path = explode('/', trim($request->getPathInfo(), '/'));
		
		if($path[0] != $allowedIdentifier && $path[0] != "diamondsearch"){return false;}
		
		$diamondSearch = Mage::getModel('diamondsearch/diamondsearch')->getCollection(); 
        //$diamondSearch->addFieldToFilter('stock_number',array('eq' => $stocknum));
        $diamondSearch->addFieldToFilter('lotno',array('eq' => $stocknum));

        $diamondSearch->getSelect()->limit(1);
        foreach($diamondSearch as $diam)
        {
			$diamondOne=$diam->getData('id');
		}
        
        if($identifier && $diamond)
        {
			$request->setModuleName('diamondsearch')
					->setControllerName('index')
					->setActionName('view')
					->setParam('id', $diamondOne);
			$request->setAlias(
					Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
					$router.'/'.$identifier
				);
				return true;
		}		
		/* DEFAULT ENDS */



		/* STANDARD CODE
        if ($condition->getRedirectUrl()) {
            Mage::app()->getFrontController()->getResponse()
                ->setRedirect($condition->getRedirectUrl())
                ->sendResponse();
            $request->setDispatched(true);
            return true;
        }
        if (!$condition->getContinue()) {
            return false;
        }
        
        
        $manufacturer = Mage::getModel('diamondsearch/diamondsearch');
        $manufacturerId = $manufacturer->checkIdentifier($identifier, Mage::app()->getStore()->getId());
        if (trim($identifier) && $manufacturerId) {
            $request->setModuleName('diamondsearch')
                ->setControllerName('index')
                ->setActionName('view')
                ->setParam('manufacturer_id', $manufacturerId);
            $request->setAlias(
                Mage_Core_Model_Url_Rewrite::REWRITE_REQUEST_PATH_ALIAS,
                $router.'/'.$identifier
            );
            return true;
        }
        return false;
        
        //STANDARD CODE ENDS
        * 
        */
    }
    
}
