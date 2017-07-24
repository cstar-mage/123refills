<?php
class Mage_Uploadtool_Block_Adminhtml_Diamondinquiries extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        // The blockGroup must match the first half of how we call the block, and controller matches the second half
        // ie. foo_bar/adminhtml_baz
        $this->_blockGroup = 'uploadtool';
        $this->_controller = 'adminhtml_diamondinquiries';
        $this->_headerText = $this->__('Diamondinquiries');
        parent::__construct();
    }
}