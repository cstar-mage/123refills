<?php

class Dolphin_Customcontactnew_Block_Adminhtml_Customcontactnew_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('customcontactnewGrid');
      $this->setDefaultSort('customcontact_id');
      $this->setDefaultDir('DESC');
      $this->setUseAjax(true);
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('customcontactnew/customcontactnew')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('customcontact_id', array(
          'header'    => Mage::helper('customcontactnew')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'customcontact_id',
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('customcontactnew')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));
      $this->addColumn('phone', array(
      		'header'    => Mage::helper('customcontactnew')->__('Phone'),
      		'align'     =>'left',
      		'index'     => 'phone',
      ));
      $this->addColumn('email', array(
      		'header'    => Mage::helper('customcontactnew')->__('Email'),
      		'align'     =>'left',
      		'index'     => 'email',
      ));
	    $this->addColumn('Appoint Date', array( 
      		'header'    => Mage::helper('customcontactnew')->__('Appointment Date'),
      		'align'     =>'left',
      		'index'     => 'appointmentdate',
      ));
	    $this->addColumn('Appoint Time', array(
      		'header'    => Mage::helper('customcontactnew')->__('Appointment Time'),
      		'align'     =>'left',
      		'index'     => 'appointmenttime',
      ));
    
     /* $this->addColumn('status', array(
          'header'    => Mage::helper('customcontactnew')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));
	  */
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('customcontactnew')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('customcontactnew')->__('Delete'),
                        'url'       => array('base'=> '*/*/delete'),
                        'field'     => 'id'
                    ),
                		array(
                				'caption'   => Mage::helper('customcontactnew')->__('Edit'),
                				'url'       => array('base'=> '*/*/edit'),
                				'field'     => 'id'
                		)
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('customcontactnew')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('customcontactnew')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('customcontact_id');
        $this->getMassactionBlock()->setFormFieldName('customcontactnew');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('customcontactnew')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('customcontactnew')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('customcontactnew/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('customcontactnew')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('customcontactnew')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }
    public function getGridUrl()
    {
    	return $this->getUrl('*/*/grid', array('_current'=>true));
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('id' => $row->getId()));
  }

}