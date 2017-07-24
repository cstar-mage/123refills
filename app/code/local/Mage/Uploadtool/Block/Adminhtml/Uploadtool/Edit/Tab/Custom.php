<?php
 
class Mage_Uploadtool_Block_Adminhtml_Uploadtool_Edit_Tab_Custom extends Mage_Adminhtml_Block_Widget_Form
{
	public function _construct()
	{
		parent::_construct();
		$this->setTemplate('uploadtool/tab/custom.phtml');
	}
	
	public function getLastUpdate($owner) {
	
		try {
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
				
			$uploadtool_custom_vendor = Mage::getSingleton("core/resource")->getTableName('uploadtool_custom_vendor');
			
			$query = mysql_query("select * from `$uploadtool_custom_vendor` where `custom_vendor_name`='$owner' group by custom_vendor_name") or die(mysql_error());
			$fetch = mysql_fetch_array($query);
				
			return $fetch['last_updated'];
		}
		catch (Exception $e) {
			return $e->getMessage();
		}
	}
}