<?php

class Ideal_Diamondrequest_Block_Adminhtml_Diamondrequest_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('diamondrequestGrid');
      $this->setDefaultSort('diamondrequest_id');
      $this->setDefaultDir('DESC');
      $this->setUseAjax(true);
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('diamondrequest/diamondrequest')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('diamondrequest_id', array(
          'header'    => Mage::helper('diamondrequest')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'diamondrequest_id'
      ));

      $this->addColumn('name', array(
          'header'    => Mage::helper('diamondrequest')->__('Name'),
          'align'     =>'left',
          'index'     => 'name'
      ));
      $this->addColumn('email', array(
      		'header'    => Mage::helper('diamondrequest')->__('Email'),
      		'align'     =>'left',
      		'index'     => 'email'
      ));
      $this->addColumn('phone', array(
      		'header'    => Mage::helper('diamondrequest')->__('Phone'),
      		'align'     =>'left',
      		'index'     => 'phone'
      ));
     /*  $this->addColumn('custom_date', array(
      		'header'    => Mage::helper('diamondrequest')->__('Date'),
      		'index'     => 'custom_date',
      		'type'        => 'date',
      		'renderer' => Dolphin_Customcontactnew_Block_Adminhtml_Customcontactnew_Grid_Renderer_Date,
      		'filter_index'=>'custom_date'
      		
      )); 
      $this->addColumn('phone', array(
      		'header'    => Mage::helper('diamondrequest')->__('Phone'),
      		'align'     =>'left',
      		'index'     => 'phone',
      ));*/
      $this->addColumn('need_it', array(
      		'header'    => Mage::helper('diamondrequest')->__('How soon do you need it'),
      		'align'     =>'left',
      		'index'     => 'need_it'
      ));
      
      $this->addColumn('best_time', array(
      		'header'    => Mage::helper('diamondrequest')->__('Time To contact'),
      		'align'     =>'left',
      		'index'     => 'best_time'
      ));
	  /* $this->addColumn('moreimportant', array(
      		'header'    => Mage::helper('diamondrequest')->__('More Important'),
      		'align'     =>'left',
      		'index'     => 'moreimportant',
      ));
      $this->addColumn('rings', array(
      		'header'    => Mage::helper('diamondrequest')->__('Interested Rings'),
      		'align'     =>'left',
      		'index'     => 'rings',
      )); */
      $this->addColumn('stonetype', array(
      		'header'    => Mage::helper('diamondrequest')->__('Stone Type'),
      		'align'     =>'left',
      		'index'     => 'stonetype'
      ));
      /* $this->addColumn('pricerange', array(
      		'header'    => Mage::helper('diamondrequest')->__('Price Range'),
      		'align'     =>'left',
      		'index'     => 'pricerange',
      ));
      $this->addColumn('metalcolors', array(
      		'header'    => Mage::helper('diamondrequest')->__('Metal Colors'),
      		'align'     =>'left',
      		'index'     => 'metalcolors',
      )); */

      $this->addColumn('status', array(
          'header'    => Mage::helper('diamondrequest')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          )
      ));
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('diamondrequest')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('diamondrequest')->__('Delete'),
                        'url'       => array('base'=> '*/*/delete'),
                        'field'     => 'id'
                    ),
                		array(
                				'caption'   => Mage::helper('diamondrequest')->__('Edit'),
                				'url'       => array('base'=> '*/*/edit'),
                				'field'     => 'id'
                		)
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('diamondrequest')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('diamondrequest')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('diamondrequest_id');
        $this->getMassactionBlock()->setFormFieldName('diamondrequest');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('diamondrequest')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('diamondrequest')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('diamondrequest/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('diamondrequest')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('diamondrequest')->__('Status'),
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