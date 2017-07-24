<?php
class Ideal_Taskproduction_Block_Adminhtml_Taskproduction_Edit_Tab_Tickets extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldset = $form->addFieldset('taskproduction_form', array('legend'=>Mage::helper('taskproduction')->__('Task Production information')));

      /*$fieldset->addField('task_id', 'label', array(
          'label'     => Mage::helper('taskproduction')->__('Task Id'),
          'class'     => 'required-entry',
          'name'      => 'task_id',
          'style'   => "border:10px",
          'disabled' => false,
          'readonly' => true,
          'tabindex' => 1
        ));*/
      
      $fieldset->addField('task_title', 'label', array(
      		'label'     => Mage::helper('taskproduction')->__('Title'),
      		'class'     => 'required-entry',
      		'name'      => 'task_title',
      		'style'   => "border:10px",
      		'disabled' => false,
      		'readonly' => true,
      		'tabindex' => 1
      ));
      
      $ch = curl_init();
      // Disable SSL verification
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      // Will return the response, if false it print the response
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      curl_setopt($ch, CURLOPT_URL,'http://production.idealbrandmarketing.com/magento/task_status_list.php');
      // Execute
      $result=curl_exec($ch);
      // Closing
      curl_close($ch);
      //echo "<pre>"; print_r(json_decode($result, true)); echo "</pre>";
      
     $fieldset->addField('task_status', 'select', array(
      		'label'     => Mage::helper('taskproduction')->__('Status'),
      		'name'      => 'task_status',
      		'values' => json_decode($result, true),
      ));
      
      $fieldset->addField('task_flag', 'label', array(
      		'label'     => Mage::helper('taskproduction')->__('Flag'),
      		'class'     => 'required-entry',
      		'name'      => 'task_flag',
      		'style'   => "border:10px",
      		'disabled' => false,
      		'readonly' => true,
      		'tabindex' => 1
      ));
     
      $fieldset->addType('statussubmit', Mage::getConfig()->getBlockClassName('Ideal_Taskproduction_Block_Adminhtml_Taskproduction_Edit_Tab_Renderer_Statussubmit'));
      $fieldset->addField('statussubmit', 'statussubmit', array(
      		'name'      => 'statussubmit',
      ));
      
      $fieldset->addType('commentlist', Mage::getConfig()->getBlockClassName('Ideal_Taskproduction_Block_Adminhtml_Taskproduction_Edit_Tab_Renderer_Customtaskproduction'));
      $fieldset->addField('commentlist', 'commentlist', array(
      		'name'      => 'commentlist',
      ));
      
      if ( Mage::getSingleton('adminhtml/session')->getTaskproductionData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getTaskproductionData());
          Mage::getSingleton('adminhtml/session')->setTaskproductionData(null);
      } elseif ( Mage::registry('taskproduction_data') ) {
          $form->setValues(Mage::registry('taskproduction_data')->getData());
      }

      return parent::_prepareForm();
  }
}