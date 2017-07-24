<?php 
class Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Tab_Aboutus extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
      $form = new Varien_Data_Form();
      $this->setForm($form);
     
      $fieldset_aboutus = $form->addFieldset('evolved_homepage_aboutus', array('legend'=>Mage::helper('evolved')->__('About Page')));
      $fieldset_aboutus->addType('aboutus', Mage::getConfig()->getBlockClassName('Ideal_Evolved_Block_Adminhtml_Evolved_Edit_Renderer_Aboutus'));
      
      $fieldset_aboutus->addField('aboutus_element_style', 'select', array(
      		'label'     => Mage::helper('evolved')->__('Page Style:'),
      		'name'      => 'aboutus_element_style',
      		'options'   => array(
      				'' => Mage::helper('evolved')->__('Select Page Element Style'),
      				'aboutus_element_style_one_one_column' => Mage::helper('evolved')->__('1-column'),
      				'aboutus_element_style_two_two_column_with_50_by_50' => Mage::helper('evolved')->__('2-column_50-50'),
      				'aboutus_element_style_three_two_column_with_30_by_70' => Mage::helper('evolved')->__('2-column_30-70'),
      				'aboutus_element_style_four_two_column_with_70_by_30' => Mage::helper('evolved')->__('2-column_70-30'),
      		),
      		'onchange' => "selectaboutuselementstyle(this.value)",
      ))
      ->setAfterElementHtml("<div class='tooltip_element_main'></div>
      		<script type=\"text/javascript\">
	      		function selectaboutuselementstyle(style)
      			{
      				//alert(style);
      				jQuery('#evolved_homepage_aboutus .aboutusmaintable').css('display','none');
      		      	jQuery('#evolved_homepage_aboutus #' + style).css('display','block');
					 whatspopup(style);
      			}
      		</script>
      	");
      
      
      $fieldset_aboutus->addField('aboutus', 'aboutus', array(
      		'name'      => 'aboutus',
      ));
      Mage::getSingleton('core/session')->setBlockName('evolved_aboutus');
      if ( Mage::getSingleton('adminhtml/session')->getEvolvedData() )
      {
          $form->setValues(Mage::getSingleton('adminhtml/session')->getEvolvedData());
          Mage::getSingleton('adminhtml/session')->setEvolvedData(null);
      } elseif ( Mage::registry('evolved_data') ) {
          $form->setValues(Mage::registry('evolved_data'));
      }
      return parent::_prepareForm();
  }
}