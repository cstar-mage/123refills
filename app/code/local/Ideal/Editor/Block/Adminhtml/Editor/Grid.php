<?php

class Ideal_Editor_Block_Adminhtml_Editor_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setId('editorGrid');
      $this->setDefaultSort('editor_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
     
  }

  protected function _prepareCollection()
  {
  	$collection = Mage::getModel('editor/editor')->getCollection();
    $this->setCollection($collection);
    return parent::_prepareCollection();
	
  }

  protected function _prepareColumns()
  {
      $this->addColumn('editor_id', array(
          'header'    => Mage::helper('editor')->__('ID'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'editor_id',
      ));

      $this->addColumn('title', array(
          'header'    => Mage::helper('editor')->__('Title'),
          'align'     =>'left',
          'index'     => 'title',
      ));

	  /*
      $this->addColumn('content', array(
			'header'    => Mage::helper('editor')->__('Item Content'),
			'width'     => '150px',
			'index'     => 'content',
      ));
	  */

//       $this->addColumn('status', array(
//           'header'    => Mage::helper('editor')->__('Status'),
//           'align'     => 'left',
//           'width'     => '80px',
//           'index'     => 'status',
//           'type'      => 'options',
//           'options'   => array(
//               1 => 'Enabled',
//               2 => 'Disabled',
//           ),
//       ));
	  
       
		
		$this->addExportType('*/*/exportCsv', Mage::helper('editor')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('editor')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('editor_id');
        $this->getMassactionBlock()->setFormFieldName('editor');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('editor')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('editor')->__('Are you sure?')
        ));

        $statuses = Mage::getSingleton('editor/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('editor')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('editor')->__('Status'),
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