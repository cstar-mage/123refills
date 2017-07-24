<?php
class Ideal_Diamondsearch_Model_Observer
{
    const DYNAMIC_FRONTNAMES = 'gem-search';

    public function addDynamicFrontnames(Varien_Event_Observer $observer)
    {
        //get front controller
        $front = $observer->getEvent()->getFront();

        //grab request object and standard router
        $request = $front->getRequest();
        $standardRouter = $front->getRouter('standard');

        //grab module and route info using frontname;
        //note:a router with frontname 'mymodule' should be configured in your module
        $drouteName = $standardRouter->getRouteByFrontName('diamond-search');
        $dmoduleName = $standardRouter->getModuleByFrontName('diamond-search');

        //get dynamic frontnames from system config section
        /*
        $_dynamicFrontNames = explode(',',
            Mage::getStoreConfig()->getNode(self::DYNAMIC_FRONTNAMES)
        );
        */
		$_dynamicFrontNames = array("gem-search", "diamond-search");
        
        //add your dynamic frontnames to standard router
        foreach ($_dynamicFrontNames as $frontName) {
            $standardRouter->addModule($frontName, $dmoduleName, $drouteName);
        }

        return $this;
    }
}
