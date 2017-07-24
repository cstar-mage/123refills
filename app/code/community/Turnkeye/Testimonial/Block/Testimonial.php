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
 * Frontend block for testimonials
 *
 * @method Turnkeye_Testimonial_Model_Mysql4_Testimonial_Collection getTestimonials()
 *
 * @category   Turnkeye
 * @package    Turnkeye_Testimonial
 * @author     Viacheslav Fedorenko <v.fedorenko@turnkeye.com>
 */
class Turnkeye_Testimonial_Block_Testimonial extends Mage_Core_Block_Template
{

    /**
     * Before rendering html, but after trying to load cache
     *
     * @return Turnkeye_Testimonial_Block_Testimonial
     */
    protected function _beforeToHtml()
    {
        $this->_prepareCollection();
        return parent::_beforeToHtml();
    }

    /**
     * Prepare testimonial collection object
     *
     * @return Turnkeye_Testimonial_Block_Testimonial
     */
    protected function _prepareCollection()
    {
        /* @var $collection Turnkeye_Testimonial_Model_Mysql4_Testimonial_Collection */
        $collection = Mage::getModel("turnkeye_testimonial/testimonial")->getCollection();
        if ($this->getSidebar()){
            $collection->addFieldToFilter('testimonial_sidebar', '1');
        }

        $collection->setOrder('testimonial_position', 'ASC')
                   ->load();
        $this->setTestimonials($collection);
        return $this;
    }

}