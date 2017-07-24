<?php

class Ideal_Brandmanager_Block_Adminhtml_Brandmanager_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('brandmanagerGrid');
      $this->setDefaultSort('brandmanager_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('brandmanager/brandmanager')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('brandmanager_id', array(
          'header'    => Mage::helper('brandmanager')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'brandmanager_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('brandmanager')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));
	  
	   $this->addColumn('sortno', array(
          'header'    => Mage::helper('brandmanager')->__('Sort NO'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'sortno',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('brandmanager')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

      $this->addColumn('status', array(
          'header'    => Mage::helper('brandmanager')->__('Status'),
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
                'header'    =>  Mage::helper('brandmanager')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('brandmanager')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('brandmanager')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('brandmanager')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('brandmanager_id');
        $this->getMassactionBlock()->setFormFieldName('brandmanager');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('brandmanager')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('brandmanager')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('brandmanager/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('brandmanager')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('brandmanager')->__('Status'),
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