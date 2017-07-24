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
 * Grid block for testimonials
 *
 * @category   Turnkeye
 * @package    Turnkeye_Testimonial
 * @author     Viacheslav Fedorenko <v.fedorenko@turnkeye.com>
 */
class Turnkeye_Testimonial_Block_Adminhtml_Testimonial_Grid extends Mage_Adminhtml_Block_Widget_Grid
{

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->setId('testimonialGrid');
        $this->setDefaultSort('testimonial_position');
        $this->setDefaultDir('ASC');
        $this->setSaveParametersInSession(true);
    }

    /**
     * Prepare grid collection object
     *
     * @return Turnkeye_Testimonial_Block_Adminhtml_Testimonial_Grid
     */
    protected function _prepareCollection()
    {
        $this->setCollection(Mage::getModel('turnkeye_testimonial/testimonial')->getCollection());
        return parent::_prepareCollection();
    }

    /**
     * Preparing colums for grid
     *
     * @return Turnkeye_Testimonial_Block_Adminhtml_Testimonial_Grid
     */
    protected function _prepareColumns()
    {
        $this->addColumn('testimonial_position', array(
            'header'    => Mage::helper('turnkeye_testimonial')->__('Position'),
            'align'     => 'right',
            'width'     => '50px',
            'index'     => 'testimonial_position',
            'type'      => 'number',
        ));

        $this->addColumn('testimonial_name', array(
            'header'    => Mage::helper('turnkeye_testimonial')->__('Name'),
            'align'     => 'left',
            'index'     => 'testimonial_name',
        ));

        $this->addColumn('testimonial_text', array(
            'header'    => Mage::helper('turnkeye_testimonial')->__('Text'),
            'align'     => 'left',
            'index'     => 'testimonial_text',
        ));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row)
    {
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }

}
