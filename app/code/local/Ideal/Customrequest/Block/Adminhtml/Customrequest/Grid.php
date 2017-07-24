<?php

class Ideal_Customrequest_Block_Adminhtml_Customrequest_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('customrequestGrid');
      $this->setDefaultSort('customrequest_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('customrequest/customrequest')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('customrequest_id', array(
          'header'    => Mage::helper('customrequest')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'customrequest_id',
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('customrequest')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));

      
      $this->addColumn('phone', array(
      		'header'    => Mage::helper('customrequest')->__('Phone'),
      		'align'     =>'left',
      		'index'     => 'phone',
      ));
      
      $this->addColumn('email', array(
      		'header'    => Mage::helper('customrequest')->__('Email'),
      		'align'     =>'left',
      		'index'     => 'email',
      ));
      
     
	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('customrequest')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      $this->addColumn('status', array(
          'header'    => Mage::helper('customrequest')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('customrequest')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('customrequest')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('customrequest')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('customrequest')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('customrequest_id');
        $this->getMassactionBlock()->setFormFieldName('customrequest');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('customrequest')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('customrequest')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('customrequest/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('customrequest')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('customrequest')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}