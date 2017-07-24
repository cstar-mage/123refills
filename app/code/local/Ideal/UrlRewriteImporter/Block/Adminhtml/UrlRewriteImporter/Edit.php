<?php 
class Ideal_UrlRewriteImporter_Block_Adminhtml_UrlRewriteImporter_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {
        $this->_objectId = 'id';
        $this->_controller = 'adminhtml_UrlRewriteImporter';
        $this->_blockGroup = 'ideal_urlrewriteimporter';

        parent::__construct();

        $this->_addButton('downloadcsv', array(
        		'label'     => Mage::helper('adminhtml')->__('Download Sample'),
        		'onclick'   => 'setLocation(\''.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'media/UrlRewriteImporter/sample.csv'.'\')',
        		'class'     => 'save',
        ), -100);
        
        $this->_updateButton('back', 'onclick', "setLocation('{$this->getUrl('*/urlrewrite/index')}')");
        $this->_removeButton('reset');
        
        
        
    }

    public function getHeaderText() {
        return 'Url Rewrite Import';
    }

}
