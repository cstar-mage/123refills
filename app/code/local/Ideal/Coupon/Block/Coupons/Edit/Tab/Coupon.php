<?php

class Ideal_Coupon_Block_Coupons_Edit_Tab_Coupon
    extends Mage_Adminhtml_Block_Widget_Form
    implements Mage_Adminhtml_Block_Widget_Tab_Interface
{

    public function getTabLabel()
    {
        return Mage::helper('salesrule')->__('Conditions');
    }

    public function getTabTitle()
    {
        return Mage::helper('salesrule')->__('Conditions');
    }

    public function canShowTab()
    {
        return true;
    }

    public function isHidden()
    {
        return false;
    }

    protected function _prepareForm()
    {
        $model = Mage::registry('idealcoupon_coupon');

        $form = new Varien_Data_Form();

        $fieldset = $form->addFieldset('conditions_fieldset', array(
            'legend'=>Mage::helper('IdealCoupon')->__('Apply the rule only if the following conditions are met (leave blank for all products)')
        ));

        $fieldset->addField('url', 'text', array(
            'name' => 'url',
            'label' => Mage::helper('IdealCoupon')->__('Url Variable'),
            'title' => Mage::helper('IdealCoupon')->__('Url Variable'),
        ));

        $form->setValues($model->getData());

        $fieldset->addField('sales_rule_id', 'hidden', array(
            'name' => 'sales_rule_id',
            'value' => Mage::registry('idealcoupon_coupon_id')
        ));


        $this->setForm($form);

        return parent::_prepareForm();
    }
}