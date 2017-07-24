<?php


class ProxiBlue_Dyncatprod_Block_Adminhtml_Tools_Info extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    public function __construct()
    {
        $this->_controller = 'adminhtml_tools_info';
        $this->_blockGroup = 'dyncatprod';
        $this->_headerText = Mage::helper('dyncatprod')->__('Manage List');

        parent::__construct();

        //the parent constructor assumes that you need an add button that goes to "/*/*/new" so it adds it. In this case, we dont.
        $this->removeButton('add');
    }

    protected function _prepareLayout()
    {
        $this->setChild(
            'grid',
            $this->getLayout()->createBlock(
                $this->_blockGroup . '/' . $this->_controller . '_grid',
                $this->_controller . '.grid'
            )->setSaveParametersInSession(true)
        );
        return $this;
    }
}