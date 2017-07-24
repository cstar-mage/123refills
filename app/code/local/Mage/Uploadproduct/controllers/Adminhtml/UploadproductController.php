<?php

class Mage_Uploadproduct_Adminhtml_UploadproductController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('uploadproduct/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Items Manager'), Mage::helper('adminhtml')->__('Item Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('uploadproduct/uploadproduct')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('uploadproduct_data', $model);

			$this->loadLayout();
			$this->_setActiveMenu('uploadproduct/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('uploadproduct/adminhtml_uploadproduct_edit'))
				->_addLeft($this->getLayout()->createBlock('uploadproduct/adminhtml_uploadproduct_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('uploadproduct')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			if(isset($_FILES["filename"]["name"]) && $_FILES["filename"]["name"] != "") {
				try {	
					$uploader = new Varien_File_Uploader("filename");
					
	           		$uploader->setAllowedExtensions(array("csv"));
					$uploader->setAllowRenameFiles(false);
					$uploader->setFilesDispersion(false);
							
					$path = Mage::getBaseDir("var") . DS ."import" . DS;
					//$uploader->save($path, $_FILES["filename"]["name"] );
					$uploader->save($path, "upload_all_product.csv" );
					Mage::getSingleton("adminhtml/session")->addSuccess("CSV file Uploaded successfully.");
				} 
				catch (Exception $e){
		      			Mage::getSingleton("adminhtml/session")->addError(Mage::helper("adminhtml")->__("File not uploaded"));
						$this->_redirect("*/*/new");
						return;
		        }
			
				/* try{
					$sitePath = Mage::getBaseUrl(Mage_Core_Model_Store::URL_TYPE_WEB);
					
					$fp = fopen($path.$_FILES["filename"]["name"],"r") or die("can't open file");
					
					copy($path.$_FILES["filename"]["name"], $path."upload_all_product.csv");
	
					Mage::getSingleton("adminhtml/session")->addSuccess("CSV file Uploaded successfully.");
				}
				
				catch (Exception $e) {
					Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
            	} */
            	
            	$this->_redirect("*/*/new");
            	return;
            	
			}
		}
		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('uploadproduct')->__('Unable to find file to upload'));
		$this->_redirect('*/*/new');
	}
	
	
	public function insertinpopupAction()
	{
		
    	$url = $this->getUrl("*admin/system_convert_gui/run/", array("id" => 3, "files" => "upload_all_product.csv" ));
		$url = str_replace("*admin","idealAdmin", $url);
		?>		
			<script type="text/javascript">
				window.location = "<?php echo $url ?>";
			</script>
		<?php 

	} 
	 
		public function deleteAction() {
			if( $this->getRequest()->getParam('id') > 0 ) {
				try {
					$model = Mage::getModel('uploadproduct/uploadproduct');
					 
					$model->setId($this->getRequest()->getParam('id'))
						->delete();
						 
					Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Item was successfully deleted'));
					$this->_redirect('*/*/');
				} catch (Exception $e) {
					Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
					$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
				}
			}
			$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $uploadproductIds = $this->getRequest()->getParam('uploadproduct');
        if(!is_array($uploadproductIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($uploadproductIds as $uploadproductId) {
                    $uploadproduct = Mage::getModel('uploadproduct/uploadproduct')->load($uploadproductId);
                    $uploadproduct->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($uploadproductIds)
                    )
                );
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
	
    public function massStatusAction()
    {
        $uploadproductIds = $this->getRequest()->getParam('uploadproduct');
        if(!is_array($uploadproductIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($uploadproductIds as $uploadproductId) {
                    $uploadproduct = Mage::getSingleton('uploadproduct/uploadproduct')
                        ->load($uploadproductId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($uploadproductIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'uploadproduct.csv';
        $content    = $this->getLayout()->createBlock('uploadproduct/adminhtml_uploadproduct_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'uploadproduct.xml';
        $content    = $this->getLayout()->createBlock('uploadproduct/adminhtml_uploadproduct_grid')
            ->getXml();

        $this->_sendUploadResponse($fileName, $content);
    }

    protected function _sendUploadResponse($fileName, $content, $contentType='application/octet-stream')
    {
        $response = $this->getResponse();
        $response->setHeader('HTTP/1.1 200 OK','');
        $response->setHeader('Pragma', 'public', true);
        $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);
        $response->setHeader('Content-Disposition', 'attachment; filename='.$fileName);
        $response->setHeader('Last-Modified', date('r'));
        $response->setHeader('Accept-Ranges', 'bytes');
        $response->setHeader('Content-Length', strlen($content));
        $response->setHeader('Content-type', $contentType);
        $response->setBody($content);
        $response->sendResponse();
        die;
    }
    protected function _isAllowed()
    {
    	return Mage::getSingleton('admin/session')->isAllowed('catalog/uploadproduct');
    }
}
