<?php
class Mage_Uploadtool_Block_Adminhtml_Diamondinquiries_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
    	
        parent::__construct();
        // Set some defaults for our grid
        $this->setDefaultSort('id');
       // $this->setId('diamondinquiries_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }
     
    protected function _getCollectionClass()
    {
        // This is the model we are using for the grid
        return 'uploadtool/diamondinquiries_collection';
    }
     
    protected function _prepareCollection()
    {
        // Get and set our collection for the grid
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
         
        return parent::_prepareCollection();
    }
     
    protected function _prepareColumns()
    {
        // Add the columns that should appear in the grid

        $this->addColumn('id', array(
                'header'=> $this->__('ID'),
                'align' =>'right',
                'width' => '50px',
                'index' => 'id'
        ));
         
        $this->addColumn('firstname', array(
                'header'=> $this->__('Name'),
                'index' => 'firstname'
        ));

        $this->addColumn('comment', array(
        		'header'    => Mage::helper('uploadtool')->__('Comment'),
        		'align'     =>'left',
        		'index'     => 'comment',
        ));
        
         $this->addColumn('vendor', array(
        		'header'    => Mage::helper('uploadtool')->__('Vendor'),
        		'align'     =>'left',
        		'index'     => 'vendor',
        ));
        
         $this->addColumnAfter('sku', array(
        		'header'    => Mage::helper('uploadtool')->__('Stock Number'),
        		'align'     =>'left',
        		'index'     => 'sku',
        ),'vendor');
        
        $this->addColumnAfter('created_time', array(
        		'header'    => Mage::helper('uploadtool')->__('Created Time'),
        		'align'     =>'left',
        		'index'     => 'created_time',
        ),'vendor');
        
        $this->addColumn('action',
        		array(
        				'header'    =>  Mage::helper('uploadtool')->__('Action'),
        				'width'     => '100',
        				'type'      => 'action',
        				'getter'    => 'getId',
        				'actions'   => array(
        						array(
        								'caption'   => Mage::helper('uploadtool')->__('View'),
        								'url'       => array('base'=> '*/*/edit'),
        								'field'     => 'id'
        						)
        				),
        				'filter'    => false,
        				'sortable'  => false,
        				'index'     => 'stores',
        				'is_system' => true,
        		));
        
       // $this->addExportType('*/*/exportCsv', Mage::helper('uploadtool')->__('CSV'));
        //$this->addExportType('*/*/exportXml', Mage::helper('uploadtool')->__('XML'));
        
        return parent::_prepareColumns();
    }
     
    protected function _prepareMassaction()
    {
    	$this->setMassactionIdField('id');
    	$this->getMassactionBlock()->setFormFieldName('diamondinquiries');
    
    	$this->getMassactionBlock()->addItem('delete', array(
    			'label'    => Mage::helper('uploadtool')->__('Delete'),
    			'url'      => $this->getUrl('*/*/massDelete'),
    			'confirm'  => Mage::helper('uploadtool')->__('Are you sure?')
    	));
    
    	//        $statuses = Mage::getSingleton('dolphincontact/status')->getOptionArray();
    	//
    	//        array_unshift($statuses, array('label'=>'', 'value'=>''));
    	//        $this->getMassactionBlock()->addItem('status', array(
    	//             'label'=> Mage::helper('dolphincontact')->__('Change status'),
    	//             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
    	//             'additional' => array(
    	//                    'visibility' => array(
    	//                         'name' => 'status',
    	//                         'type' => 'select',
    	//                         'class' => 'required-entry',
    	//                         'label' => Mage::helper('dolphincontact')->__('Status'),
    	//                         'values' => $statuses
    	//                     )
    	//             )
    	//        ));
    	return $this;
    }
    
    public function getRowUrl($row)
    {
        // This is where our row data will link to
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
}
