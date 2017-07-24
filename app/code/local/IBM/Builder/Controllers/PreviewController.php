<?php

class IBM_Builder_PreviewController extends IBM_Builder_Controllers_BaseController
{
    public function prepareAction()
    {
        $id = $this->getRequest()->getParam('id');
        $content = $this->getRequest()->getParam('content');

        /** @var IBM_Builder_Model_Page $temporaryPage */
        $temporaryPage = Mage::getModel('IBMBuilder/Page');

        $temporaryPage->preparePreviewPage($id, $content);
        return $this->getResponse()->setBody($content);
    }

    public function deleteAction()
    {
        /** @var IBM_Builder_Model_Page $temporaryPage */
        $temporaryPage = Mage::getModel('IBMBuilder/Page');
        $temporaryPage->delete();
    }
}