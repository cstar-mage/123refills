<?php

class ProxiBlue_DynCatProd_Tools_InfoController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_forward('type');
    }

    public function typeAction()
    {
        Mage::register('grid_type', $this->getRequest()->getParam('view', 'rebuild'));
        $this->loadLayout();
        $this->renderLayout();
    }


    public function gridAction()
    {
        Mage::register('grid_type', $this->getRequest()->getParam('view', 'rebuild'));
        $this->loadLayout();
        $this->renderLayout();
    }

    public function massRemoveAction()
    {
        try {
            Mage::register('grid_type', $this->getRequest()->getParam('view', 'rebuild'));
            $ids = $this->getRequest()->getPost('ids', array());
            foreach ($ids as $id) {
                $model = Mage::getModel("configgen/config");
                $model->setId($id)->delete();
            }
            Mage::getSingleton("adminhtml/session")->addSuccess(
                Mage::helper("adminhtml")->__("Item(s) was successfully removed")
            );
        } catch (Exception $e) {
            Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }


}
