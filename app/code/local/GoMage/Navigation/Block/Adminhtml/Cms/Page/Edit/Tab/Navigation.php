<?php
 /**
 * GoMage Advanced Navigation Extension
 *
 * @category     Extension
 * @copyright    Copyright (c) 2010-2011 GoMage (http://www.gomage.com)
 * @author       GoMage
 * @license      http://www.gomage.com/license-agreement/  Single domain license
 * @terms of use http://www.gomage.com/terms-of-use
 * @version      Release: 2.1
 * @since        Class available since Release 1.0
 */

class GoMage_Navigation_Block_Adminhtml_Cms_Page_Edit_Tab_Navigation 
       extends Mage_Adminhtml_Block_Widget_Form
       implements Mage_Adminhtml_Block_Widget_Tab_Interface   
{
    
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;
    
    public function __construct()
    {
        parent::__construct();
        $this->setShowGlobalIcon(true);
    }
            
    protected function _prepareForm() 
    {
        if ($this->_isAllowedAction('save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        $form = new Varien_Data_Form();

        $form->setHtmlIdPrefix('page_');

        $model = Mage::registry('cms_page');

        $navigationFieldset = $form->addFieldset('navigation_fieldset', array(
            'legend' => Mage::helper('gomage_navigation')->__('Advanced Navigation'),
            'class'  => 'fieldset-wide',
            'disabled'  => $isElementDisabled
        ));

        $navigationFieldset->addField('navigation_left_column', 'select', array(
            'label'     => Mage::helper('gomage_navigation')->__('Show in Left Column'),
            'title'     => Mage::helper('gomage_navigation')->__('Show in Left Column'),
            'name'      => 'navigation_left_column',            
            'options'   => $this->getAvailableNavigationStatuses(),
            'disabled'  => $isElementDisabled,
        ));
        
        $navigationFieldset->addField('navigation_right_column', 'select', array(
            'label'     => Mage::helper('gomage_navigation')->__('Show in Right Column'),
            'title'     => Mage::helper('gomage_navigation')->__('Show in Right Column'),
            'name'      => 'navigation_right_column',            
            'options'   => $this->getAvailableNavigationStatuses(),
            'disabled'  => $isElementDisabled,
        ));
        
        Mage::dispatchEvent('adminhtml_cms_page_edit_tab_navigation_prepare_form', array('form' => $form));

        $form->setValues($model->getData());

        $this->setForm($form);
        
        return parent::_prepareForm();
    }
    
    public function getAvailableNavigationStatuses()
    {
        $options = array(
            self::STATUS_DISABLED => Mage::helper('gomage_navigation')->__('No'),
        );
        
        $websites = Mage::helper('gomage_navigation')->getAvailavelWebsites();
        
        if(!empty($websites)){
        	$options[self::STATUS_ENABLED] = Mage::helper('gomage_navigation')->__('Yes');
        }
        
        $statuses = new Varien_Object($options);        

        return $statuses->getData();
    }
       
    public function getTabLabel()
    {
        return Mage::helper('gomage_navigation')->__('Advanced Navigation');
    }

    public function getTabTitle()
    {
        return Mage::helper('gomage_navigation')->__('Advanced Navigation');
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
