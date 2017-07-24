<style>
.entry-edit .entry-edit-head h4
{
text-transform: uppercase;
}
</style>
<?php 
class Mage_Image2Product_Block_Adminhtml_Image2Product_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
      $fieldsetstepone = $form->addFieldset('Image2Product_form_stepone', array('legend'=>Mage::helper('Image2Product')->__('Step 1. Remove all images from any past uploads')));
      $fieldsetstepone->addType('stepone', Mage::getConfig()->getBlockClassName('Mage_Image2Product_Block_Adminhtml_Image2Product_Edit_Tab_Renderer_Stepone'));
      $fieldsetstepone->addField('stepone', 'stepone', array(
      		'name'      => 'stepone',
      ));
      
      
   /*   $fieldset = $form->addFieldset('Image2Product_form', array('legend'=>Mage::helper('Image2Product')->__('Step 2. Upload you zip file of images')));
      $fieldset->addField('zipfile', 'file', array(
          'label'     => Mage::helper('Image2Product')->__('Upload Images Zipped Package (.zip Format Only)'),
          'name'      => 'zipfile',
	  ));
     */
       
      $fieldsetsteptwo = $form->addFieldset('Image2Product_form1', array('legend'=>Mage::helper('Image2Product')->__('Step 2. Upload you zip file of images')));
      $fieldsetsteptwo->addType('steptwo', Mage::getConfig()->getBlockClassName('Mage_Image2Product_Block_Adminhtml_Image2Product_Edit_Tab_Renderer_Steptwo'));
      $fieldsetsteptwo->addField('steptwo', 'steptwo', array(
      		'name'      => 'steptwo',
      ));
      
      $fieldsetstepthree = $form->addFieldset('Image2Product_form_stepthree', array('legend'=>Mage::helper('Image2Product')->__('Step 3. Generate upload data for the images')));
      $fieldsetstepthree->addType('stepthree', Mage::getConfig()->getBlockClassName('Mage_Image2Product_Block_Adminhtml_Image2Product_Edit_Tab_Renderer_Stepthree'));
      $fieldsetstepthree->addField('stepthree', 'stepthree', array(
      		'name'      => 'stepthree',
      ));
      
      $fieldsetstepfour = $form->addFieldset('Image2Product_form_stepfour', array('legend'=>Mage::helper('Image2Product')->__('Step 4. Process the data and images.')));
      $fieldsetstepfour->addType('stepfour', Mage::getConfig()->getBlockClassName('Mage_Image2Product_Block_Adminhtml_Image2Product_Edit_Tab_Renderer_Stepfour'));
      $fieldsetstepfour->addField('stepfour', 'stepfour', array(
      		'name'      => 'stepfour',
      ));

     if ( Mage::getSingleton('adminhtml/session')->getImage2ProductData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getImage2ProductData());
          Mage::getSingleton('adminhtml/session')->setImage2ProductData(null);
      } elseif ( Mage::registry('Image2Product_data') ) {
          $form->setValues(Mage::registry('Image2Product_data')->getData());
      }
      return parent::_prepareForm();
  }
}
?>