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
 * Edit form block container for testimonials
 *
 * @category   Turnkeye
 * @package    Turnkeye_Testimonial
 * @author     Viacheslav Fedorenko <v.fedorenko@turnkeye.com>
 */
class Turnkeye_Testimonial_Block_Adminhtml_Testimonial_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();

        $this->_objectId = 'id';
        $this->_blockGroup = 'turnkeye_testimonial';
        $this->_controller = 'adminhtml_testimonial';

        $this->_updateButton('save', 'label', Mage::helper('turnkeye_testimonial')->__('Save Testimonial'));
        $this->_updateButton('delete', 'label', Mage::helper('turnkeye_testimonial')->__('Delete Testimonial'));

        if( $this->getRequest()->getParam($this->_objectId) ) {
            $model = Mage::getModel('turnkeye_testimonial/testimonial')->load($this->getRequest()->getParam($this->_objectId));
            Mage::register('turnkeye_testimonial', $model);
        }
    }

    /**
     * Get header text
     *
     * @return string
     */
    public function getHeaderText()
    {
        if( Mage::registry('turnkeye_testimonial') && Mage::registry('turnkeye_testimonial')->getId() ) {
            return Mage::helper('turnkeye_testimonial')->__('Edit Testimonial');
        } else {
            return Mage::helper('turnkeye_testimonial')->__('Add Testimonial');
        }
    }
}
