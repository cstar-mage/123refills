<?php
 
class Mage_Stud_Adminhtml_StudController extends Mage_Adminhtml_Controller_action
{	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu("stud/items")
			->_addBreadcrumb(Mage::helper("adminhtml")->__("Items Manager"), Mage::helper("adminhtml")->__("Item Manager"));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("stud/stud")->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register("stud_data", $model);

			$this->loadLayout();
			$this->_setActiveMenu("stud/items");

			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Item Manager"), Mage::helper("adminhtml")->__("Item Manager"));
			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Item News"), Mage::helper("adminhtml")->__("Item News"));

			$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock("stud/adminhtml_stud_edit"))
				->_addLeft($this->getLayout()->createBlock("stud/adminhtml_stud_edit_tabs"));

			$this->renderLayout();
		} else {
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("stud")->__("Item does not exist"));
			$this->_redirect("*/*/");
		}
	}
 
	public function newAction() {
		$this->_forward("edit");
	}
 
	public function saveAction() {	
		try
		{
			$magento_db 	= 	Mage::getStoreConfig('stud/db_detail/db_database'); 
			$mdb_name 		= 	Mage::getStoreConfig('stud/db_detail/db_name');
			$mdb_user 		= 	Mage::getStoreConfig('stud/db_detail/db_username');
			$mdb_passwd 	= 	Mage::getStoreConfig('stud/db_detail/db_userpassword');
			$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);

			if (!$magento_connection)
			{
				die('Unable to connect to the Magento database');
				//exit;
			}
			@mysql_select_db($mdb_name, $magento_connection) or die ("Magento Database not found.");				
			//mysql_query("TRUNCATE TABLE stone_info");
			//phpinfo();
			//echo "<pre>"; print_r($_REQUEST); exit;
			
			mysql_query("TRUNCATE TABLE metal_price");
				
			$white_gold = $_REQUEST['metal_price_0'];
			$yellow_gold = $_REQUEST['metal_price_1'];
			$rose_gold = $_REQUEST['metal_price_2'];
			$eitk_white_gold = $_REQUEST['metal_price_3'];
			$eitk_yellow_gold = $_REQUEST['metal_price_4'];
			$eitk_rose_gold = $_REQUEST['metal_price_5'];
			$platinum = $_REQUEST['metal_price_6'];
			$query_insert_5 = "INSERT INTO metal_price SET white_gold = '".$white_gold."', yellow_gold = '".$yellow_gold."' , rose_gold='".$rose_gold."' , 18k_white_gold='".$eitk_white_gold."' , 18k_yellow_gold='".$eitk_yellow_gold."' , 18k_rose_gold='".$eitk_rose_gold."' , platinum='".$platinum."'";
			//echo $query_insert_2;
			//exit;
			mysql_query($query_insert_5);
			
			//print_r($_REQUEST);
			//exit;
			
			mysql_query("TRUNCATE TABLE stud_price");
				
			//print_r($_REQUEST);
			//exit;
			for($j = 0; $j<=$_REQUEST['roundcount']; $j++)
			{
				if(isset($_REQUEST['round_1-'.$j]) && ($_REQUEST['round_1-'.$j] != '')){
				$shape = $_REQUEST['round_5-'.$j];
				$carat = $_REQUEST['round_1-'.$j];
				/*$fsi1price = $_REQUEST['round_2-'.$j];
				$gvs2price = $_REQUEST['round_3-'.$j];
				$gsi1price = $_REQUEST['round_4-'.$j];
				$hsi2price = $_REQUEST['round_6-'.$j];
				$isi1price = $_REQUEST['round_7-'.$j];
				$jsi1price = $_REQUEST['round_8-'.$j];*/
				$fgvs = $_REQUEST['round_2-'.$j];
				$fgsi = $_REQUEST['round_3-'.$j];
				$fgind = $_REQUEST['round_4-'.$j];
				$hivs = $_REQUEST['round_6-'.$j];
				$hisi = $_REQUEST['round_7-'.$j];
				$hiind = $_REQUEST['round_8-'.$j];
				$jkvs = $_REQUEST['round_9-'.$j];
				$jksi = $_REQUEST['round_10-'.$j];
				$jkind = $_REQUEST['round_11-'.$j];
				
				$query_insert_2 = "INSERT INTO stud_price SET shape = '".$shape."', carat = '".$carat."' , fgvs='".$fgvs."' , fgsi='".$fgsi."' , fgind='".$fgind."', hivs='".$hivs."' , hisi='".$hisi."' , hiind='".$hiind."', jkvs='".$jkvs."' , jksi='".$jksi."' , jkind='".$jkind."'";
				//echo $query_insert_2;
				//exit;
				mysql_query($query_insert_2);
				}
			}
			
			for($k = 0; $k<=$_REQUEST['princesscount']; $k++)
			{			
				if(isset($_REQUEST['princess_1-'.$k]) && ($_REQUEST['princess_1-'.$k] != '')){
					$shape = $_REQUEST['princess_5-'.$k];
					$carat = $_REQUEST['princess_1-'.$k];
					/*$fsi1price = $_REQUEST['princess_2-'.$k];
					 $gvs2price = $_REQUEST['princess_3-'.$k];
					 $gsi1price = $_REQUEST['princess_4-'.$k];
					 $hsi2price = $_REQUEST['princess_6-'.$k];
					 $isi1price = $_REQUEST['princess_7-'.$k];
					$jsi1price = $_REQUEST['princess_8-'.$k];*/
					$fgvs = $_REQUEST['princess_2-'.$k];
					$fgsi = $_REQUEST['princess_3-'.$k];
					$fgind = $_REQUEST['princess_4-'.$k];
					$hivs = $_REQUEST['princess_6-'.$k];
					$hisi = $_REQUEST['princess_7-'.$k];
					$hiind = $_REQUEST['princess_8-'.$k];
					$jkvs = $_REQUEST['princess_9-'.$k];
					$jksi = $_REQUEST['princess_10-'.$k];
					$jkind = $_REQUEST['princess_11-'.$k];
				
					$query_insert_3p = "INSERT INTO stud_price SET shape = '".$shape."', carat = '".$carat."' , fgvs='".$fgvs."' , fgsi='".$fgsi."' , fgind='".$fgind."', hivs='".$hivs."' , hisi='".$hisi."' , hiind='".$hiind."', jkvs='".$jkvs."' , jksi='".$jksi."' , jkind='".$jkind."'";
					//echo $query_insert_2;
					//exit;
					mysql_query($query_insert_3p);
				}
			}
			
			//print_r($_REQUEST);
			//exit;
			
			for($i = 0; $i<=$_REQUEST['emeraldcount']; $i++)
			{
				if(isset($_REQUEST['emerald_1-'.$i]) && ($_REQUEST['emerald_1-'.$i] != '')){
					$shape = $_REQUEST['emerald_5-'.$i];
					$carat = $_REQUEST['emerald_1-'.$i];
					/*$fsi1price = $_REQUEST['emerald_2-'.$i];
					 $gvs2price = $_REQUEST['emerald_3-'.$i];
					 $gsi1price = $_REQUEST['emerald_4-'.$i];
					 $hsi2price = $_REQUEST['emerald_6-'.$i];
					 $isi1price = $_REQUEST['emerald_7-'.$i];
					$jsi1price = $_REQUEST['emerald_8-'.$i];*/
					$fgvs = $_REQUEST['emerald_2-'.$i];
					$fgsi = $_REQUEST['emerald_3-'.$i];
					$fgind = $_REQUEST['emerald_4-'.$i];
					$hivs = $_REQUEST['emerald_6-'.$i];
					$hisi = $_REQUEST['emerald_7-'.$i];
					$hiind = $_REQUEST['emerald_8-'.$i];
					$jkvs = $_REQUEST['emerald_9-'.$i];
					$jksi = $_REQUEST['emerald_10-'.$i];
					$jkind = $_REQUEST['emerald_11-'.$i];
				
					$query_insert_4 = "INSERT INTO stud_price SET shape = '".$shape."', carat = '".$carat."' , fgvs='".$fgvs."' , fgsi='".$fgsi."' , fgind='".$fgind."', hivs='".$hivs."' , hisi='".$hisi."' , hiind='".$hiind."', jkvs='".$jkvs."' , jksi='".$jksi."' , jkind='".$jkind."'";
					//echo $query_insert_2;
					//exit;
					mysql_query($query_insert_4);
				}
			}
			
			for($l = 0; $l<=$_REQUEST['asschercount']; $l++)
			{
				if(isset($_REQUEST['asscher_1-'.$l]) && ($_REQUEST['asscher_1-'.$l] != '')){
					$shape = $_REQUEST['asscher_5-'.$l];
					$carat = $_REQUEST['asscher_1-'.$l];
					/*$fsi1price = $_REQUEST['asscher_2-'.$l];
					 $gvs2price = $_REQUEST['asscher_3-'.$l];
					 $gsi1price = $_REQUEST['asscher_4-'.$l];
					 $hsi2price = $_REQUEST['asscher_6-'.$l];
					 $isi1price = $_REQUEST['asscher_7-'.$l];
					$jsi1price = $_REQUEST['asscher_8-'.$l];*/
					$fgvs = $_REQUEST['asscher_2-'.$l];
					$fgsi = $_REQUEST['asscher_3-'.$l];
					$fgind = $_REQUEST['asscher_4-'.$l];
					$hivs = $_REQUEST['asscher_6-'.$l];
					$hisi = $_REQUEST['asscher_7-'.$l];
					$hiind = $_REQUEST['asscher_8-'.$l];
					$jkvs = $_REQUEST['asscher_9-'.$l];
					$jksi = $_REQUEST['asscher_10-'.$l];
					$jkind = $_REQUEST['asscher_11-'.$l];
				
					$query_insert_5a = "INSERT INTO stud_price SET shape = '".$shape."', carat = '".$carat."' , fgvs='".$fgvs."' , fgsi='".$fgsi."' , fgind='".$fgind."', hivs='".$hivs."' , hisi='".$hisi."' , hiind='".$hiind."', jkvs='".$jkvs."' , jksi='".$jksi."' , jkind='".$jkind."'";
					//echo $query_insert_2;
					//exit;
					mysql_query($query_insert_5a);
				}
			}
			
			for($m = 0; $m<=$_REQUEST['cushioncount']; $m++)
			{
				if(isset($_REQUEST['cushion_1-'.$m]) && ($_REQUEST['cushion_1-'.$m] != '')){
					$shape = $_REQUEST['cushion_5-'.$m];
					$carat = $_REQUEST['cushion_1-'.$m];
					/*$fsi1price = $_REQUEST['cushion_2-'.$m];
					 $gvs2price = $_REQUEST['cushion_3-'.$m];
					 $gsi1price = $_REQUEST['cushion_4-'.$m];
					 $hsi2price = $_REQUEST['cushion_6-'.$m];
					 $isi1price = $_REQUEST['cushion_7-'.$m];
					$jsi1price = $_REQUEST['cushion_8-'.$m];*/
					$fgvs = $_REQUEST['cushion_2-'.$m];
					$fgsi = $_REQUEST['cushion_3-'.$m];
					$fgind = $_REQUEST['cushion_4-'.$m];
					$hivs = $_REQUEST['cushion_6-'.$m];
					$hisi = $_REQUEST['cushion_7-'.$m];
					$hiind = $_REQUEST['cushion_8-'.$m];
					$jkvs = $_REQUEST['cushion_9-'.$m];
					$jksi = $_REQUEST['cushion_10-'.$m];
					$jkind = $_REQUEST['cushion_11-'.$m];
				
					$query_insert_6 = "INSERT INTO stud_price SET shape = '".$shape."', carat = '".$carat."' , fgvs='".$fgvs."' , fgsi='".$fgsi."' , fgind='".$fgind."', hivs='".$hivs."' , hisi='".$hisi."' , hiind='".$hiind."', jkvs='".$jkvs."' , jksi='".$jksi."' , jkind='".$jkind."'";
					//echo $query_insert_2;
					//exit;
					mysql_query($query_insert_6);
				}
			}
			
			for($n = 0; $n<=$_REQUEST['radiant_longcount']; $n++)
			{
				if(isset($_REQUEST['radiant_long_1-'.$n]) && ($_REQUEST['radiant_long_1-'.$n] != '')){
					$shape = $_REQUEST['radiant_long_5-'.$n];
					$carat = $_REQUEST['radiant_long_1-'.$n];
					/*$fsi1price = $_REQUEST['radiant_long_2-'.$n];
					 $gvs2price = $_REQUEST['radiant_long_3-'.$n];
					 $gsi1price = $_REQUEST['radiant_long_4-'.$n];
					 $hsi2price = $_REQUEST['radiant_long_6-'.$n];
					 $isi1price = $_REQUEST['radiant_long_7-'.$n];
					$jsi1price = $_REQUEST['radiant_long_8-'.$n];*/
					$fgvs = $_REQUEST['radiant_long_2-'.$n];
					$fgsi = $_REQUEST['radiant_long_3-'.$n];
					$fgind = $_REQUEST['radiant_long_4-'.$n];
					$hivs = $_REQUEST['radiant_long_6-'.$n];
					$hisi = $_REQUEST['radiant_long_7-'.$n];
					$hiind = $_REQUEST['radiant_long_8-'.$n];
					$jkvs = $_REQUEST['radiant_long_9-'.$n];
					$jksi = $_REQUEST['radiant_long_10-'.$n];
					$jkind = $_REQUEST['radiant_long_11-'.$n];
				
					$query_insert_7 = "INSERT INTO stud_price SET shape = '".$shape."', carat = '".$carat."' , fgvs='".$fgvs."' , fgsi='".$fgsi."' , fgind='".$fgind."', hivs='".$hivs."' , hisi='".$hisi."' , hiind='".$hiind."', jkvs='".$jkvs."' , jksi='".$jksi."' , jkind='".$jkind."'";
					//echo $query_insert_2;
					//exit;
					mysql_query($query_insert_7);
				}
			}
			
			
			for($o = 0; $o<=$_REQUEST['marquisecount']; $o++)
			{
				if(isset($_REQUEST['marquise_1-'.$o]) && ($_REQUEST['marquise_1-'.$o] != '')){
					$shape = $_REQUEST['marquise_5-'.$o];
					$carat = $_REQUEST['marquise_1-'.$o];
					/*$fsi1price = $_REQUEST['marquise_2-'.$o];
					 $gvs2price = $_REQUEST['marquise_3-'.$o];
					 $gsi1price = $_REQUEST['marquise_4-'.$o];
					 $hsi2price = $_REQUEST['marquise_6-'.$o];
					 $isi1price = $_REQUEST['marquise_7-'.$o];
					$jsi1price = $_REQUEST['marquise_8-'.$o];*/
					$fgvs = $_REQUEST['marquise_2-'.$o];
					$fgsi = $_REQUEST['marquise_3-'.$o];
					$fgind = $_REQUEST['marquise_4-'.$o];
					$hivs = $_REQUEST['marquise_6-'.$o];
					$hisi = $_REQUEST['marquise_7-'.$o];
					$hiind = $_REQUEST['marquise_8-'.$o];
					$jkvs = $_REQUEST['marquise_9-'.$o];
					$jksi = $_REQUEST['marquise_10-'.$o];
					$jkind = $_REQUEST['marquise_11-'.$o];
				
					$query_insert_13 = "INSERT INTO stud_price SET shape = '".$shape."', carat = '".$carat."' , fgvs='".$fgvs."' , fgsi='".$fgsi."' , fgind='".$fgind."', hivs='".$hivs."' , hisi='".$hisi."' , hiind='".$hiind."', jkvs='".$jkvs."' , jksi='".$jksi."' , jkind='".$jkind."'";
					//echo $query_insert_2;
					//exit;
					mysql_query($query_insert_13);
				}
			}
			
			
			for($p = 0; $p<=$_REQUEST['pearcount']; $p++)
			{
				if(isset($_REQUEST['pear_1-'.$p]) && ($_REQUEST['pear_1-'.$p] != '')){
					$shape = $_REQUEST['pear_5-'.$p];
					$carat = $_REQUEST['pear_1-'.$p];
					/*$fsi1price = $_REQUEST['pear_2-'.$p];
					 $gvs2price = $_REQUEST['pear_3-'.$p];
					 $gsi1price = $_REQUEST['pear_4-'.$p];
					 $hsi2price = $_REQUEST['pear_6-'.$p];
					 $isi1price = $_REQUEST['pear_7-'.$p];
					$jsi1price = $_REQUEST['pear_8-'.$p];*/
					$fgvs = $_REQUEST['pear_2-'.$p];
					$fgsi = $_REQUEST['pear_3-'.$p];
					$fgind = $_REQUEST['pear_4-'.$p];
					$hivs = $_REQUEST['pear_6-'.$p];
					$hisi = $_REQUEST['pear_7-'.$p];
					$hiind = $_REQUEST['pear_8-'.$p];
					$jkvs = $_REQUEST['pear_9-'.$p];
					$jksi = $_REQUEST['pear_10-'.$p];
					$jkind = $_REQUEST['pear_11-'.$p];
				
					$query_insert_14 = "INSERT INTO stud_price SET shape = '".$shape."', carat = '".$carat."' , fgvs='".$fgvs."' , fgsi='".$fgsi."' , fgind='".$fgind."', hivs='".$hivs."' , hisi='".$hisi."' , hiind='".$hiind."', jkvs='".$jkvs."' , jksi='".$jksi."' , jkind='".$jkind."'";
					//echo $query_insert_2;
					//exit;
					mysql_query($query_insert_14);
			   }
			}
			
			
			for($q = 0; $q<=$_REQUEST['heartcount']; $q++)
			{
				if(isset($_REQUEST['heart_1-'.$q]) && ($_REQUEST['heart_1-'.$q] != '')){
					$shape = $_REQUEST['heart_5-'.$q];
					$carat = $_REQUEST['heart_1-'.$q];
					/*$fsi1price = $_REQUEST['heart_2-'.$q];
					 $gvs2price = $_REQUEST['heart_3-'.$q];
					 $gsi1price = $_REQUEST['heart_4-'.$q];
					 $hsi2price = $_REQUEST['heart_6-'.$q];
					 $isi1price = $_REQUEST['heart_7-'.$q];
					$jsi1price = $_REQUEST['heart_8-'.$q];*/
					$fgvs = $_REQUEST['heart_2-'.$q];
					$fgsi = $_REQUEST['heart_3-'.$q];
					$fgind = $_REQUEST['heart_4-'.$q];
					$hivs = $_REQUEST['heart_6-'.$q];
					$hisi = $_REQUEST['heart_7-'.$q];
					$hiind = $_REQUEST['heart_8-'.$q];
					$jkvs = $_REQUEST['heart_9-'.$q];
					$jksi = $_REQUEST['heart_10-'.$q];
					$jkind = $_REQUEST['heart_11-'.$q];
				
					$query_insert_15 = "INSERT INTO stud_price SET shape = '".$shape."', carat = '".$carat."' , fgvs='".$fgvs."' , fgsi='".$fgsi."' , fgind='".$fgind."', hivs='".$hivs."' , hisi='".$hisi."' , hiind='".$hiind."', jkvs='".$jkvs."' , jksi='".$jksi."' , jkind='".$jkind."'";
					//echo $query_insert_2;
					//exit;
					mysql_query($query_insert_15);
				}
			}
			//exit;

			for($r = 0; $r<=$_REQUEST['ovalcount']; $r++)
			{
				if(isset($_REQUEST['oval_1-'.$r]) && ($_REQUEST['oval_1-'.$r] != '')){
					$shape = $_REQUEST['oval_5-'.$r];
					$carat = $_REQUEST['oval_1-'.$r];
					/*$fsi1price = $_REQUEST['oval_2-'.$r];
					 $gvs2price = $_REQUEST['oval_3-'.$r];
					 $gsi1price = $_REQUEST['oval_4-'.$r];
					 $hsi2price = $_REQUEST['oval_6-'.$r];
					 $isi1price = $_REQUEST['oval_7-'.$r];
					$jsi1price = $_REQUEST['oval_8-'.$r];*/
					$fgvs = $_REQUEST['oval_2-'.$r];
					$fgsi = $_REQUEST['oval_3-'.$r];
					$fgind = $_REQUEST['oval_4-'.$r];
					$hivs = $_REQUEST['oval_6-'.$r];
					$hisi = $_REQUEST['oval_7-'.$r];
					$hiind = $_REQUEST['oval_8-'.$r];
					$jkvs = $_REQUEST['oval_9-'.$r];
					$jksi = $_REQUEST['oval_10-'.$r];
					$jkind = $_REQUEST['oval_11-'.$r];
				
					$query_insert_16 = "INSERT INTO stud_price SET shape = '".$shape."', carat = '".$carat."' , fgvs='".$fgvs."' , fgsi='".$fgsi."' , fgind='".$fgind."', hivs='".$hivs."' , hisi='".$hisi."' , hiind='".$hiind."', jkvs='".$jkvs."' , jksi='".$jksi."' , jkind='".$jkind."'";
					//echo $query_insert_2;
					//exit;
					mysql_query($query_insert_16);
				}
			}
			
			for($s = 0; $s<=$_REQUEST['trillioncount']; $s++)
			{
				if(isset($_REQUEST['trillion_1-'.$s]) && ($_REQUEST['trillion_1-'.$s] != '')){
					$shape = $_REQUEST['trillion_5-'.$s];
					$carat = $_REQUEST['trillion_1-'.$s];
					/*$fsi1price = $_REQUEST['trillion_2-'.$s];
					 $gvs2price = $_REQUEST['trillion_3-'.$s];
					 $gsi1price = $_REQUEST['trillion_4-'.$s];
					 $hsi2price = $_REQUEST['trillion_6-'.$s];
					 $isi1price = $_REQUEST['trillion_7-'.$s];
					$jsi1price = $_REQUEST['trillion_8-'.$s];*/
					$fgvs = $_REQUEST['trillion_2-'.$s];
					$fgsi = $_REQUEST['trillion_3-'.$s];
					$fgind = $_REQUEST['trillion_4-'.$s];
					$hivs = $_REQUEST['trillion_6-'.$s];
					$hisi = $_REQUEST['trillion_7-'.$s];
					$hiind = $_REQUEST['trillion_8-'.$s];
					$jkvs = $_REQUEST['trillion_9-'.$s];
					$jksi = $_REQUEST['trillion_10-'.$s];
					$jkind = $_REQUEST['trillion_11-'.$s];
				
					$query_insert_17 = "INSERT INTO stud_price SET shape = '".$shape."', carat = '".$carat."' , fgvs='".$fgvs."' , fgsi='".$fgsi."' , fgind='".$fgind."', hivs='".$hivs."' , hisi='".$hisi."' , hiind='".$hiind."', jkvs='".$jkvs."' , jksi='".$jksi."' , jkind='".$jkind."'";
					//echo $query_insert_2;
					//exit;
					mysql_query($query_insert_17);
				}
			}
			
			for($t = 0; $t<=$_REQUEST['square_radiantcount']; $t++)
			{
				if(isset($_REQUEST['square_radiant_1-'.$t]) && ($_REQUEST['square_radiant_1-'.$t] != '')){
					$shape = $_REQUEST['square_radiant_5-'.$t];
					$carat = $_REQUEST['square_radiant_1-'.$t];
					/*$fsi1price = $_REQUEST['square_radiant_2-'.$t];
					 $gvs2price = $_REQUEST['square_radiant_3-'.$t];
					 $gsi1price = $_REQUEST['square_radiant_4-'.$t];
					 $hsi2price = $_REQUEST['square_radiant_6-'.$t];
					 $isi1price = $_REQUEST['square_radiant_7-'.$t];
					$jsi1price = $_REQUEST['square_radiant_8-'.$t];*/
					$fgvs = $_REQUEST['square_radiant_2-'.$t];
					$fgsi = $_REQUEST['square_radiant_3-'.$t];
					$fgind = $_REQUEST['square_radiant_4-'.$t];
					$hivs = $_REQUEST['square_radiant_6-'.$t];
					$hisi = $_REQUEST['square_radiant_7-'.$t];
					$hiind = $_REQUEST['square_radiant_8-'.$t];
					$jkvs = $_REQUEST['square_radiant_9-'.$t];
					$jksi = $_REQUEST['square_radiant_10-'.$t];
					$jkind = $_REQUEST['square_radiant_11-'.$t];
				
					$query_insert_18 = "INSERT INTO stud_price SET shape = '".$shape."', carat = '".$carat."' , fgvs='".$fgvs."' , fgsi='".$fgsi."' , fgind='".$fgind."', hivs='".$hivs."' , hisi='".$hisi."' , hiind='".$hiind."', jkvs='".$jkvs."' , jksi='".$jksi."' , jkind='".$jkind."'";
					//echo $query_insert_2;
					//exit;
					mysql_query($query_insert_18);
				}
			}
			
			for($x = 0; $x<=$_REQUEST['fancycount']; $x++)
			{
				if(isset($_REQUEST['fancy_1-'.$x]) && ($_REQUEST['fancy_1-'.$x] != '')){
				$shape = $_REQUEST['fancy_5-'.$x];
					$carat = $_REQUEST['fancy_1-'.$x];
					/*$fsi1price = $_REQUEST['fancy_2-'.$x];
					$gvs2price = $_REQUEST['fancy_3-'.$x];
					$gsi1price = $_REQUEST['fancy_4-'.$x];
					$hsi2price = $_REQUEST['fancy_6-'.$x];
					$isi1price = $_REQUEST['fancy_7-'.$x];
					$jsi1price = $_REQUEST['fancy_8-'.$x];*/
					$fgvs = $_REQUEST['fancy_2-'.$x];
					$fgsi = $_REQUEST['fancy_3-'.$x];
					$fgind = $_REQUEST['fancy_4-'.$x];
					$hivs = $_REQUEST['fancy_6-'.$x];
					$hisi = $_REQUEST['fancy_7-'.$x];
					$hiind = $_REQUEST['fancy_8-'.$x];
					$jkvs = $_REQUEST['fancy_9-'.$x];
					$jksi = $_REQUEST['fancy_10-'.$x];
					$jkind = $_REQUEST['fancy_11-'.$x];
				
			      $query_insert_19 = "INSERT INTO stud_price SET shape = '".$shape."', carat = '".$carat."' , fgvs='".$fgvs."' , fgsi='".$fgsi."' , fgind='".$fgind."', hivs='".$hivs."' , hisi='".$hisi."' , hiind='".$hiind."', jkvs='".$jkvs."' , jksi='".$jksi."' , jkind='".$jkind."'";		
				  mysql_query($query_insert_19);
				}
			}
			
			//exit;
				
			
			
			Mage::getSingleton("adminhtml/session")->addSuccess("Information Saved.");
			$this->_redirect("*/*/new");
			return;
		}
		catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			$this->_redirect("*/*/new");
			return;	
        }
	}
	 
	public function insertinpopupAction()
	{
	 	$fancycolor['LIGHT'] = 9;
		$fancycolor['F.LIGHT'] = 10;
		$fancycolor['FANCY'] = 11;
		$fancycolor['INTENSE'] = 12;
		$fancycolor['VIVID'] = 13;
		$fancycolor['DEEP'] = 14; 
		try
		{
			$magento_db 	= 	Mage::getStoreConfig('stud/db_detail/db_database'); 
			$mdb_name 		= 	Mage::getStoreConfig('stud/db_detail/db_name');
			$mdb_user 		= 	Mage::getStoreConfig('stud/db_detail/db_username');
			$mdb_passwd 	= 	Mage::getStoreConfig('stud/db_detail/db_userpassword');
			$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);
			
			if (!$magento_connection)
			{
				die('Unable to connect to the Magento database');
			}
			@mysql_select_db($mdb_name, $magento_connection) or die ("Magento Database not found.");
			
			$select_vendor = 'select * from `vendor`';
			$result = mysql_query($select_vendor);
			while($row = mysql_fetch_array($result))
			{
				$SELLER_IDS[$row['vendor_id']] = $row['rap_percent'];
				$SELLER_NAMES[$row['vendor_name']] = $row['rap_percent'];
			}	
			
			$user = Mage::getStoreConfig('stud/user_detail/rapnet_username');
			$passwd = Mage::getStoreConfig('stud/user_detail/rapnet_password');
			
			define('RAPNET_USER', $user);
			define('RAPNET_PASS', $passwd);
			
			$auth_url = "https://technet.rapaport.com/HTTP/Authenticate.aspx";
			$post_string = "username=".RAPNET_USER."&password=" . urlencode(RAPNET_PASS);
			
			$request = curl_init($auth_url); //initiate curl object
			curl_setopt($request, CURLOPT_HEADER, 0); //set to 0 to eliminate header info from response
			curl_setopt($request, CURLOPT_RETURNTRANSFER, 1); //Returns response data instead of TRUE(1)
			curl_setopt($request, CURLOPT_POSTFIELDS, $post_string); //use HTTP POST to send form data
			curl_setopt($request, CURLOPT_SSL_VERIFYPEER, FALSE); //uncomment this line if you get no gateway response.
			$auth_ticket = curl_exec($request); //execute curl post and store results in $auth_ticket
			curl_close ($request);
	
			define('RAPNET_LINK', 'technet.rapaport.com/HTTP/RapLink/download.aspx?SellerLogin='.implode(',', array_keys($SELLER_IDS)).'&SortBy=Owner&White=1&Fancy=1&Programmatically=yes&Version=0.8&UseCheckedCulommns=1&cCT=1&cCERT=1&cCLAR=1&cCOLR=1&cCRTCM=1&cCountry=1&cCITY=1&cCROWN=1&cCulet=1&cCuletSize=1&cCuletCondition=1&cCUT=1&cDPTH=1&cFancyColor=1&cFLR=1&cGIRDLE=1&cGirdleMin=1&cGirdleMax=1&cFancyColorIntensity=1&cLOTNN=1&cMEAS=1&cMeasLength=1&cMeasWidth=1&cMeasDepth=1&cFancyColorOvertone=1&cPAVILION=1&cPOL=1&cTPr=1&cRapSpec=1&cOWNER=1&cAct=1&cNC=1&cSHP=1&cSTATE=1&cSTOCK_NO=1&cSYM=1&cTBL=1&cSTONES=1&cCertificateImage=1&cCertID=1&cFluorColor=1&cFluorIntensity=1&cDateUpdated=1'.'&ticket='.$auth_ticket); 
			
			$handle = fopen('http://'.RAPNET_LINK, 'r');
			$csv_terminated = "\n";
			$csv_separator = ",";
			$csv_enclosed = "'";
			$csv_escaped = "\\";
			$CSV = "";
			
			while (($data = fgetcsv($handle, 0, ",")) !== FALSE) 
			{ 
				for ($field = 0; $field < count($data); $field++) 
				{ 
					if($field == 29)
					{
						$CSV.= ''.$csv_separator;
					}
					else
					{
						$CSV.= $data[$field].$csv_separator;					
					}	
				}
				$CSV.= $csv_terminated;
			}
			
			$path = Mage::getBaseDir("var") . DS ."import" . DS;
			$fp = fopen($path."products.csv", "w") or die("can't open file");
			fputs($fp, rtrim($CSV));
			fclose($fp);
			
			Mage::getSingleton("adminhtml/session")->addSuccess("Successfully get list from Rapnet.");
			$this->_redirect("*/*/new");
		}		
		catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			$this->_redirect("*/*/new");
			return;				
        }
	} 
	
	
	public function reindexAction()
	{
		try
		{
			$magento_db 	= 	Mage::getStoreConfig('stud/db_detail/db_database'); 
			$mdb_name 		= 	Mage::getStoreConfig('stud/db_detail/db_name');
			$mdb_user 		= 	Mage::getStoreConfig('stud/db_detail/db_username');
			$mdb_passwd 	= 	Mage::getStoreConfig('stud/db_detail/db_userpassword');
			$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);
			
			if (!$magento_connection)
			{
				die('Unable to connect to the database');
			}
			@mysql_select_db($mdb_name, $magento_connection) or die ("Database not found.");
			mysql_query("TRUNCATE TABLE diamonds_inventory");
			
			$path = Mage::getBaseDir("var") . DS ."import" . DS;
			$fp = fopen($path."products.csv",'r') or die("can't open file");
			$row=0;
			$count = 1;
			while($csv_line = fgetcsv($fp,1024))
			{
				if($row==0){
					$row++;
					continue;
				}
				$qstring = "insert into `diamonds_inventory` SET 
						owner = '".$csv_line[0]."',
						shape = '".$csv_line[1]."',
						carat = '".$csv_line[2]."',
						color = '".$csv_line[3]."',
						fancycolor = '".$csv_line[4]."',
						fancy_intensity = '".$csv_line[5]."',
						clarity = '".$csv_line[7]."',
						cut = '".$csv_line[8]."',
						polish = '".$csv_line[9]."',
						symmetry = '".$csv_line[10]."',
						fluorescence = '".$csv_line[11]."',
						dimensions = '".$csv_line[13]."',
						certificate = '".$csv_line[17]."',
						cert_number = '".$csv_line[18]."',
						stock_number = '".$csv_line[19]."',
						cost = '".$csv_line[20]."',
						totalprice = '".$csv_line[20]."',
						depth = '".$csv_line[21]."',
						tabl = '".$csv_line[22]."',
						girdle = '".$csv_line[23]."',
						culet = '".$csv_line[26]."',
						crown = '".$csv_line[27]."',
						pavilion = '".$csv_line[28]."',
						city = '".$csv_line[30]."',
						state = '".$csv_line[31]."',
						country = '".$csv_line[32]."',
						number_stones = '".$csv_line[33]."',
						image = '".$csv_line[34]."',
						lotno = '".$csv_line[35]."',
						make = '".$csv_line[36]."'";
						
				mysql_query($qstring);
			}
			
			$query = "SELECT * FROM applied_rule";
			$result= mysql_query($query);
			while($row = mysql_fetch_array($result))
			{
				 $price_from[] = $row[price_from];
				 $price_to[] = $row[price_to];
				 $price_increase_per = $row[price_increase]/100 ;
				 $price_increase_final[] = 1 + $price_increase_per ;		
			}
			
			
			$del = "DELETE FROM `diamonds_inventory` where totalprice = 0.00 or carat=0 or clarity='';";
			mysql_query($del);

			for($i=0; $i<100; $i++)
			{
				if($price_increase_final[$i] != '')
				{
					$query_update = "UPDATE diamonds_inventory SET totalprice = totalprice*".$price_increase_final[$i]." where cost between ".$price_from[$i]." AND ".$price_to[$i];
					//echo '<br/>';
				mysql_query($query_update);
				}
			
			}

			$ROUND= "update `diamonds_inventory` set `shape` = 'ROUND' where `shape`='B' or `shape`='RB' or `shape`='BR';";
			$PRINCESS= "update `diamonds_inventory` set `shape` = 'PRINCESS' where `shape`='PR';";
			$EMERALD= "update `diamonds_inventory` set `shape` = 'EMERALD' where `shape`='E' or `shape`='EC';";
			$ASSCHER= "update `diamonds_inventory` set `shape` = 'ASSCHER' where `shape`='AS' or `shape`='AC';";
			$MARQUISE= "update `diamonds_inventory` set `shape` = 'MARQUISE' where `shape`='M' or `shape`='MQ';";
			$OVAL= "update `diamonds_inventory` set `shape` = 'OVAL' where `shape`='O' or `shape`='OV' or `shape`='OC';";
			$RADIANT= "update `diamonds_inventory` set `shape` = 'RADIANT' where `shape`='R' or `shape`='RAD';";
			$PEAR= "update `diamonds_inventory` set `shape` = 'PEAR' where `shape`='P' or `shape`='PS';";
			$CUSHION= "update `diamonds_inventory` set `shape` = 'CUSHION' where `shape`='C' or `shape`='CU' or `shape`='CMB';";
			$HEART= "update `diamonds_inventory` set `shape` = 'HEART' where `shape`='H' or `shape`='HM' or `shape`='HS';";
			$TRILLION = "update `diamonds_inventory` set `shape` = 'TRIANGULAR' where `shape`='TRI' or `shape`='T';";

			$DelShape = "DELETE FROM `diamonds_inventory` WHERE `shape` NOT IN ('ROUND', 'PRINCESS', 'EMERALD', 'ASSCHER', 'MARQUISE', 'OVAL', 'RADIANT', 'PEAR', 'CUSHION', 'HEART', 'TRIANGULAR') OR `dimensions`='0.00x0.00x0.00' OR `dimensions`='0.00-0.00x0.00';";
		
			$shadelight= "update `diamonds_inventory` set `color` = `fancycolor`, `fancycolor` = 9   where `fancy_intensity`='LIGHT' OR `fancy_intensity`='Light' OR `fancy_intensity`='light';"; 
			$shadefancylight= "update `diamonds_inventory` set `color` = `fancycolor`,`fancycolor` = 10 where `fancy_intensity`='Fancy Light' OR `fancy_intensity`='FANCY LIGHT' OR `fancy_intensity`='fancy light';"; 	
			$shadefancy= "update `diamonds_inventory` set `color` = `fancycolor`, `fancycolor` = 11  where `fancy_intensity`='FANCY' OR `fancy_intensity`='Fancy' OR `fancy_intensity`='fancy';";	
			$shadefancyintense= "update `diamonds_inventory` set `color` = `fancycolor`, `fancycolor` = 12 where `fancy_intensity`='Fancy Intense' OR `fancy_intensity`='fancy intense' OR `fancy_intensity`='FANCY INTENSE';";
			$shadefancyvivid= "update `diamonds_inventory` set `color` = `fancycolor`, `fancycolor` = 13 where `fancy_intensity`='VIVID' OR `fancy_intensity`='Vivid' OR `fancy_intensity`='vivid';";
			$shadefancydeep= "update `diamonds_inventory` set `color` = `fancycolor`, `fancycolor` = 14 where `fancy_intensity`='Fancy Deep' OR `fancy_intensity`='FANCY DEEP' OR `fancy_intensity`='fancy deep';";
			
			mysql_query($ROUND);
			mysql_query($PRINCESS);
			mysql_query($EMERALD);
			mysql_query($ASSCHER);
			mysql_query($MARQUISE);
			mysql_query($OVAL);  
			mysql_query($RADIANT);  
			mysql_query($PEAR);  
			mysql_query($CUSHION);  
			mysql_query($HEART);  
			mysql_query($TRILLION);  
			
			mysql_query($DelShape);  	
			
			mysql_query($shadelight);
			mysql_query($shadefancylight);
			mysql_query($shadefancy);
			mysql_query($shadefancyintense);
			mysql_query($shadefancyvivid);
			mysql_query($shadefancydeep);
			
			$sql = "select count(lotno) from diamonds_inventory "; 
			$result = mysql_query($sql); 
			$row = mysql_fetch_row($result); 
			$count = $row[0];
									
			Mage::getSingleton("adminhtml/session")->addSuccess($count." Diamond(s) Inserted.");
			$this->_redirect("*/*/new");

		}		
		catch (Exception $e) {
			Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
			$this->_redirect("*/*/new");
			return;				
		}
	}
	
 	public function inventoryupdateAction()
	{
////////////////////////////////////////  Code for adding into inventory table  /////////////////////////////////////////
				$Shape['RB'] = 'ROUND';
				$Shape['BR'] = 'ROUND';
				$Shape['PS'] = 'PRINCESS';
				$Shape['OV'] = 'OVAL';
				$Shape['HS'] = 'HEART';
				$Shape['MQ'] = 'MARQUISE';
				$Shape['PR'] = 'PEAR';
				$Shape['CU'] = 'CUSHION';
				$Shape['EC'] = 'EMERALD';
				$Shape['RAD'] = 'RADIANT';
				$Shape['AC'] = 'ASSCHER';
				$Shape['TR'] = 'TRILLION';
				
				$Shape['HM'] = 'HEART';
				
				$Shape['OC'] = 'OVAL';		
				 
				
				$path = Mage::getBaseDir("var") . DS ."import" . DS;	
				
				$fp = fopen($path."upload_product.csv","r") or die("can't open file");
				$row=0;
				
				
				$write = Mage::getSingleton("core/resource")->getConnection("core_write");
				$sql = "TRUNCATE TABLE `inventorynew`";
				$readresult = $write->query($sql);			
				
				while($csv_line = fgetcsv($fp,2058)){					
					if($row==0){
						foreach($csv_line as $key=>$lineValue)
						{
							if($lineValue == "sku")
							{
								$sku=$key;
								break;
							}
						}
						$row++;
						continue;
					}else{
						
						$_product = Mage::getModel("catalog/product");
						$Id = $_product->getIdBySku($csv_line[5]);
						if($Id)
						{
								$_product = $_product->load($Id);
								
								$lotno          = $csv_line[$sku]; 
								
								$shape          = $_product->getResource()->getAttribute("diamond_shape")->getFrontend()->getValue($_product);
								
								$lab            = $_product->getData("lab");
								
								$carat          = $_product->getData("diamond_carat");
								$stone          = 1;
								$color          = $_product->getResource()->getAttribute("diamond_color")->getFrontend()->getValue($_product);
								$clarity        = $_product->getResource()->getAttribute("diamond_clarity")->getFrontend()->getValue($_product);
								$cut            = "";
								$culet          = $_product->getResource()->getAttribute("diamond_cutlet")->getFrontend()->getValue($_product);
								

								$dimensions    = $_product->getData("dimension_length")."x".$_product->getData("dimension_width");
								
								if($_product->getData("dimension_height")!= ""||$_product->getData("dimension_height")!=NULL)
								{
									$dimensions.="x".$_product->getData("dimension_height");
								}
								$depth          = $_product->getData("diamond_depth");
								$tabl           = $_product->getData("diamond_table");
								$crown_angle    = $_product->getData("crown_angle");
								$crown_height   = $_product->getData("crown_height");
								$pavilion_height= $_product->getData("pavilion_height");
								$polish         = $_product->getResource()->getAttribute("diamond_polish")->getFrontend()->getValue($_product);
								$symmetry       = $_product->getResource()->getAttribute("diamond_symmetry")->getFrontend()->getValue($_product);
								
								
								
								
								$fluorescence   = $_product->getResource()->getAttribute("diamond_fluor")->getFrontend()->getValue($_product);
								$girdle         = $_product->getResource()->getAttribute("diamond_girdle")->getFrontend()->getValue($_product);
								$certificate    = $_product->getData("certificate_id ");;
								$ppc            = "";
								$colorcode      = "";
								$claritycode    = "";
								$fancycolor     = $_product->getData("fancy_color");
								$totalprice     = $_product->getData("price");
								
								
								
								if($cut == "No")
								{
									$cut = "";
								}
								if($culet == "No")
								{
									$culet = "";
								}
								
								if($color == "No")
								{
									$color = "";
								}
								
								if($clarity == "No")
								{
									$clarity = "";
								}
								
								if($polish == "No")
								{
									$polish = "";
								}
								
								if($fluorescence == "No")
								{
									$fluorescence = "";
								}
								
								if($girdle == "No")
								{
									$girdle = "";
								}
								
								if($symmetry == "No" )
								{
									$symmetry = "";
								}
							
						
							$sqlQuery = "insert into `inventorynew` set
													`lotno` = '".$lotno."',
													`shape` = '".$shape."',
													`lab` = '".$lab."',
													
													`carat` = '".$carat."',
													`stone` = '".$stone."',
													`color` = '".$color."',
													`clarity` = '".$clarity."',
													`cut` = '".$cut."',
													`culet` = '".$culet."',
													`dimensions` = '".$dimensions."',
													`depth` = '".$depth."',
													`tabl` = '".$tabl."',
													`crown_angle` = '".$crown_angle."',
													`crown_height` = '".$crown_height."',
													`pavilion_height` = '".$pavilion_height."',
													`polish` = '".$polish."',
													`symmetry` = '".$symmetry."',
													`fluorescence` = '".$fluorescence."',
													`girdle` = '".$girdle."',
													`certificate` = '".$certificate."',
													`ppc` = '".$ppc."',
													`colorcode` = '".$colorcode."',
													`claritycode` = '".$claritycode."',
													`fancycolor` = '".$fancycolor."',
													`totalprice` = '".$totalprice."',
													`product_id` = '".$Id."'
											";
							
							$readresult = $write->query($sqlQuery);
						
							
							
						}else{
								Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("Error During Update Inventory."));
						
						}
						
					}	
				}
				Mage::getSingleton("adminhtml/session")->addSuccess("Inventory updated.");
				$this->_redirect("*/*/new");
				return;
////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
	
	}
 
 
 
 
 
	public function deleteAction() {
		if( $this->getRequest()->getParam("id") > 0 ) {
			try {
				$model = Mage::getModel("stud/stud");
				 
				$model->setId($this->getRequest()->getParam("id"))
					->delete();
					 
				Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
				$this->_redirect("*/*/");
			} catch (Exception $e) {
				Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
				$this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
			}
		}
		$this->_redirect("*/*/");
	}

    public function massDeleteAction() {
        $studIds = $this->getRequest()->getParam("stud");
        if(!is_array($studIds)) {
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("Please select item(s)"));
        } else {
            try {
                foreach ($studIds as $studId) {
                    $stud = Mage::getModel("stud/stud")->load($studId);
                    $stud->delete();
                }
                Mage::getSingleton("adminhtml/session")->addSuccess(
                    Mage::helper("adminhtml")->__(
                        "Total of %d record(s) were successfully deleted", count($studIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
            }
        }
        $this->_redirect("*/*/index");
    }
	
    public function massStatusAction()
    {
        $studIds = $this->getRequest()->getParam("stud");
        if(!is_array($studIds)) {
            Mage::getSingleton("adminhtml/session")->addError($this->__("Please select item(s)"));
        } else {
            try {
                foreach ($studIds as $studId) {
                    $stud = Mage::getSingleton("stud/stud")
                        ->load($studId)
                        ->setStatus($this->getRequest()->getParam("status"))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__("Total of %d record(s) were successfully updated", count($studIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect("*/*/index");
    }
  
    public function exportCsvAction()
    {
        $fileName   = "stud.csv";
        $content    = $this->getLayout()->createBlock("stud/adminhtml_stud_grid")
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = "stud.xml";
        $content    = $this->getLayout()->createBlock("stud/adminhtml_stud_grid")
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType="application/octet-stream")
    {
        $response = $this->getResponse();
        $response->setHeader("HTTP/1.1 200 OK","");
        $response->setHeader("Pragma", "public", true);
        $response->setHeader("Cache-Control", "must-revalidate, post-check=0, pre-check=0", true);
        $response->setHeader("Content-Disposition", "attachment; filename=".$fileName);
        $response->setHeader("Last-Modified", date("r"));
        $response->setHeader("Accept-Ranges", "bytes");
        $response->setHeader("Content-Length", strlen($content));
        $response->setHeader("Content-type", $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
}