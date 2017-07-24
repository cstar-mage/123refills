<?php

class IWD_OrderManager_Block_Adminhtml_Cataloginventory_Stock_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    protected function _prepareForm()
    {
        $stockId = $this->getRequest()->getParam('stock_id');
        $form = new Varien_Data_Form(array(
                'id' => 'edit_form',
                'action' => $this->getUrl('*/*/save', array('stock_id' => $stockId)),
                'method' => 'post'
            )
        );

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }
}