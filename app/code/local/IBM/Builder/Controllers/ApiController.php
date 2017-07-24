<?php

class IBM_Builder_ApiController extends IBM_Builder_Controllers_BaseController
{
    public function indexAction()
    {
        $method = $this->getRequest()->getParam('method');
        $option = $this->getRequest()->getParam('option');

        $response = array();

        if (empty($method)) {
            $response['error'] = true;
            $response['message'] = 'Method name is empty';
        } else {
            $response = Mage::getModel('IBMBuilder/APIManager')->executeCommand($method, $option);
        }

        return $this->getResponse()->setBody(json_encode($response));
    }
}