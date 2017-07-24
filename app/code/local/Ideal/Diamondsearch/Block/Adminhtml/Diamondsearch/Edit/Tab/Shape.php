<?php

class Ideal_Diamondsearch_Block_Adminhtml_Diamondsearch_Edit_Tab_Shape extends Mage_Adminhtml_Block_Widget_Form
{
  protected function _prepareForm()
  {
  	

	  $form = new Varien_Data_Form();

      $this->setForm($form);

      $fieldset = $form->addFieldset('diamondsearch_form', array('legend'=>Mage::helper('diamondsearch')->__('Item information')));



		/*$fieldset->addField('shape_width', 'text',

        array(

			'label' => 'Width',

			'name' => 'shape_width',

			'note'	=> "in px",

			'value'	  => Mage::getStoreConfig("diamondsearch/shape_settings/shape_width")

		));

		

		$fieldset->addField('shape_height', 'text',

        array(

			'label' => 'Height',

			'name' => 'shape_height',

			'note'	=> "in px",

			'value'	  => Mage::getStoreConfig("diamondsearch/shape_settings/shape_height")

		));*/

		$shape_style = $fieldset->addField('shape_style', 'select', array(

          'label'     => Mage::helper('diamondsearch')->__('Shape Style'),

          'class'     => 'required-entry',

          'required'  => true,

          'name'      => 'shape_style',

          'onchange' => "changeShapeStyleSample(this.value)",

          'value'  => Mage::getStoreConfig("diamondsearch/shape_settings/shape_style"),

          'values' => array(

						'1' => array( 

										'value'=> 'outline',

										'label' => 'Outline'    

								   ),

						'2' => array( 

										'value'=> 'photo',

										'label' => 'Photo'

								   ),                                          

                           ),

          'note'	=> "Allowed file types: 'png'",

        ));

		if(Mage::getStoreConfig("diamondsearch/shape_settings/shape_style")){

			$imageUrl = $this->getSkinUrl("dsearch/shape_style").DS.Mage::getStoreConfig("diamondsearch/shape_settings/shape_style")."_sample.png?".rand(1,1000);

			$html = "<img id='shape_style_sample' src='$imageUrl' alt='shape_style'/>";

			$html .= '<script type="text/javascript">function changeShapeStyleSample(shape_style){';

			$html .= 	'var shape_style_url = "'.$this->getSkinUrl("dsearch/shape_style").DS.'";';

			$html .= 	'$("shape_style_sample").src = shape_style_url + shape_style + "_sample.png";';

			$html .= '}</script>';

     

			$shape_style->setAfterElementHtml($html);

		}



		/*$imageField = $fieldset->addField('shape_image', 'image', array(

			'label' => 'Shape Image',

            'required' => false,

            'name' => 'shape_image',

			'note'	=> "Allowed file types: 'jpg','jpeg','gif','png'",

			'value'	  => Mage::getStoreConfig("diamondsearch/shape_settings/shape_image")

        ));

		if(Mage::getStoreConfig("diamondsearch/shape_settings/shape_image")){

			$imageUrl = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_MEDIA).Mage::getStoreConfig("diamondsearch/shape_settings/shape_image")."?".rand(1,1000);

			$imageField->setAfterElementHtml(

				"<img src='$imageUrl' class=''/> "

			);

		}*/



	  $fieldset->addField('shape_available', 'text', array(

                'name'=>'shape_available',

				'label'     => Mage::helper('diamondsearch')->__('Shapes'),

                'class'=>'requried-entry',

                //'value'=>$product->getData('tier_price')

        ));

		$form->getElement('shape_available')->setRenderer(

            $this->getLayout()->createBlock('diamondsearch/adminhtml_diamondsearch_edit_tab_shape_shape')

        );

	 $fieldset->addField('specialshape_available', 'text', array(

                'name'=>'specialshape_available',

				'label'     => Mage::helper('diamondsearch')->__('Special Shapes'),

                'class'=>'requried-entry',

                //'value'=>$product->getData('tier_price')

        ));

		$form->getElement('specialshape_available')->setRenderer(

            $this->getLayout()->createBlock('diamondsearch/adminhtml_diamondsearch_edit_tab_shape_specialshape')

        );




      /*if ( Mage::getSingleton('adminhtml/session')->getDiamondsearchData() )

      {

          $form->setValues(Mage::getSingleton('adminhtml/session')->getDiamondsearchData());

          Mage::getSingleton('adminhtml/session')->setDiamondsearchData(null);

      } elseif ( Mage::registry('diamondsearch_data') ) {

          $form->setValues(Mage::registry('diamondsearch_data')->getData());

      }*/

      return parent::_prepareForm();

  }

}