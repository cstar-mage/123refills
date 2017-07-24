<?php

class IWD_OrderManager_Block_Adminhtml_Flags_Flags extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'iwd_ordermanager';
        $this->_controller = 'adminhtml_flags_flags';
        $this->_headerText = Mage::helper('iwd_ordermanager')->__('Manage Labels');
        $this->_addButtonLabel = $this->__('Add New Label');

        $this->_addButton('flags_types', array(
            'label'   => $this->__('Manage Columns'),
            'onclick' => 'setLocation(\'' . $this->getUrl('*/flags_types/index') .'\')',
            'class'   => 'go',
        ));

        parent::__construct();
    }
}
