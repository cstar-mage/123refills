<?php

class Gfe_SphinxSearch_TestController extends Mage_Adminhtml_Controller_Action
{
    public function preDispatch ()
    {
        Mage::app()->getRequest()->setInternallyForwarded();
        return parent::preDispatch();
    }

    protected function _isAllowed()
    {
        return true;
    }

    public function indexAction()
    {
        /** @var Gfe_SphinxSearch_Model_Shell $ssh */
        $ssh = Mage::getModel('sphinxsearch/Shell');

        $ssh->connect(array(
            'host' => '104.250.126.130',
            'user' => 'ibmhosts',
            'password' => 'yCu7qPP}mdDy'
        ));

        echo $ssh->execute('ls');
    }

    public function testAction()
    {
        echo $this->_request('runsphinxreindex');
    }

    protected function _request($command)
    {
        $httpClient = new Zend_Http_Client();
        $httpClient->setConfig(array('timeout' => 60000));

        Mage::register('custom_entry_point', true, true);

        $store  = Mage::app()->getStore(0);
        $url    = $store->getUrl('sphinxsearch/sphinx/'.$command, array('_query' => array('rand' => microtime(true))));

        $url = str_replace('/index.php', '', $url);

        $result = $httpClient->setUri($url)->request()->getBody();

        return $result;
    }
    
}