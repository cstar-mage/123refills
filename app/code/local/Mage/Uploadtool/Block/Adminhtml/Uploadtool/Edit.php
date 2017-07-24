<?php

class Mage_Uploadtool_Block_Adminhtml_Uploadtool_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'uploadtool';
        $this->_controller = 'adminhtml_uploadtool';
		$this->_removeButton('reset');
		$this->_removeButton('back');
        $this->_updateButton('save', 'label', Mage::helper('uploadtool')->__('Save'));
       
		/* $this->_addButton('get_new_list', array(
           'label'     => Mage::helper('adminhtml')->__('Get New List'),
            'onclick'   => 'setLocation(\''.$this->getUrl('uploadtool/adminhtml_uploadtool/getList', array('_current'=>true)).'\')',
            'class'     => 'go', 
        ), -100);
		
		$this->_addButton('update_diamonds', array(
           'label'     => Mage::helper('adminhtml')->__('Update Diamonds'),
            'onclick'   => 'setLocation(\''.$this->getUrl('uploadtool/adminhtml_uploadtool/updateDiamonds', array('_current'=>true)).'\')',
            'class'     => 'go', 
        ), -100);
		
		$this->_addButton('download', array(
           'label'     => Mage::helper('adminhtml')->__('Download CSV'),
            'onclick'   => 'setLocation(\''.Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB).'var/import/diamonds.csv'.'\')',
            'class'     => 'go', 
        ), -100); */
		
		/*
		$this->_addButton('restore_price_increase', array(
				'label'     => Mage::helper('adminhtml')->__('Restore Price Increase'),
				'onclick'   => 'setLocation(\''.$this->getUrl('uploadtool/adminhtml_uploadtool/restorePriceIncrease', array('_current'=>true)).'\')',
				'class'     => 'go',
		), -100); */
		
    }

    protected function _prepareLayout()
    {
		  return parent::_prepareLayout();
	}
	
    public function getHeaderText()
    {
		$resource = Mage::getConfig()->getNode('global/resources')->asArray();
		$magento_db = $resource['default_setup']['connection']['host'];
		$mdb_user = $resource['default_setup']['connection']['username'];
		$mdb_passwd = $resource['default_setup']['connection']['password'];
		$mdb_name = $resource['default_setup']['connection']['dbname'];
		$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);
		
		if (!$magento_connection)
		{
			die('Unable to connect to the database');
		}
		@mysql_select_db($mdb_name, $magento_connection) or die ("Database not found.");
		
		//echo "SELECT UPDATE_TIME FROM information_schema.tables WHERE  TABLE_SCHEMA = '".$mdb_name."' AND TABLE_NAME = 'uploadtool_diamonds_inventory'"; exit;

		$uploadtool_diamonds_inventory = Mage::getSingleton("core/resource")->getTableName('uploadtool_diamonds_inventory');
		
		
		
		$connection = Mage::getSingleton('core/resource')->getConnection('core_read');
		$sql        = "SELECT * FROM information_schema.tables WHERE  TABLE_SCHEMA = '".$mdb_name."' AND TABLE_NAME = '".$uploadtool_diamonds_inventory."'"; 
		$update       = $connection->fetchAll($sql);

		if($update[0]['ENGINE'] != 'MYISAM') {
			$connection->query("ALTER TABLE `".$uploadtool_diamonds_inventory."` ENGINE = MYISAM");
		}
		//echo "<pre>"; print_r($update);
		$lastUpdate = $update[0]['UPDATE_TIME'];
		if($lastUpdate == "") $lastUpdate = $update[0]['CREATE_TIME'];  
		
		
		
		return Mage::helper('uploadtool')->__('Diamond Manager')."<span style='font-size:12px; margin-left:20px; color:#2F2F2F;'>".Mage::helper('uploadtool')->__('Last Updated:') . "&nbsp;<basefont>" . $lastUpdate . "</basefont></span>";
    }
}
