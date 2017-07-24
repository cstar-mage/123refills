<?php 
class Mage_Uploadtool_Block_Adminhtml_Diamondinquiries_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init class
     */
    public function __construct()
    {  
        parent::__construct();
     
        $this->setId('mage_uploadtool_diamondinquiries_form');
        $this->setTitle($this->__('Diamondinquiries Information'));
    }  
     
    /**
     * Setup form fields for inserts/updates
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {  
		
      	$model = Mage::registry('uploadtool');
       //$model = Mage::getModel('uploadtool/diamondinquiries')->load(1);
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post'
        ));
     
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('checkout')->__('Diamondinquiries Information'),
            'class'     => 'fieldset-wide',
        ));
     
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'id' => 'id',
            ));
        }  
     
        $fieldset->addField('firstname', 'text', array(
            'name'      => 'firstname',
            'label'     => Mage::helper('uploadtool')->__('First Name'),
            'title'     => Mage::helper('uploadtool')->__('First Name'),
            'required'  => true,
        	'readonly' => true,
        ));
        
        $fieldset->addField('lastname', 'text', array(
        		'name'      => 'lastname',
        		'label'     => Mage::helper('uploadtool')->__('Last Name'),
        		'title'     => Mage::helper('uploadtool')->__('Last Name'),
        		'required'  => true,
        		'readonly' => true,
        ));
        
        $fieldset->addField('phone', 'text', array(
        		'name'      => 'phone',
        		'label'     => Mage::helper('uploadtool')->__('Phone no'),
        		'title'     => Mage::helper('uploadtool')->__('Phone no'),
        		'required'  => true,
        		'readonly' => true,
        ));
     
        $fieldset->addField('email', 'text', array(
        		'name'      => 'email',
        		'label'     => Mage::helper('uploadtool')->__('Email'),
        		'title'     => Mage::helper('uploadtool')->__('Email'),
        		'required'  => true,
        		'readonly' => true,
        ));
        
        
        $fieldset->addField('vendor', 'label', array(
        		'name'      => 'vendor',
        		'label'     => Mage::helper('uploadtool')->__('Vendor'),
        		'title'     => Mage::helper('uploadtool')->__('Vendor'),
        		'readonly' => true, 
        ));
        
        
        $fieldset->addField('sku', 'label', array(
        		'name'      => 'sku',
        		'label'     => Mage::helper('uploadtool')->__('Stock Number'),
        		'title'     => Mage::helper('uploadtool')->__('Stock Number'),
        		'readonly' => true,
        ));
        
        
        $fieldset->addField('comment', 'textarea', array(
        		'label'     => Mage::helper('uploadtool')->__('Comment'),
        		'class'     => 'required-entry',
        		'required'  => true,
        		'name'      => 'comment',
        		'readonly' => true,
        		'tabindex' => 1
        ));
        
        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
     
        return parent::_prepareForm();
    }  
}
