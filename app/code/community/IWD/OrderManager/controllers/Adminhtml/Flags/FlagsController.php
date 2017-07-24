<?php

/**
 * Class IWD_OrderManager_Adminhtml_Flags_FlagsController
 */
class IWD_OrderManager_Adminhtml_Flags_FlagsController extends Mage_Adminhtml_Controller_Action
{
    /**
     * @return void
     */
    public function indexAction()
    {
        $this->_initAction();

        $this->_addContent($this->getLayout()->createBlock('iwd_ordermanager/adminhtml_flags_flags'));
        $this->renderLayout();
    }

    /**
     * @return $this
     */
    protected function _initAction()
    {
        $this->loadLayout()
            ->_setActiveMenu('system')
            ->_title($this->__('IWD - Order Flags'));

        $this->_addBreadcrumb(
            Mage::helper('iwd_ordermanager')->__('Order Flags'),
            Mage::helper('iwd_ordermanager')->__('Order Flags')
        );

        return $this;
    }

    /**
     * @return void
     */
    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('iwd_ordermanager/adminhtml_flags_flags_grid')->toHtml()
        );
    }

    /**
     * @return void
     */
    public function newAction()
    {
        $this->_initAction();
        $this->prepareDefaultFormData();
        $this->flagsForm();
    }

    /**
     * @return void
     */
    public function editAction()
    {
        $this->_initAction();
        $this->prepareFormData();
        $this->flagsForm();
    }

    /**
     * @return void
     */
    protected function flagsForm()
    {
        $this->_addContent($this->getLayout()->createBlock('iwd_ordermanager/adminhtml_flags_flags_edit'))
            ->_addLeft($this->getLayout()->createBlock('iwd_ordermanager/adminhtml_flags_flags_edit_tabs'));

        $this->renderLayout();
    }

    /**
     * @return void
     */
    protected function prepareFormData()
    {
        $id = $this->getRequest()->getParam('id');
        $flag = Mage::getModel('iwd_ordermanager/flags_flags')->load($id);
        $flag->assignTypes();
        $flag->assignAutoApplyOptions();
        $flag->assignDisallowedAutoApplyOptions();

        if ($flag->getId()) {
            Mage::register('iwd_om_flags', $flag);
        }
    }

    /**
     * @return void
     */
    protected function prepareDefaultFormData()
    {
        $flag = Mage::getModel('iwd_ordermanager/flags_flags');
        $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
        if (!empty($data)) {
            $flag->setData($data);
        }

        Mage::register('iwd_om_flags', $flag);
    }

    /**
     * @return void
     */
    public function saveAction()
    {
        try {
            $flag = $this->saveFlag();
            $this->saveFlagsColumns($flag);
            $this->saveAutoApplyOptions($flag);

            Mage::getSingleton('adminhtml/session')->setFormData(false);
            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('iwd_ordermanager')->__('Flag was successfully saved')
            );

            if ($this->getRequest()->getParam('back')) {
                $this->_redirect('*/*/edit', array('id' => $flag->getId()));
                return;
            }
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log(
                $e->getMessage(),
                Mage::helper('iwd_ordermanager')->__('Flag was not saved.') . ' ' . $e->getMessage()
            );
        }

        $this->_redirect('*/*/');
    }

    /**
     * @return void
     */
    public function deleteAction()
    {
        try {
            $flag = $this->getFlagObj();
            $flag->delete();
            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('iwd_ordermanager')->__('Flag was successfully deleted')
            );
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log(
                $e->getMessage(),
                Mage::helper('iwd_ordermanager')->__('Flag was not deleted.') . ' ' . $e->getMessage()
            );
        }

        $this->_redirect('*/*/');
    }

    /**
     * @return void
     */
    public function massDeleteAction()
    {
        try {
            $ids = $this->getRequest()->getParam('id', array());
            foreach ($ids as $id) {
                $flag = Mage::getModel('iwd_ordermanager/flags_flags')->load($id);
                $flag->delete();
            }

            Mage::getSingleton('adminhtml/session')->addSuccess(
                Mage::helper('iwd_ordermanager')->__('Flag(s) was successfully deleted')
            );
        } catch (Exception $e) {
            IWD_OrderManager_Model_Logger::log(
                $e->getMessage(),
                Mage::helper('iwd_ordermanager')->__('Flag(s) was not deleted.') . ' ' . $e->getMessage()
            );
        }

        $this->_redirect('*/*/');
    }

    /**
     * @return IWD_OrderManager_Model_Flags_Flags
     */
    protected function saveFlag()
    {
        $name = $this->getRequest()->getParam('name', null);
        $iconImage = $this->getRequest()->getParam('icon_img', null);
        $iconFa = $this->getRequest()->getParam('icon_fa', null);
        $iconFaColor = $this->getRequest()->getParam('icon_fa_color', '#ffffff');
        $comment = $this->getRequest()->getParam('comment', '');
        $iconType = $this->getRequest()->getParam('radio_icon_type', 'image');

        $flag = $this->getFlagObj();
        $flag->setName($name)
            ->setIconType($iconType)
            ->setIconImage($iconImage)
            ->setIconFa($iconFa)
            ->setIconFaColor($iconFaColor)
            ->setComment($comment)
            ->saveFlagImage()
            ->save();

        return $flag;
    }

    /**
     * @param $flag IWD_OrderManager_Model_Flags_Flags
     */
    protected function saveAutoApplyOptions($flag)
    {
        $orderStatus = $this->getRequest()->getParam('order_status', array());
        $paymentMethod = $this->getRequest()->getParam('payment_method', array());
        $shippingMethod = $this->getRequest()->getParam('shipping_method', array());
        $flag->saveAutoApplyOrderStatuses($orderStatus);
        $flag->saveAutoApplyPaymentMethods($paymentMethod);
        $flag->saveAutoApplyShippingMethods($shippingMethod);
    }

    /**
     * @param $flag IWD_OrderManager_Model_Flags_Flags
     */
    protected function saveFlagsColumns($flag)
    {
        $types = $this->getRequest()->getParam('types', array());
        $flag->saveFlagColumnsRelation($types);
    }

    /**
     * @return IWD_OrderManager_Model_Flags_Flags
     */
    protected function getFlagObj()
    {
        $id = $this->getRequest()->getParam('id', null);
        $flag = Mage::getModel('iwd_ordermanager/flags_flags');
        if ($id != null) {
            $flag->load($id);
        }

        return $flag;
    }

    /**
     * @return mixed
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('system/iwdall/iwd_ordermanager/iwd_flags');
    }
}
