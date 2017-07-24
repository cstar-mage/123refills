<?php
class Ideal_Testing_Block_Adminhtml_Cms_Page_Edit_Tab_Testing 
       extends Mage_Adminhtml_Block_Widget_Form
       implements Mage_Adminhtml_Block_Widget_Tab_Interface   
{
        
    public function __construct()
    {
        parent::__construct();        
    }
            
    protected function _prepareForm() 
    {
       

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('page_');

        $model = Mage::registry('cms_page');

        $testingFieldset = $form->addFieldset('testing_fieldset', array(
            'legend' => Mage::helper('ideal_testing')->__('Custom Tab'),
            'class'  => 'fieldset-wide'            
        ));

        $testingFieldset->addField('cms_header_text', 'textarea', array(
            'label'     => Mage::helper('ideal_testing')->__('Header Text'),
            'title'     => Mage::helper('ideal_testing')->__('Header Text'),
            'name'      => 'cms_header_text'
        	'value'     => $model->getCmsHeaderText()
        ));
        
        Mage::dispatchEvent('adminhtml_cms_page_edit_tab_testing_prepare_form', array('form' => $form));

        $form->setValues($model->getData());

        $this->setForm($form);
        
        return parent::_prepareForm();
    }    
   
       
    public function getTabLabel()
    {
        return Mage::helper('ideal_testing')->__('Custom Tab');
    }

    public function getTabTitle()
    {
        return Mage::helper('ideal_testing')->__('Custom Tab');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }
    
    protected function _isAllowedAction($action)
    {
        return Mage::getSingleton('admin/session')->isAllowed('cms/page/' . $action);
    }
    
} 
?>
