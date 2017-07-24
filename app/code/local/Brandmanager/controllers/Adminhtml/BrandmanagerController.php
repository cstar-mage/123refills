<?php

class Ideal_Brandmanager_Adminhtml_BrandmanagerController extends Mage_Adminhtml_Controller_Action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('brandmanager/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Brand Manager'), Mage::helper('adminhtml')->__('Brand Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_title($this->__('Brandmanager'))
			->_title($this->__('Manage Brand'));
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('id');
		$model  = Mage::getModel('brandmanager/brandmanager')->load($id);

		if ($model->getId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$model->setData($data);
			}

			Mage::register('brandmanager_data', $model);
			
			$this->_title($this->__('Brandmanager'))
				->_title($this->__('Manage Brand'));
			if ($model->getId()){
				$this->_title($model->getTitle());
			}else{
				$this->_title($this->__('New Brand'));
			}

			$this->loadLayout();
			$this->_setActiveMenu('brandmanager/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item Manager'), Mage::helper('adminhtml')->__('Item Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Item News'), Mage::helper('adminhtml')->__('Item News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			$this->_addContent($this->getLayout()->createBlock('brandmanager/adminhtml_brandmanager_edit'))
				->_addLeft($this->getLayout()->createBlock('brandmanager/adminhtml_brandmanager_edit_tabs'));

			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brandmanager')->__('Item does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function newAction() {
		$this->_forward('edit');
	}
	
	protected function _initItem(){
		if (!Mage::registry('brandmanager_categories')){
			if ($this->getRequest()->getParam('id')){
				Mage::register('brandmanager_categories',
					Mage::getModel('brandmanager/brandmanager')
					->load($this->getRequest()->getParam('id'))->getCategories());
			}
		}
	}
	
	public function categoriesAction(){
		$this->_initItem();
		$this->getResponse()->setBody(
            $this->getLayout()->createBlock('brandmanager/adminhtml_brandmanager_edit_tab_categories')->toHtml()
        );
	}
	public function categoriesJsonAction()
    {
		$this->_initItem();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('brandmanager/adminhtml_brandmanager_edit_tab_categories')
                ->getCategoryChildrenJson($this->getRequest()->getParam('category'))
        );
    }
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			if($data['filename']['delete']==1){
				$data['filename']='';
			}
			elseif(is_array($data['filename'])){
				$data['filename']=$data['filename']['value'];
			}
			
			if(isset($_FILES['filename']['name']) && $_FILES['filename']['name'] != '') {
				try {	
					/* Starting upload */	
					$uploader = new Varien_File_Uploader('filename');
					
					// Any extention would work
	           		$uploader->setAllowedExtensions(array('jpg','jpeg','gif','png'));
					$uploader->setAllowRenameFiles(false);
					
					// Set the file upload mode 
					// false -> get the file directly in the specified folder
					// true -> get the file in the product like folders 
					//	(file.jpg will go in something like /media/f/i/file.jpg)
					$uploader->setFilesDispersion(false);
							
					// We set media as the upload dir
					$path = Mage::getBaseDir('media') . DS . "brandmanager" . DS ;
					$result = $uploader->save($path, $_FILES['filename']['name'] );
					$data['filename'] = $result['file'];
					
					$data['filename'] = "brandmanager/".$data['filename'];
					
				} catch (Exception $e) {
					$data['filename'] = $_FILES['filename']['name'];
		        }
			}
	  			
			$model = Mage::getModel('brandmanager/brandmanager');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}
				
				$model->setStores(implode(',',$data['stores']));
				if(Mage::app()->isSingleStoreMode()){
					$model->setStores(Mage::app()->getStore(true)->getId());
				}
				if (isset($data['category_ids'])){
					$model->setCategories(implode(',',array_unique(explode(',',$data['category_ids']))));
				}
				
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('brandmanager')->__('Item was successfully saved'));
				Mage::getSingleton('adminhtml/session')->setFormData(false);

				if ($this->getRequest()->getParam('back')) {
					$this->_redirect('*/*/edit', array('id' => $model->getId()));
					return;
				}
				$this->_redirect('*/*/');
				return;
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                Mage::getSingleton('adminhtml/session')->setFormData($data);
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('brandmanager')->__('Unable to find item to save'));
        $this->_redirect('*/*/');
	}
 
	public function deleteAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('brandmanager/brandmanager');
				 
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
        $brandmanagerIds = $this->getRequest()->getParam('brandmanager');
        if(!is_array($brandmanagerIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select item(s)'));
        } else {
            try {
                foreach ($brandmanagerIds as $brandmanagerId) {
                    $brandmanager = Mage::getModel('brandmanager/brandmanager')->load($brandmanagerId);
                    $brandmanager->delete();
                }
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($brandmanagerIds)
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
        $brandmanagerIds = $this->getRequest()->getParam('brandmanager');
        if(!is_array($brandmanagerIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select item(s)'));
        } else {
            try {
                foreach ($brandmanagerIds as $brandmanagerId) {
                    $brandmanager = Mage::getSingleton('brandmanager/brandmanager')
                        ->load($brandmanagerId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($brandmanagerIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
        $fileName   = 'brandmanager.csv';
        $content    = $this->getLayout()->createBlock('brandmanager/adminhtml_brandmanager_grid')
            ->getCsv();

        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'brandmanager.xml';
        $content    = $this->getLayout()->createBlock('brandmanager/adminhtml_brandmanager_grid')
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
}
