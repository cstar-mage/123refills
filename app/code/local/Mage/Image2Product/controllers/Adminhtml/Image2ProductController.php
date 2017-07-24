<?php
class Mage_Image2Product_Adminhtml_Image2ProductController extends Mage_Adminhtml_Controller_action
{	
	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu("Image2Product/items")
			->_addBreadcrumb(Mage::helper("adminhtml")->__("Image to Product"), Mage::helper("adminhtml")->__("Image to Product"));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam("id");
		$model  = Mage::getModel("Image2Product/Image2Product")->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton("adminhtml/session")->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register("Image2Product_data", $model);

			$this->loadLayout();
			$this->_setActiveMenu("Image2Product/items");

			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Item Manager"), Mage::helper("adminhtml")->__("Item Manager"));
			$this->_addBreadcrumb(Mage::helper("adminhtml")->__("Item News"), Mage::helper("adminhtml")->__("Item News"));

			$this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock("Image2Product/adminhtml_Image2Product_edit"))
				->_addLeft($this->getLayout()->createBlock("Image2Product/adminhtml_Image2Product_edit_tabs"));

			$this->renderLayout();
		} else {
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("Image2Product")->__("Item does not exist"));
			$this->_redirect("*/*/");
		}
	}
 
	public function newAction() {
		$this->_forward("edit");
	}
 
	public function saveAction() {	
		
		if($_FILES["zipfile"]["name"]) {

			$filename = $_FILES["zipfile"]["name"];
			$source = $_FILES["zipfile"]["tmp_name"];
			$type = $_FILES["zipfile"]["type"];
		 
			$name = explode(".", $filename);

			$accepted_types = array('application/zip', 'application/x-zip-compressed', 'multipart/x-zip', 'application/x-compressed');
			foreach($accepted_types as $mime_type) {
				if($mime_type == $type) {
					$okay = true;
					break;
				} 
			}
		 
			$continue = strtolower($name[1]) == 'zip' ? true : false;

			if(!$continue) {
				Mage::getSingleton("adminhtml/session")->addError(Mage::helper("Image2Product")->__("The file you are trying to upload is not a .zip file. Please try again."));
			$this->_redirect("*/*/");
			}
			
			$directory = Mage::getBaseDir().'/media/import/Image2Product/';
			
			$target_path = $directory.$filename;  // change this to the correct site path
			
			if(move_uploaded_file($source, $target_path)) {
				$zip = new ZipArchive();
				$x = $zip->open($target_path);
				if ($x === true) {
					$zip->extractTo($directory); // change this to the correct site path
					$zip->close();
		 
					unlink($target_path);
				}
				Mage::getSingleton("adminhtml/session")->addSuccess("Your .zip file was uploaded and unpacked.");
				$this->_redirect("*/*/new");
				
			} else {	
				Mage::getSingleton("adminhtml/session")->addError(Mage::helper("Image2Product")->__("There was a problem with the upload. Please try again."));
				$this->_redirect("*/*/");
			}
		}
	}
	
	public function removeAction() {
		$directory = Mage::getBaseDir().'/media/import/Image2Product/';
		$files = scandir($directory);
		
		foreach($files as $file) {
		  unlink("{$directory}/{$file}");
		}
		
		Mage::getSingleton("adminhtml/session")->addSuccess("Image2Product Direcory Empty Now.");
		$this->_redirect("*/*/new");
			
	}
	
	public function generatecsvAction() {	
		//echo "Here";
				$row=0;
				$i=0;

				$directory = Mage::getBaseDir().'/media/import/Image2Product/';

				$csv_terminated = "\n";
				$csv_separator = ",";
//				$csv_enclosed = "'";
				$csv_enclosed = '"';
				$csv_escaped = "\\";
				
				
				$data = "store".$csv_separator;
				$data .= "websites".$csv_separator;
				$data .= "attribute_set".$csv_separator;
				$data .= "type".$csv_separator;
				$data .= "sku".$csv_separator;
				$data .= "has_options".$csv_separator;
				$data .= "name".$csv_separator;
				$data .= "description".$csv_separator;
				$data .= "short_description".$csv_separator;
				$data .= "image".$csv_separator;
				$data .= "small_image".$csv_separator;
				$data .= "thumbnail".$csv_separator;
				$data .= "price".$csv_separator;
				$data .= "weight".$csv_separator;
				$data .= "status".$csv_separator;
				$data .= "tax_class_id".$csv_separator;
				$data .= "is_recurring".$csv_separator;
				$data .= "visibility".$csv_separator;
				$data .= "enable_googlecheckout".$csv_separator;
				$data .= "qty".$csv_separator;
				$data .= "is_in_stock".$csv_terminated;

				
			// create an array to hold directory list
			$results = array();
			
			// create a handler for the directory

			$handler = opendir($directory);

			// open directory and walk through the filenames
			while ($file = readdir($handler)) {
			
				// if file isn't this directory or its parent, add it to the results
				if ($file != "." && $file != "..") {			
						// add to our file array for later use
					$extension = pathinfo($file, PATHINFO_EXTENSION);
					if($extension == 'jpg'){
						//echo "<pre>";
						$data.= "admin"."".$csv_separator;
						$data.= "base"."".$csv_separator;
						$data.= "Default"."".$csv_separator;
						$data.= "simple"."".$csv_separator;
						$data.= basename($file,".jpg")."".$csv_separator;
						$data.= "0"."".$csv_separator;
						$data.= basename($file,".jpg")."".$csv_separator;
						$data.= basename($file,".jpg")."".$csv_separator;
						$data.= basename($file,".jpg")."".$csv_separator;						
						$data.= "/Image2Product/".$file."".$csv_separator;
						$data.= "/Image2Product/".$file."".$csv_separator;
						$data.= "/Image2Product/".$file."".$csv_separator;
						$data.= "0"."".$csv_separator;
						$data.= "1"."".$csv_separator;
						$data.= "Enabled"."" .$csv_separator;
						$data.= "Taxable Goods"."".$csv_separator;
						$data.= "No"."". $csv_separator;
						$data.= '"Catalog, Search"'."".$csv_separator;
						$data.= "Yes"."".$csv_separator;
						$data.= "1"."".$csv_separator;
						$data.= "1"."".$csv_terminated;
						}
						
					if($extension == 'jpeg'){
						//echo "<pre>";
						$data.= "admin"."".$csv_separator;
						$data.= "base"."".$csv_separator;
						$data.= "Default"."".$csv_separator;
						$data.= "simple"."".$csv_separator;
						$data.= basename($file,".jpeg")."".$csv_separator;
						$data.= "0"."".$csv_separator;
						$data.= basename($file,".jpeg")."".$csv_separator;
						$data.= basename($file,".jpeg")."".$csv_separator;
						$data.= basename($file,".jpeg")."".$csv_separator;						
						$data.= "/Image2Product/".$file."".$csv_separator;
						$data.= "/Image2Product/".$file."".$csv_separator;
						$data.= "/Image2Product/".$file."".$csv_separator;
						$data.= "0"."".$csv_separator;
						$data.= "1"."".$csv_separator;
						$data.= "Enabled"."" .$csv_separator;
						$data.= "Taxable Goods"."".$csv_separator;
						$data.= "No"."". $csv_separator;
						$data.= '"Catalog, Search"'."".$csv_separator;
						$data.= "Yes"."".$csv_separator;
						$data.= "1"."".$csv_separator;
						$data.= "1"."".$csv_terminated;
						}
					if($extension == 'png'){
						//echo "<pre>";
						$data.= "admin"."".$csv_separator;
						$data.= "base"."".$csv_separator;
						$data.= "Default"."".$csv_separator;
						$data.= "simple"."".$csv_separator;
						$data.= basename($file,".png")."".$csv_separator;
						$data.= "0"."".$csv_separator;
						$data.= basename($file,".png")."".$csv_separator;
						$data.= basename($file,".png")."".$csv_separator;
						$data.= basename($file,".png")."".$csv_separator;						
						$data.= "/Image2Product/".$file."".$csv_separator;
						$data.= "/Image2Product/".$file."".$csv_separator;
						$data.= "/Image2Product/".$file."".$csv_separator;
						$data.= "0"."".$csv_separator;
						$data.= "1"."".$csv_separator;
						$data.= "Enabled"."" .$csv_separator;
						$data.= "Taxable Goods"."".$csv_separator;
						$data.= "No"."". $csv_separator;
						$data.= '"Catalog, Search"'."".$csv_separator;
						$data.= "Yes"."".$csv_separator;
						$data.= "1"."".$csv_separator;
						$data.= "1"."".$csv_terminated;
						}
					if($extension == 'gif'){
						//echo "<pre>";
						$data.= "admin"."".$csv_separator;
						$data.= "base"."".$csv_separator;
						$data.= "Default"."".$csv_separator;
						$data.= "simple"."".$csv_separator;
						$data.= basename($file,".gif")."".$csv_separator;
						$data.= "0"."".$csv_separator;
						$data.= basename($file,".gif")."".$csv_separator;
						$data.= basename($file,".gif")."".$csv_separator;
						$data.= basename($file,".gif")."".$csv_separator;						
						$data.= "/Image2Product/".$file."".$csv_separator;
						$data.= "/Image2Product/".$file."".$csv_separator;
						$data.= "/Image2Product/".$file."".$csv_separator;
						$data.= "0"."".$csv_separator;
						$data.= "1"."".$csv_separator;
						$data.= "Enabled"."" .$csv_separator;
						$data.= "Taxable Goods"."".$csv_separator;
						$data.= "No"."". $csv_separator;
						$data.= '"Catalog, Search"'."".$csv_separator;
						$data.= "Yes"."".$csv_separator;
						$data.= "1"."".$csv_separator;
						$data.= "1"."".$csv_terminated;
						}
				}
			}
			$media_csv = Mage::getBaseDir().'/media/import/';
			$fp = fopen($media_csv."Image2Products.csv", "w");
				
			fputs($fp, rtrim($data));
				
			fclose($fp);
			
			$csv_directory = Mage::getBaseDir().'/var/import/';
			
			$fp2 = fopen($csv_directory."Image2Products.csv", "w");
				
			fputs($fp2, rtrim($data));
				
			fclose($fp2);

			Mage::getSingleton("adminhtml/session")->addSuccess("Images2Product.CSV Generated Successfully.");
			$this->_redirect("*/*/new");
}

	 
	public function insertinpopupAction(){	
    	$url = $this->getUrl("*admin/system_convert_gui/run/", array("id" => 3, "files" => "Image2Products.csv" ));
		$url = str_replace("*admin","idealAdmin", $url);
		?>		
			<script type="text/javascript">
				window.location = "<?php echo $url ?>";
			</script>
		<?php
	} 
	
	
	public function reindexAction()
	{
									
			Mage::getSingleton("adminhtml/session")->addSuccess($count." Diamond(s) Inserted.");
			$this->_redirect("*/*/new");
	}
	
 	public function inventoryupdateAction()
	{
	
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam("id") > 0 ) {
			try {
				$model = Mage::getModel("Image2Product/Image2Product");
				 
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
        $Image2ProductIds = $this->getRequest()->getParam("Image2Product");
        if(!is_array($Image2ProductIds)) {
			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("Please select item(s)"));
        } else {
            try {
                foreach ($Image2ProductIds as $Image2ProductId) {
                    $Image2Product = Mage::getModel("Image2Product/Image2Product")->load($Image2ProductId);
                    $Image2Product->delete();
                }
                Mage::getSingleton("adminhtml/session")->addSuccess(
                    Mage::helper("adminhtml")->__(
                        "Total of %d record(s) were successfully deleted", count($Image2ProductIds)
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
        $Image2ProductIds = $this->getRequest()->getParam("Image2Product");
        if(!is_array($Image2ProductIds)) {
            Mage::getSingleton("adminhtml/session")->addError($this->__("Please select item(s)"));
        } else {
            try {
                foreach ($Image2ProductIds as $Image2ProductId) {
                    $Image2Product = Mage::getSingleton("Image2Product/Image2Product")
                        ->load($Image2ProductId)
                        ->setStatus($this->getRequest()->getParam("status"))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__("Total of %d record(s) were successfully updated", count($Image2ProductIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect("*/*/index");
    }
  
    public function exportCsvAction()
    {
        $fileName   = "Image2Products.csv";
        $content    = $this->getLayout()->createBlock("Image2Product/adminhtml_Image2Product_grid")
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = "Image2Product.xml";
        $content    = $this->getLayout()->createBlock("Image2Product/adminhtml_Image2Product_grid")
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
    protected function _isAllowed()
    {
    	return Mage::getSingleton('admin/session')->isAllowed('catalog/image2product');
    }
}
?>
