<?php
class Mage_Uploadtool_Adminhtml_DiamondinquiriesController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {  
        // Let's call our initAction method which will set some basic params for each action
        $this->_initAction()
            ->renderLayout();
    }  
     
    public function newAction()
    {  
        // We just forward the new action to a blank edit form
        $this->_forward('edit');
    }  
     
    public function deleteAction() {
    	if( $this->getRequest()->getParam('id') > 0 ) {
    		try {
    			$model = Mage::getModel('uploadtool/diamondinquiries');
    				
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
    
    public function editAction()
    {  
        $this->_initAction();
     
        // Get id if available
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('uploadtool/diamondinquiries');

        if ($id) {
            // Load record
            $model->load($id);
            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This Diamondinquiries no longer exists.'));
                $this->_redirect('*/*/');
     
                return;
            }  
        }  
     
        $this->_title($model->getId() ? $model->getName() : $this->__('New Diamondinquiries'));
     
        $data = Mage::getSingleton('adminhtml/session')->getBazData(true);
        if (!empty($data)) {
            $model->setData($data);
        }  
     
        Mage::register('uploadtool', $model);
     
        $this->_initAction()
            ->_addBreadcrumb($id ? $this->__('Edit Diamondinquiries') : $this->__('New Diamondinquiries'), $id ? $this->__('Edit Diamondinquiries') : $this->__('New Diamondinquiries'))
            ->_addContent($this->getLayout()->createBlock('uploadtool/adminhtml_diamondinquiries_edit')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
    }
     
    public function saveAction()
    {
        if ($postData = $this->getRequest()->getPost()) {
            $model = Mage::getSingleton('uploadtool/diamondinquiries');
            $model->setData($postData);
 
            try {
                $model->save();
 
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The Diamondinquiries has been saved.'));
                $this->_redirect('*/*/');
 
                return;
            }  
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this baz.'));
            }
 
            Mage::getSingleton('adminhtml/session')->setBazData($postData);
            $this->_redirectReferer();
        }
    }
     
    public function massDeleteAction() {
    	$quickcontactIds = $this->getRequest()->getParam('diamondinquiries');

    	if(!is_array($quickcontactIds)) {
    		Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
    	} else {
    		try {
    			foreach ($quickcontactIds as $quickcontactId) {
    				$quickcontact = Mage::getModel('uploadtool/diamondinquiries')->load($quickcontactId);
    				$quickcontact->delete();
    			}
    			Mage::getSingleton('adminhtml/session')->addSuccess(
    					Mage::helper('adminhtml')->__(
    							'Total of %d record(s) were successfully deleted', count($quickcontactIds)
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
    	$quickcontactIds = $this->getRequest()->getParam('diamondinquiries');
    	if(!is_array($quickcontactIds)) {
    		Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
    	} else {
    		try {
    			foreach ($quickcontactIds as $quickcontactId) {
    				$quickcontact = Mage::getSingleton('uploadtool/diamondinquiries')
    				->load($quickcontactId)
    				->setStatus($this->getRequest()->getParam('status'))
    				->setIsMassupdate(true)
    				->save();
    			}
    			$this->_getSession()->addSuccess(
    					$this->__('Total of %d record(s) were successfully updated', count($quickcontactIds))
    			);
    		} catch (Exception $e) {
    			$this->_getSession()->addError($e->getMessage());
    		}
    	}
    	$this->_redirect('*/*/index');
    }
    /*
    public function exportCsvAction()
    {
    	$fileName   = 'dolphincontact.csv';
    	$content    = $this->getLayout()->createBlock('dolphincontact/adminhtml_dolphincontact_grid')
    	->getCsv();
    
    	$this->_sendUploadResponse($fileName, $content);
    }
    
    public function exportXmlAction()
    {
    	$fileName   = 'dolphincontact.xml';
    	$content    = $this->getLayout()->createBlock('dolphincontact/adminhtml_dolphincontact_grid')
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
    }*/
   /* public function messageAction()
    {
        $data = Mage::getModel('uploadtool/diamondinquiries')->load($this->getRequest()->getParam('id'));
        echo $data->getContent();
    }
     */
    /**
     * Initialize action
     *
     * Here, we set the breadcrumbs and the active menu
     *
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction()
    {
      $this->loadLayout()
			//->_setActiveMenu("uploadtool/items")
			->_addBreadcrumb(Mage::helper("adminhtml")->__("Items Manager"), Mage::helper("adminhtml")->__("Item Manager"));
		
		return $this;
    }
     
    /**
     * Check currently called action by permissions for current user
     *
     * @return bool
     */
   /* protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/foo_bar_baz');
    }*/
    protected function _isAllowed()
    {
    	return Mage::getSingleton('admin/session')->isAllowed('jewelryshare/uploadtoolitems');
    }
}
