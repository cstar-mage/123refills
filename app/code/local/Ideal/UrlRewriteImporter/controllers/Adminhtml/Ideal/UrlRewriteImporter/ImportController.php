<?php 
class Ideal_UrlRewriteImporter_Adminhtml_Ideal_UrlRewriteImporter_ImportController extends Mage_Adminhtml_Controller_Action {

    protected function _getSession() {
        return Mage::getSingleton('adminhtml/session');
    }

    private function _allowedType($type) {
        $mimes = array(
            'text/csv',
            'text/plain',
            'application/csv',
            'text/comma-separated-values',
            'application/excel',
            'application/vnd.ms-excel',
            'application/vnd.msexcel',
            'text/anytext',
            'application/octet-stream',
            'application/txt',
        );

        if (in_array($type, $mimes)) {
            return true;
        }

        return false;
    }

    public function saveAction() {
        if ($this->getRequest()->isPost()) {

            $filename = $_FILES['file']['tmp_name'];

            if (!file_exists($filename)) {
                $this->_getSession()->addError('Unable to upload the file!');
                $this->_redirectReferer();
                return;
            }

            if ($this->_allowedType($_FILES['file']['type']) == false) {
                $this->_getSession()->addError('Sorry, mime type not allowed!');
                $this->_redirectReferer();
                return;
            }

            $length = $this->getRequest()->getParam('length', 0);
            $delimiter = $this->getRequest()->getParam('delimiter', ',');
            $enclosure = $this->getRequest()->getParam('enclosure', '"');
            $escape = $this->getRequest()->getParam('escape', '\\');
            $skipline = $this->getRequest()->getParam('skipline', false);

            $total = 0;
            $totalSuccess = 0;
            $logException = '';

            if (($fp = fopen($filename, 'r'))) {
                while (($line = fgetcsv($fp, $length, $delimiter, $enclosure, $escape))) {

                    $total++;
                    if ($skipline && ($total == 1)) {
                        continue;
                    }

                    $requestPath = $line[0];
                    $targetPath = $line[1];

                    $rewrite = Mage::getModel('core/url_rewrite');

                    $rewrite->setIdPath(uniqid())
                            ->setTargetPath($targetPath)
                            ->setOptions('RP')
                            ->setDescription('Ideal_UrlRewriteImporter')
                            ->setRequestPath($requestPath)
                            ->setIsSystem(0)
                            ->setStoreId(0);

                    try {
                        $rewrite->save();
                        $totalSuccess++;
                    } catch (Exception $e) {
                        $logException = $e->getMessage();
                        Mage::logException($e);
                    }
                }
                fclose($fp);
                unlink($filename);

                if ($total === $totalSuccess) {
                    $this->_getSession()->addSuccess(sprintf('All %s URL rewrites have been successfully imported.', $total));
                } elseif ($totalSuccess == 0) {
                    $this->_getSession()->addError('No URL rewrites have been imported.');
                    if (!empty($logException)) {
                        $this->_getSession()->addError(sprintf('Last logged exception: %s', $logException));
                    }
                    $this->_redirectReferer();
                    return;
                } else {
                    $this->_getSession()->addNotice(sprintf('%s URL rewrites have been imported.', $total - $totalSuccess));
                    if (!empty($logException)) {
                        $this->_getSession()->addError(sprintf('Last logged exception: %s', $logException));
                    }
                }
            }
        }
        $this->_redirect('*/urlrewrite/index');
        return;
    }

    public function editAction() {
        $this->loadLayout();

        $this->_addContent($this->getLayout()->createBlock('ideal_urlrewriteimporter/adminhtml_UrlRewriteImporter_edit'));
        $this->_addLeft($this->getLayout()->createBlock('ideal_urlrewriteimporter/adminhtml_UrlRewriteImporter_edit_tabs'));

        $this->_setActiveMenu('catalog/urlrewrite');

        $this->renderLayout();
    }

    public function newAction() {
        $this->_forward('edit');
    }
    public function checkrepairAction() {
		try
		{
			$resource = Mage::getConfig()->getNode('global/resources')->asArray();
			$magento_db = $resource['default_setup']['connection']['host'];
			$mdb_user = $resource['default_setup']['connection']['username'];
			$mdb_passwd = $resource['default_setup']['connection']['password'];
			$mdb_name = $resource['default_setup']['connection']['dbname'];
			//echo $magento_db." - ".$mdb_user." - ".$mdb_passwd." - ".$mdb_name;
			$magento_connection = @mysql_connect($magento_db, $mdb_user, $mdb_passwd);
		
			if (!$magento_connection)
			{
				die('Unable to connect to the database');
			}
			@mysql_select_db($mdb_name, $magento_connection) or die ("Database not found.");
		
			$core_url_rewrite = Mage::getSingleton("core/resource")->getTableName('core_url_rewrite');
			$eav_attribute = Mage::getSingleton("core/resource")->getTableName('eav_attribute');
			$eav_entity_type = Mage::getSingleton("core/resource")->getTableName('eav_entity_type');
			$catalog_product_entity_varchar = Mage::getSingleton("core/resource")->getTableName('catalog_product_entity_varchar');

			//Repair Empty/Null url_keys
			$cntNullUrls = 0;
			$prodsNullUrl = Mage::getModel("catalog/product")->getCollection()
				->addAttributeToFilter('url_key',array('null' => true));
			if($prodsNullUrl ->getSize()>0){
				foreach($prodsNullUrl as $prod){
					$product = Mage::getModel('catalog/product')->load($prod->getId());
					$url_key = Mage::getModel('catalog/product_url')->formatUrlKey($prod->getSku());
					$product->setUrlKey($url_key);
					$product->getResource()->saveAttribute($product, 'url_key');
					$cntNullUrls++;
				}
			}
			//END Repair Empty/Null url_keys
			
			
			$query = 'SELECT entity_id, `value`
			FROM catalog_product_entity_varchar v
			WHERE EXISTS (
			  SELECT *
			  FROM eav_attribute a
			  WHERE attribute_code = "url_key"
			  AND v.attribute_id = a.attribute_id
			  AND EXISTS (
				 SELECT *
				 FROM eav_entity_type e
				 WHERE entity_type_code = "catalog_product"
				 AND a.entity_type_id = e.entity_type_id
			  )
			)
			';
			
			$all_prods_with_urlkeys = array();
			
			//echo $query;
			$result= mysql_query($query);
			
			if (!$result) {
				//echo 'Could not run query: ' . mysql_error();
				$this->_getSession()->addError('Could not run query.');
				$this->_redirectReferer();
				return;
				//$this->_redirect('*/urlrewrite/index');
        		//return;
			}
			
			if(mysql_num_rows($result) > 0){
				while($row = mysql_fetch_array($result))
				{
					$all_prods_with_urlkeys[$row['entity_id']] = $row['value'];
				}
			}
			
			
			//echo "<pre>";
			//echo "Total Products: ".count($all_prods_with_urlkeys)."<br>";
			//print_r($all_prods_with_urlkeys);
			$all_prods_with_dupl_count = (array_count_values($all_prods_with_urlkeys));
		
			//echo "DUPL: ".count($all_prods_with_dupl_count);
			//print_r($all_prods_with_dupl_count);
			//exit;
			$cnt_url_updated = 0;
			
			$query_update_urlkey = array();
			foreach($all_prods_with_dupl_count as $url_key => $dupl_count){
				if($dupl_count > 1){
					
					$arr_url_entity = array_keys($all_prods_with_urlkeys, $url_key);
					
					if(count($arr_url_entity) > 1){
						for($i=1;$i<count($arr_url_entity);$i++){
							
							//$query_update_urlkey[] = '';
							$product = Mage::getModel("catalog/product")->load($arr_url_entity[$i]);
							$sku = $product->getSku();
							$old_url_key = $product->getUrlKey();
							//$new_url_key = $old_url_key."-".$sku;
							$new_url_key = Mage::getModel('catalog/product_url')->formatUrlKey($old_url_key."-".$sku);
							$product->setUrlKey($new_url_key);
							$product->getResource()->saveAttribute($product, 'url_key');
							//$product->save();
							$cnt_url_updated++;
							//echo $old_url_key ."  =>  ".$new_url_key."<br>";
							
						}
					}
				}
			}
			
			//echo $cnt_url_updated." Url Key(s) Updated.<br>";
			$this->_getSession()->addSuccess($cntNullUrls ." Empty Url Key(s) Updated. ".$cnt_url_updated." Url Key(s) Conflicts Removed.");
			$this->_redirectReferer();
			return;
		}
		catch (Exception $e) {
			$this->_getSession()->addError($e->getMessage());
			$this->_redirectReferer();
			return;
			//echo $e->getMessage();
			//exit;
		}
    }
}
