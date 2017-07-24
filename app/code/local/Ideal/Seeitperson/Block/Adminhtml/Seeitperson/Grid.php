<?php

class Ideal_Seeitperson_Block_Adminhtml_Seeitperson_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('seeitpersonGrid');
      $this->setDefaultSort('seeitperson_id');
      $this->setDefaultDir('DESC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('seeitperson/seeitperson')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('seeitperson_id', array(
          'header'    => Mage::helper('seeitperson')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'seeitperson_id',
      ));
	
      $this->addColumn('psku', array(
      		'header'    => Mage::helper('seeitperson')->__('Product Sku'),
      		'align'     =>'left',
      		'index'     => 'psku',
      ));
      
      $this->addColumn('name', array(
          'header'    => Mage::helper('seeitperson')->__('Name'),
          'align'     =>'left',
          'index'     => 'name',
      ));
      
      $this->addColumn('email', array(
      		'header'    => Mage::helper('seeitperson')->__('Email'),
      		'align'     =>'left',
      		'index'     => 'email',
      ));
      
      $this->addColumn('zip_code', array(
      		'header'    => Mage::helper('seeitperson')->__('Zip Code'),
      		'align'     =>'left',
      		'index'     => 'zip_code',
      ));
      
      $this->addColumn('phone', array(
      		'header'    => Mage::helper('seeitperson')->__('Phone'),
      		'align'     =>'left',
      		'index'     => 'phone',
      ));
	   $this->addColumn('comments', array(
      		'header'    => Mage::helper('seeitperson')->__('Comments'),
      		'align'     =>'left',
      		'index'     => 'comments',
      ));     
     

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('seeitperson')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      /* $this->addColumn('status', array(
          'header'    => Mage::helper('seeitperson')->__('Status'),
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
                'header'    =>  Mage::helper('seeitperson')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('seeitperson')->__('Edit'),
                        'url'       => array('base'=> 'edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));*/
		
		$this->addExportType('*/*/exportCsv', Mage::helper('seeitperson')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('seeitperson')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('seeitperson_id');
        $this->getMassactionBlock()->setFormFieldName('seeitperson');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('seeitperson')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('seeitperson')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('seeitperson/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('seeitperson')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('seeitperson')->__('Status'),
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