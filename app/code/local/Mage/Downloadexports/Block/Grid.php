<?php

class Mage_Downloadexports_Block_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();
        $this->setId('downloadexports');
        $this->setDefaultSort('file_id');
        $this->setDefaultDir('desc');
        $this->setSaveParametersInSession(false);
        $this->setUseAjax(true);
        $this->setVarNameFilter('export_filter');
    }

    protected function _getStore()
    {
        $storeId = (int) $this->getRequest()->getParam('store', 0);
        return Mage::app()->getStore($storeId);
    }
    
    protected function _prepareCollection()
    {
        $store = $this->_getStore();
		$collection = Mage::getModel('varien/data_collection');
        		
		ob_start();
		$lines = array();
		$z = exec("ls -lht ".dirname(__FILE__)."/../../../../../../var/export", $lines);
		array_shift($lines);
		ob_end_clean();
		$files = array();
		foreach($lines as $k=>$line) {
			$fileModel = new Varien_Object();
			$matches = array();
			preg_match("/(.*) (.*) (.*) (.*) (.*) (.*) (.*)/", $line, $matches); 
			$fullpath = dirname(__FILE__)."/../../../../../../var/export/".$matches[7];
			$fileModel->setData('ctime', date('Y-m-d h:i:s', filectime($fullpath)));
			$fileModel->setData('file_id', $k);
			$fileModel->setData('size', round((filesize($fullpath)/1000),1).'kB');
			$fileModel->setData('name', $matches[7]);
			$collection->addItem($fileModel);
		}
				
        $this->setCollection($collection);

        parent::_prepareCollection();
        return $this;
    }

    protected function _addColumnFilterToCollection($column)
    {
        return parent::_addColumnFilterToCollection($column);
    }    
    
    protected function _prepareColumns()
    {
        $this->addColumn('file_id',
            array(
                'header'=> Mage::helper('catalog')->__('ID'),
                'width' => '20px',
                'type'  => 'number',
                'index' => 'file_id',
            	'filter' => false,
            	'sortable' => false,
        ));
        $this->addColumn('name',
            array(
                'header'=> Mage::helper('catalog')->__('Name'),
                'index' => 'name',
        ));

        $this->addColumn('ctime',
            array(
                'header'=> Mage::helper('catalog')->__('Created'),
                'width' => '160px',
                'index' => 'ctime',
        ));

        $this->addColumn('size',
            array(
                'header'=> Mage::helper('catalog')->__('Size (kB)'),
                'width' => '100px',
				'index'	=> 'size',
            	'sortable'=> false,
        ));
        $this->addColumn('action',
            array(
                'header'    => Mage::helper('catalog')->__('Action'),
                'width'     => '60px',
                'type'      => 'action',
                'getter'     => 'getName',
                'actions'   => array(
                    array(
                        'caption' => Mage::helper('catalog')->__('Delete'),
                        'url'     => array(
                            'base'=>'*/*/delete'                        ),
                        'field'   => 'name'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
        ));        
        return parent::_prepareColumns();
    }

    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('name');
        $this->getMassactionBlock()->setFormFieldName('downloadexports');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'=> Mage::helper('downloadexports')->__('Delete'),
             'url'  => $this->getUrl('*/*/massDelete'),
             'confirm' => Mage::helper('downloadexports')->__('Are you sure?')
        ));

        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('downloadexports')->__('Download'),
             'url'  => $this->getUrl('*/*/massDownload', array('_current'=>true))
        ));

        return $this;
    } 

    public function getGridUrl()
    {
        return $this->getUrl('*/*/grid', array('_current'=>true));
    }

    public function getRowUrl($row)
    {
        return "#";
    	return $this->getUrl('*/*/edit', array(
            'store'=>$this->getRequest()->getParam('store'),
            'id'=>$row->getId())
        );
    }
}