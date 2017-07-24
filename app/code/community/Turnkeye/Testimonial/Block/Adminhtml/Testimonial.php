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
 * Grid Container block for testimonials
 *
 * @category   Turnkeye
 * @package    Turnkeye_Testimonial
 * @author     Viacheslav Fedorenko <v.fedorenko@turnkeye.com>
 */
class Turnkeye_Testimonial_Block_Adminhtml_Testimonial extends Mage_Adminhtml_Block_Widget_Grid_Container
{

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->_controller = 'adminhtml_testimonial';
        $this->_blockGroup = 'turnkeye_testimonial';
        $this->_headerText = Mage::helper('turnkeye_testimonial')->__('Manage Testimonials');
        $this->_addButtonLabel = Mage::helper('turnkeye_testimonial')->__('Add New Testimonial');
        parent::__construct();
    }

}
