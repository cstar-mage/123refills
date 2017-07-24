<?php

class Ideal_Selldiamond_Block_Adminhtml_Selldiamond_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('selldiamondGrid');
      $this->setDefaultSort('selldiamond_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('selldiamond/selldiamond')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
  	$this->addColumn('name', array(
  			'header'    => Mage::helper('selldiamond')->__('Name'),
  			'align'     =>'left',
  			'index'     => 'name',
  	)); 	
  	
  	$this->addColumn('email', array(
  			'header'    => Mage::helper('selldiamond')->__('Email'),
  			'align'     =>'left',
  			'index'     => 'email',
  	));
  	
  	$this->addColumn('phone1', array(
  			'header'    => Mage::helper('selldiamond')->__('Primary Phone Number'),
  			'align'     =>'left',
  			'index'     => 'phone1',
  	));
  	
  	$this->addColumn('contact_time', array(
  			'header'    => Mage::helper('selldiamond')->__('Best Time To Contact'),
  			'align'     =>'left',
  			'index'     => 'contact_time',
  	));
  	
  	$this->addColumn('shape', array(
  			'header'    => Mage::helper('selldiamond')->__('Shape'),
  			'align'     =>'left',
  			'index'     => 'shape',
  	));
  	
  	
  	$this->addColumn('created_time', array(
  			'header'    => Mage::helper('selldiamond')->__('created_time'),
  			'align'     =>'left',
  			'index'     => 'created_time',
  	)); 
  	
  	
      /*$this->addColumn('selldiamond_id', array(
          'header'    => Mage::helper('selldiamond')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'selldiamond_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('selldiamond')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('selldiamond')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  

      $this->addColumn('status', array(
          'header'    => Mage::helper('selldiamond')->__('Status'),
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
                'header'    =>  Mage::helper('selldiamond')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('selldiamond')->__('Edit'),
                        'url'       => array('base'=> 'edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		*/
		$this->addExportType('*/*/exportCsv', Mage::helper('selldiamond')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('selldiamond')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('selldiamond_id');
        $this->getMassactionBlock()->setFormFieldName('selldiamond');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('selldiamond')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('selldiamond')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('selldiamond/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('selldiamond')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('selldiamond')->__('Status'),
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
