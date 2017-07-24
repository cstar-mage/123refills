<?php

class Ideal_Taskproduction_Block_Adminhtml_Taskproduction_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
  public function __construct()
  {
      parent::__construct();
      $this->setTemplate('taskproduction/grid.phtml');
      $this->setId('taskproductionGrid');
      $this->setDefaultSort('task_id');
      $this->setDefaultDir('ASC');
      $this->setSaveParametersInSession(true);
  }

  protected function _prepareCollection()
  {  	
	  	$paramsfield = Mage::helper('taskproduction')->getRequestParamsPage();
		
		//echo "<pre>"; print_r($sortfield); exit;
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the parameter
		curl_setopt($ch, CURLOPT_POSTFIELDS, $paramsfield);
		// Set the url
		curl_setopt($ch, CURLOPT_URL,'http://production.idealbrandmarketing.com/magento/tasklist.php');
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);
     
		$filter = $this->getParam('filter');
		$filter_data = Mage::helper('adminhtml')->prepareFilterString($filter);

		$con = implode(" && ",$gridparams);
        $collection_of_things = new Varien_Data_Collection();
     // echo "<pre>"; print_r(json_decode($result, true)); exit;
        if((!$filter_data['task_date_time']['from']) && (!$filter_data['task_date_time']['to']))
        {
        	unset($filter_data['task_date_time']);	
        }
        if((!$filter_data['task_update_time']['from']) && (!$filter_data['task_update_time']['to']))
        {
        	unset($filter_data['task_update_time']);
        }
       // echo "<pre>"; print_r($filter_data); echo "</pre>"; //exit;
		if(!$filter_data['task_status']) { $filter_data['task_status'] = 'Active'; }
		$countrow = 1;
		$totalrow = $limit;
		$demoobject = array();
      foreach (json_decode($result, true) as $data1) {

      	$data1['task_update_time'] = max(array($data1['up_task_date_time'], $data1['up_er_date'], $data1['up_note_date_created'], $data1['up_tt_date']));
      	//echo "<pre>"; print_r($data1); echo "</pre>"; continue;
      	if(count($filter_data))
      	{
      		$bool = false;
      		foreach($filter_data as $filter_datakey => $filter_datavalue)
      		{
      			if(strpos(strtolower($data1[$filter_datakey]), strtolower($filter_data[$filter_datakey])) === false )
      			{
      				if($filter_datakey == "task_date_time")
      				{
	      				$taskdatetime = date_format(date_create($data1['task_date_time']),"m/d/Y");
	      				if($filter_data['task_date_time']['from']) { $task_date_time_from = date_format(date_create($filter_data['task_date_time']['from']),'Y-m-d H:i:s'); }
	      				if($filter_data['task_date_time']['to']) { $task_date_time_to = date_format(date_create($filter_data['task_date_time']['to']),'Y-m-d H:i:s'); }	    
      				    if(($task_date_time_from) && ($task_date_time_to))
						{
							//echo "<br />".$data1['task_date_time']." => from => ".$task_date_time_from;
							if(($data1['task_date_time'] >= $task_date_time_from) && ($data1['task_date_time'] <= $task_date_time_to))
							{
								$bool = true;
							}
							else
							{
								$bool = false;
								break;
							}
						}
						else if((!$task_date_time_from) && ($task_date_time_to))
						{
							if($data1['task_date_time'] <= $task_date_time_to)
							{
								$bool = true;
							}
							else
							{
								$bool = false;
								break;
							}
						}
						else if(($task_date_time_from) && (!$task_date_time_to))
						{
							if($data1['task_date_time'] >= $from)
							{
								$bool = true;
							}
							else
							{
								$bool = false;
								break;
							}
						}
						else
						{
							$bool = false;
						}
      				}
      				else if($filter_datakey == "task_update_time")
      				{
      					$taskupdatetime = date_format(date_create($data1['task_update_time']),"m/d/Y");
      					
      					if($filter_data['task_update_time']['from']) { $task_update_time_from = date_format(date_create($filter_data['task_update_time']['from']),'Y-m-d H:i:s'); }
      					if($filter_data['task_update_time']['to']) { $task_update_time_to = date_format(date_create($filter_data['task_update_time']['to']),'Y-m-d H:i:s'); }      					      					
	      				if(($task_update_time_from) && ($task_update_time_to))
						{
							if(($data1['task_update_time'] >= $task_update_time_from) && ($data1['task_update_time'] <= $task_update_time_to))
							{
								$bool = true;
							}
							else
							{
								$bool = false;
								break;
							}
						}
						else if((!$task_update_time_from) && ($task_update_time_to))
						{
							if($data1['task_update_time'] <= $task_update_time_to)
							{
								$bool = true;
							}
							else
							{
								$bool = false;
								break;
							}
						}
						else if(($task_update_time_from) && (!$task_update_time_to))
						{
							if($data1['task_update_time'] >= $task_update_time_from)
							{
								$bool = true;
							}
							else
							{
								$bool = false;
								break;
							}
						}
						else
						{
							$bool = false;
							break;
						}
      				}
      				else 
      				{
      					$bool = false;
      					break;
      				}
      			}
      			else 
      			{
      				$bool = true;
      			}     			
      		}
      		if($bool == true) { 
      				$demoobject[] = new Varien_Object($data1);
      		}	
      	}
      	else 
      	{
      		$demoobject[] = new Varien_Object($data1);
      	}
      	
      }
      //exit;
      $collection_of_things_final = new Varien_Data_Collection();
	  foreach(array_chunk($demoobject,Mage::helper('taskproduction')->getPageLimit())[((Mage::helper('taskproduction')->getCurrentPage())-1)] as $demoobjectkey => $demoobjectvalue)
	  {
		  	$collection_of_things_final->addItem($demoobjectvalue);
	  }
      
   	 //echo "<br />###########################################</br />";   
     //echo "<pre>"; print_r(array_chunk($demoobject,2)); print_r($collection_of_things); exit;
      
	  //$this->setCollection($collection_of_things);
	  $this->setCollection($collection_of_things_final);
      //exit;
      
    return parent::_prepareCollection();
  }
  
  protected function _categoriesFilter($collection, $column)
  {
  	if (!$value = $column->getFilter()->getValue()) {
  		return $this;
  	}
  
  	return $this;
  }
  
  protected function _prepareColumns()
  {

	/* $attributes = Mage::getResourceModel('catalog/product_attribute_collection')
    ->getItems();
	foreach ($attributes as $attribute){
	    echo $attribute->getAttributecode();
	    echo " => ".$attribute->getFrontendLabel();
   		echo '<br>';
	}
exit; */
	  /* $this->addColumn('task_id_check', array(
  			'header_css_class' => 'a-center',
  			'header'    => Mage::helper('taskproduction')->__('Select'),
  			'type'      => 'checkbox',
  			'width' => '20px',
  			'field_name' => 'task_id_check[]',
  			'align'     => 'center',
  			'index' => 'task_id'
	  )); */
  	//echo $this->getUrl('*/*/grid', array('_current'=>true)); exit;
      $this->addColumn('task_id', array(
          'header'    => Mage::helper('taskproduction')->__('task_id'),
          'align'     =>'right',
          'width'     => '50px',
          'index'     => 'task_id',
    	  'filter_condition_callback' => array($this, '_categoriesFilter')
      ));

      $this->addColumn('task_title', array(
          'header'    => Mage::helper('taskproduction')->__('title'),
          'align'     =>'left',
          'index'     => 'task_title',
          'filter_condition_callback' => array($this, '_categoriesFilter')
      ));
      
      $this->addColumn('task_priority', array(
      		'header'    => Mage::helper('taskproduction')->__('Priority'),
      		'align'     =>'left',
      		'index'     => 'task_priority',
      		'filter_condition_callback' => array($this, '_categoriesFilter')
      ));
      
	$task_priority_arr = array('Active' => 'Active', 'Completed' => 'Completed');
      $this->addColumn('task_status', array(
      		'header'    => Mage::helper('taskproduction')->__('task_status'),
      		'align'     =>'left',
      		'index'     => 'task_status',
      		'type'  => 'options',
      		'options' => $task_priority_arr,
      		'filter_condition_callback' => array($this, '_categoriesFilter')
      ));
      
      $this->addColumn('task_date_time', array(
      		'header'    => Mage::helper('taskproduction')->__('Created'),
      		'align'     =>'left',
      		'index'     => 'task_date_time',
      		'type' => 'datetime',
      		'filter_condition_callback' => array($this, '_categoriesFilter')
      ));
      
      $this->addColumn('task_update_time', array(
      		'header'    => Mage::helper('taskproduction')->__('Updated'),
      		'align'     =>'left',
      		'index'     => 'task_update_time',
      		'type' => 'datetime',
      		'filter_condition_callback' => array($this, '_categoriesFilter')
      ));

      /*$this->addColumn('status', array(
          'header'    => Mage::helper('taskproduction')->__('Status'),
          'align'     => 'left',
          'width'     => '80px',
          'index'     => 'status',
          'type'      => 'options',
          'options'   => array(
              1 => 'Enabled',
              2 => 'Disabled',
          ),
      ));*/
	  
        $this->addColumn('action_edit',
            array(
                'header'    =>  Mage::helper('taskproduction')->__('Edit'),
                'width'     => '70',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('taskproduction')->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addColumn('action_delete',
            array(
                'header'    =>  Mage::helper('taskproduction')->__('Delete'),
                'width'     => '70',
                'type'      => 'action',
                'getter'    => 'getTaskId',
                'actions'   => array(
                    array(
                        'caption'   => Mage::helper('taskproduction')->__('Delete'),
                        'url'       => array('base'=> '*/*/delete'),
                        'field'     => 'task_id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'stores',
                'is_system' => true,
        ));
		
		$this->addExportType('*/*/exportCsv', Mage::helper('taskproduction')->__('CSV'));
		$this->addExportType('*/*/exportXml', Mage::helper('taskproduction')->__('XML'));
	  
      return parent::_prepareColumns();
  }

    protected function _prepareMassaction()
    {
    	return $this;
        $this->setMassactionIdField('task_id');
        $this->getMassactionBlock()->setUseSelectAll(false);
        $this->getMassactionBlock()->setFormFieldName('taskproduction');

        $this->getMassactionBlock()->addItem('delete', array(
             'label'    => Mage::helper('taskproduction')->__('Delete'),
             'url'      => $this->getUrl('*/*/massDelete'),
             'confirm'  => Mage::helper('taskproduction')->__('Are you sure?')
        ));
        return $this;
        $statuses = Mage::getSingleton('taskproduction/status')->getOptionArray();

        array_unshift($statuses, array('label'=>'', 'value'=>''));
        $this->getMassactionBlock()->addItem('status', array(
             'label'=> Mage::helper('taskproduction')->__('Change status'),
             'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
             'additional' => array(
                    'visibility' => array(
                         'name' => 'status',
                         'type' => 'select',
                         'class' => 'required-entry',
                         'label' => Mage::helper('taskproduction')->__('Status'),
                         'values' => $statuses
                     )
             )
        ));
        return $this;
    }
    
    public function getCsv()
    {
    	$csv = '';
    	$this->_isExport = true;
    	$this->_prepareGrid();
    
    	$data = array();
    	foreach ($this->_columns as $column) {
    		if (!$column->getIsSystem()) {
    			$data[] = '"'.$column->getExportHeader().'"';
    		}
    	}
    	$csv.= implode(',', $data)."\n";
    
    	foreach ($this->getCollection() as $item) {
    		$data = array();
    		foreach ($this->_columns as $column) {
    			if (!$column->getIsSystem()) {
    				$data[] = '"' . str_replace(array('"', '\\'), array('""', '\\\\'),
    						$column->getRowFieldExport($item)) . '"';
    			}
    		}
    		$csv.= implode(',', $data)."\n";
    	}
    
    	if ($this->getCountTotals())
    	{
    		$data = array();
    		foreach ($this->_columns as $column) {
    			if (!$column->getIsSystem()) {
    				$data[] = '"' . str_replace(array('"', '\\'), array('""', '\\\\'),
    						$column->getRowFieldExport($this->getTotals())) . '"';
    			}
    		}
    		$csv.= implode(',', $data)."\n";
    	}
    
    	return $csv;
    }
    
    public function getXml()
    {
    	$this->_isExport = true;
    	$this->_prepareGrid();
    	
    	$indexes = array();
    	foreach ($this->_columns as $column) {
    		if (!$column->getIsSystem()) {
    			$indexes[] = $column->getIndex();
    		}
    	}
    	$xml = '<?xml version="1.0" encoding="UTF-8"?>';
    	$xml.= '<items>';
    	foreach ($this->getCollection() as $item) {
    		$xml.= $item->toXml($indexes);
    	}
    	if ($this->getCountTotals())
    	{
    		$xml.= $this->getTotals()->toXml($indexes);
    	}
    	$xml.= '</items>';
    	return $xml;
    }

  public function getRowUrl($row)
  {
      return $this->getUrl('*/*/edit', array('task_id' => $row->getTaskId()));
  }

}
