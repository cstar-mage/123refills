<?php
/**
 * Custom
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Custom
 * @package    Message_Contactform
 * @author     Custom Development Team
 * @copyright  Copyright (c) 2013 Custom. (http://www.magerevol.com)
 * @license    http://opensource.org/licenses/osl-3.0.php
 */
class Message_Contactform_Block_Adminhtml_Contactform_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('contactformGrid');
      $this->setDefaultSort('qc_id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('contactform/contactform')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('qc_id', array(
          'header'    => Mage::helper('contactform')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'qc_id',
      ));

      $this->addColumn('cname', array(
          'header'    => Mage::helper('contactform')->__('Name'),
          'align'     =>'left',
          'index'     => 'cname',
      ));
      
      $this->addColumn('email', array(
          'header'    => Mage::helper('contactform')->__('Email'),
          'align'     =>'left',
          'index'     => 'email',
      ));
      
      $this->addColumn('telephone', array(
          'header'    => Mage::helper('contactform')->__('Telephone'),
          'align'     =>'left',
          'index'     => 'telephone',
      ));
      
      $this->addColumn('comment', array(
          'header'    => Mage::helper('contactform')->__('Comment'),
          'align'     =>'left',
          'index'     => 'comment',
      ));
      
      $this->addColumn('created_time', array(
          'header'    => Mage::helper('contactform')->__('Time Created'),
          'align'     =>'left',
          'type'      => 'datetime',
          'index'     => 'created_time',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('contactform')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('contactform')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('contactform')->__('View'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('contactform')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('contactform')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('contactform_id');
        $this->getMassactionBlock()->setFormFieldName('contactform');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('contactform')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('contactform')->__('Are you sure?')
        ));

//        $statuses = Mage::getSingleton('contactform/status')->getOptionArray();
//
//        array_unshift($statuses, array('label'=>'', 'value'=>''));
//        $this->getMassactionBlock()->addItem('status', array(
//             'label'=> Mage::helper('contactform')->__('Change status'),
//             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
//             'additional' => array(
//                    'visibility' => array(
//                         'name' => 'status',
//                         'type' => 'select',
//                         'class' => 'required-entry',
//                         'label' => Mage::helper('contactform')->__('Status'),
//                         'values' => $statuses
//                     )
//             )
//        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}