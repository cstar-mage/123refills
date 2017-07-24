<?php
/**
 * @copyright   Copyright (c) 2009-2012 Amasty (http://www.amasty.com)
 */    
class Amasty_Finder_Block_Adminhtml_Finder extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_finder';
        $this->_blockGroup = 'amfinder';
        $this->_headerText = Mage::helper('amfinder')->__('Parts Finders');
        $this->_addButtonLabel = Mage::helper('amfinder')->__('Add Finder');
        parent::__construct();
    }
}