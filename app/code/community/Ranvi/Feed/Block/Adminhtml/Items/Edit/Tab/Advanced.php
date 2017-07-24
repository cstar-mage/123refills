<?php

class Ranvi_Feed_Block_Adminhtml_Items_Edit_Tab_Advanced extends Mage_Adminhtml_Block_Widget_Form

{

	protected function _prepareForm()

    {

        

        $form = new Varien_Data_Form();

        

        if(Mage::registry('ranvi_feed')){

        	$item = Mage::registry('ranvi_feed');

        }else{

        	$item = Mage::getModel('ranvi_feed/item');

        }

        

        $this->setForm($form);

        $fieldset = $form->addFieldset('advanced', array('legend' => $this->__('File Creation Settings')));
        

        $field = $fieldset->addField('use_layer', 'select', array(

            'name'      => 'use_layer',

            'label'     => $this->__('Export Out of Stock Products'),

            'title'     => $this->__('Export Out of Stock Products'),

            'required'  => false,

            'values'	=> array(1=>$this->__('No'),0=>$this->__('Yes')),            

        	));                

        if(!$item->getId()){        

        	$field ->setValue('1');        

        }

                

        $field = $fieldset->addField('use_disabled', 'select', array(

            'name'      => 'use_disabled',

            'label'     => $this->__('Export Disabled Products'),

            'title'     => $this->__('Export Disabled Products'),

            'required'  => false,

            'values'	=> array(1=>$this->__('No'),0=>$this->__('Yes'))

        	));                

        if(!$item->getId()){        

        	$field ->setValue('1');        

        }

        $fieldset = $form->addFieldset('upload_settings', array('legend' => $this->__('CRON Settings')));

        $field = $fieldset->addField('upload_day', 'multiselect', array(

            'name'      => 'upload_day',

            'label'     => $this->__('Available Days'),

            'title'     => $this->__('Available Days'),

            'required'  => false,

            'values'    => array(

                array('label'=>$this->__('Sunday'), 'value'=>'sun'),

                array('label'=>$this->__('Monday'), 'value'=>'mon'),

                array('label'=>$this->__('Tuesday'), 'value'=>'tue'),

                array('label'=>$this->__('Wednesday'), 'value'=>'wed'),

                array('label'=>$this->__('Thursday'), 'value'=>'thu'),

                array('label'=>$this->__('Friday'), 'value'=>'fri'),

                array('label'=>$this->__('Saturday'), 'value'=>'sat'),

            )

        ));

        

        if(!$item->getId()){

            $field ->setValue('sun,mon,tue,wed,thu,fri,sat');

        }

        

        $hours = array();

        $locale = Mage::getSingleton('core/locale');

        for($i = 0;$i<24;$i++){

            $hours[] = array('label'=>sprintf('%02d:00',$i), 'value'=>date('H', mktime($i, 0, 0, 1, 1, 1970)+$locale->date()->getGmtOffset()));

        }

        
        $field = $fieldset->addField('upload_interval', 'select', array(

            'name'      => 'upload_interval',

            'label'     => $this->__('Interval, hours'),

            'title'     => $this->__('Interval, hours'),

            'required'  => false,

            'values'    => array(

                array('label'=>$this->__('every 5 mins'), 'value'=>50),

                array('label'=>$this->__('every 10 mins'), 'value'=>100),

                array('label'=>$this->__('every 15 mins'), 'value'=>150),

                array('label'=>$this->__('every 20 mins'), 'value'=>200),

                array('label'=>$this->__('every 30 mins'), 'value'=>300),

                array('label'=>$this->__('every 1 hour'), 'value'=>1),

                array('label'=>$this->__('every 3 hours'), 'value'=>3),

                array('label'=>$this->__('every 6 hours'), 'value'=>6),

                array('label'=>$this->__('every 12 hours'), 'value'=>12),

                array('label'=>$this->__('every 24 hours'), 'value'=>24),

            ),

            'class'     => 'ranvi-feed-validate-interval'

        ));

        if(!$item->getId()){

            $field ->setValue('24');

        }

       /* $field->setOnchange('ranvifeed_setinterval(this, \'upload_hour_to\')');

        $field = $field = $fieldset->addField('restart_cron', 'select', array(

            'name'      => 'restart_cron',

            'label'     => $this->__('Restart Cron, times'),

            'title'     => $this->__('Restart Cron, times'),

            'required'  => false,

            'values'    => array(               

                array('label'=>$this->__('1'), 'value'=>1),

                array('label'=>$this->__('2'), 'value'=>2),

                array('label'=>$this->__('3'), 'value'=>3),

                array('label'=>$this->__('4'), 'value'=>4),

                array('label'=>$this->__('5'), 'value'=>5),             

            )

        ));

        if(!$item->getId()){

            $field ->setValue('3');

        }*/

        if($item->getId()){

            $form->setValues($item->getData());

        }

        return parent::_prepareForm();

    }

}