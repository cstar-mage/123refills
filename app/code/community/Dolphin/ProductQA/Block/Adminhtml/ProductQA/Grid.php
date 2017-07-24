<?php

class Dolphin_ProductQA_Block_Adminhtml_ProductQA_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('productqaGrid');
      $this->setDefaultSort('productqa_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {
      $collection = Mage::getModel('productqa/productqa')->getCollection();
      $this->setCollection($collection);
      return parent::_prepareCollection();
  }

  protected function _prepareColumns()
  {
      $this->addColumn('productqa_id', array(
          'header'    => Mage::helper('productqa')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'productqa_id',
      ));

      $this->addColumn('product_sku', array(
          'header'    => Mage::helper('productqa')->__('Product Sku'),
          'align'     =>'left',
          'index'     => 'product_sku',
      ));
      
      $this->addColumn('name', array(
      		'header'    => Mage::helper('productqa')->__('Name'),
      		'align'     =>'left',
      		'index'     => 'name',
      ));
      $this->addColumn('email', array(
      		'header'    => Mage::helper('productqa')->__('Email'),
      		'align'     =>'left',
      		'index'     => 'email',
      ));
      
      $this->addColumn('question', array(
      		'header'    => Mage::helper('productqa')->__('Question'),
      		'align'     =>'left',
      		'index'     => 'question',
      ));
      
      $this->addColumn('answer', array(
      		'header'    => Mage::helper('productqa')->__('Answer'),
      		'align'     =>'left',
      		'index'     => 'answer',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('productqa')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

    /*   $this->addColumn('status', array(
          'header'    => Mage::helper('productqa')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      )); */
	  
        $this->addColumn('action',
            array(
                'header'    =>  Mage::helper('productqa')->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('productqa')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('productqa')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('productqa')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('productqa_id');
        $this->getMassactionBlock()->setFormFieldName('productqa');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('productqa')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('productqa')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('productqa/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('productqa')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('productqa')->__('Status'),
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