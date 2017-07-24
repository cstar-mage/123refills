<?php

class Mage_Eternity_Block_Adminhtml_Eternity_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    public function __construct()
    {
        parent::__construct();
                 
        $this->_objectId = 'id';
        $this->_blockGroup = 'eternity';
        $this->_controller = 'adminhtml_eternity';
		$this->_removeButton('reset');
        $this->_updateButton('save', 'label', Mage::helper('eternity')->__('Save Rules'));
    }
	  protected function _prepareLayout()
    {
		  return parent::_prepareLayout();
	}
    public function getHeaderText()
    {
		$write = Mage::getSingleton("core/resource")->getConnection("core_write");

		/*$magento_db 	= 	Mage::getStoreConfig('eternity/db_detail/db_database'); 
		$mdb_name 		= 	Mage::getStoreConfig('eternity/db_detail/db_name');
		$mdb_user 		= 	Mage::getStoreConfig('eternity/db_detail/db_username');
		$mdb_passwd 	= 	Mage::getStoreConfig('eternity/db_detail/db_userpassword');
		$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);
		
		if (!$magento_connection)
		{
			die('Unable to connect to the database');
		}
		@mysql_select_db($mdb_name, $magento_connection) or die ("Database not found.");
		$Result = mysql_query("SELECT UPDATE_TIME FROM information_schema.tables WHERE  TABLE_SCHEMA = '".$mdb_name."' AND TABLE_NAME = 'diamonds_inventory'");
		$update = mysql_fetch_array($Result);
		
		return Mage::helper('eternity')->__('Add Item')."<span style='font-size:12px; margin-left:20px; color:#2F2F2F;'>".Mage::helper('eternity')->__('Last Updated:') . "&nbsp;<basefont>" . $update['UPDATE_TIME'] . "</basefont></span>";*/

        /*if( Mage::registry('eternity_data') && Mage::registry('eternity_data')->getId() ) {
            return Mage::helper('eternity')->__("Edit Item '%s'", $this->htmlEscape(Mage::registry('eternity_data')->getTitle()));
        } else {
            return Mage::helper('eternity')->__('Add Item');
        } */
    }
}