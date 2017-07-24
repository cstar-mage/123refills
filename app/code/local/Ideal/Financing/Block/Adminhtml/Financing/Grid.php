<?php

class Ideal_Financing_Block_Adminhtml_Financing_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('financingGrid');
      $this->setDefaultSort('financing_id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('financing/financing')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('financing_id', array(
          'header'    => Mage::helper('financing')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'financing_id',
      ));

      $this->addColumn('firstname', array(
          'header'    => Mage::helper('financing')->__('First Name'),
          'align'     =>'left',
          'index'     => 'firstname',
      ));

	  
      $this->addColumn('lastname', array(
			'header'    => Mage::helper('financing')->__('Last Name'),
			'align'     =>'left',
			'index'     => 'lastname',
      ));
      
      $this->addColumn('email', array(
      		'header'    => Mage::helper('financing')->__('Email'),
      		'align'     =>'left',
      		'index'     => 'email',
      ));
      
      $this->addColumn('phone_no', array(
      		'header'    => Mage::helper('financing')->__('Phone Number'),
      		'align'     =>'left',
      		'index'     => 'phone_no',
      ));
      
      $this->addColumn('near_location', array(
      		'header'    => Mage::helper('financing')->__('Near Location'),
      		'align'     =>'left',
      		'index'     => 'near_location',
      ));
      
      $this->addColumn('comment', array(
      		'header'    => Mage::helper('financing')->__('Curious About'),
      		'align'     =>'left',
      		'index'     => 'comment',
      ));

      /*$this->addColumn('status', array(
          'header'    => Mage::helper('financing')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));*/
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('financing')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('financing')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('financing')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('financing')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('financing_id');
        $this->getMassactionBlock()->setFormFieldName('financing');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('financing')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('financing')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('financing/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('financing')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('financing')->__('Status'),
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