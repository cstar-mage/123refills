<?php
/**
 * TurnkeyE Co.
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0).
 * It is available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you are unable to obtain it through the world-wide-web, please send
 * an email to info@turnkeye.com so we can send you a copy immediately.
 *
 * @category   Turnkeye
 * @package    Turnkeye_Testimonial
 * @copyright  Copyright (c) 2010-2012 TurnkeyE Co. (http://turnkeye.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Edit form block for testimonials
 *
 * @category   Turnkeye
 * @package    Turnkeye_Testimonial
 * @author     Viacheslav Fedorenko <v.fedorenko@turnkeye.com>
 */
class Turnkeye_Testimonial_Block_Adminhtml_Testimonial_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{

    /**
     * Preparing global layout
     *
     * You can redefine this method in child classes for changin layout
     *
     * @return Mage_Core_Block_Abstract
     */
    protected function _prepareLayout()
    {
        parent::_prepareLayout();
        if (Mage::getSingleton('cms/wysiwyg_config')->isEnabled()) {
            $this->getLayout()->getBlock('head')->setCanLoadTinyMce(true);
        }
    }

    /**
     * Prepare form before rendering HTML
     *
     * @return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {
        $form = new Varien_Data_Form(array(
            'id' => 'edit_form',
            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method' => 'post',
            'enctype' => 'multipart/form-data'
        ));

        $fieldset = $form->addFieldset('testimonial_form', array(
            'legend'	  => Mage::helper('turnkeye_testimonial')->__('Testimonial'),
            'class'		=> 'fieldset-wide',
            )
        );

        $fieldset->addField('testimonial_position', 'text', array(
            'name'      => 'testimonial_position',
            'label'     => Mage::helper('turnkeye_testimonial')->__('Position'),
            'style'     => 'width:100px !important',
        ));

        $fieldset->addField('testimonial_img', 'image', array(
            'name'      => 'testimonial_img',
            'label'     => Mage::helper('turnkeye_testimonial')->__('Image'),
        ));

        $fieldset->addField('testimonial_name', 'text', array(
            'name'      => 'testimonial_name',
            'label'     => Mage::helper('turnkeye_testimonial')->__('Name'),
            'class'     => 'required-entry',
            'required'  => true,
        ));

        $fieldset->addField('testimonial_text', 'editor', array(
            'name'      => 'testimonial_text',
            'label'     => Mage::helper('turnkeye_testimonial')->__('Text'),
            'title'     => Mage::helper('turnkeye_testimonial')->__('Text'),
            'style'     => 'width:100%;height:300px;',
            'required'  => true,
            'config'    => Mage::getSingleton('turnkeye_testimonial/wysiwyg_config')->getConfig()
        ));

        $fieldset->addField('testimonial_sidebar', 'select', array(
            'label'     => Mage::helper('turnkeye_testimonial')->__('Show in sidebox'),
            'name'      => 'testimonial_sidebar',
            'values'    => array(
                array(
                    'value'     => 1,
                    'label'     => Mage::helper('core')->__('Yes'),
                ),
                array(
                    'value'     => 0,
                    'label'     => Mage::helper('core')->__('No'),
                ),
            ),
        ));

        if (Mage::registry('turnkeye_testimonial')) {
            $form->setValues(Mage::registry('turnkeye_testimonial')->getData());
        }

        $form->setUseContainer(true);
        $this->setForm($form);
        return parent::_prepareForm();
    }

}
