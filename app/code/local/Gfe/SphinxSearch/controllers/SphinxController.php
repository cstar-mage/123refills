<?php

class Gfe_SphinxSearch_SphinxController extends Mage_Adminhtml_Controller_Action
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

    public function runsphinxreindexAction()
    {
        Mage::app()->getResponse()->setBody(Mage::getModel('sphinxsearch/engine')->reindex());
    }

    public function startAction()
    {
        print_r(Mage::helper('sphinxsearch/sphinx')->_exec('searchd'));
    }

    public function stopAction()
    {
        print_r(Mage::helper('sphinxsearch/sphinx')->_exec('searchd --stop'));
    }

    public function testAction()
    {
        print_r(Mage::helper('sphinxsearch/sphinx')->_exec('sudo indexer --rotate --all'));
    }

    public function getAction()
    {
        print_r(Mage::helper('sphinxsearch/sphinx')->_exec('indexer fulltext'));
    }

    public function isSphinxFoundedAction()
    {
        $exec = $this->_exec($this->_searchdCommand.' --config /fake/fake/sphinx.conf');

        if (strpos($exec['data'], 'sphinx.conf') === false) {
            return false;
        }

        return true;
    }
}