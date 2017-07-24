<?php

class Ideal_Taskproduction_Adminhtml_TaskproductionController extends Mage_Adminhtml_Controller_action
{

	protected function _initAction() {
		$this->loadLayout()
			->_setActiveMenu('taskproduction/items')
			->_addBreadcrumb(Mage::helper('adminhtml')->__('Task Productions Manager'), Mage::helper('adminhtml')->__('Task Production Manager'));
		
		return $this;
	}   
 
	public function indexAction() {
		$this->_initAction()
			->renderLayout();
	}

	public function editAction() {
		$id     = $this->getRequest()->getParam('task_id');
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		// Set the parameter
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'task_id='.$id.'&siteurl='.str_replace("www.","",$_SERVER['HTTP_HOST']));
		// Set the url
		
		curl_setopt($ch, CURLOPT_URL,'http://production.idealbrandmarketing.com/magento/tasklist.php');
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);
		//echo $result; exit;
		//echo "<pre>"; print_r(json_decode($result, true)); exit;
		/*$model = new Varien_Data_Collection();
		$model->addItem(new Varien_Object(json_decode($result, true)));*/
		$model = new Varien_Data_Collection();
		$modelobj = new Varien_Object();
		
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,'http://production.idealbrandmarketing.com/magento/task_status_list.php');
		// Execute
		$resultstatus=curl_exec($ch);
		// Closing
		curl_close($ch);
		
		foreach (json_decode($result, true) as $data1) {
			//print_r($data1);
			//$model->addItem(new Varien_Object($data1));
			$modelobj->setData($data1);
		}
		$status_code = array_search($modelobj->getTaskStatus(), json_decode($resultstatus, true));
		$modelobj->setTaskStatus($status_code);
		//echo "<pre>"; print_r($modelobj); echo "</pre>";
		//$model  = Mage::getModel('taskproduction/taskproduction')->load($id);
		if ($modelobj->getTaskId() || $id == 0) {
			$data = Mage::getSingleton('adminhtml/session')->getFormData(true);
			if (!empty($data)) {
				$modelobj->setData($data);
			}
			Mage::register('taskproduction_data', $modelobj);

			$this->loadLayout();
			$this->_setActiveMenu('taskproduction/items');

			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Task Production Manager'), Mage::helper('adminhtml')->__('Task Production Manager'));
			$this->_addBreadcrumb(Mage::helper('adminhtml')->__('Task Production News'), Mage::helper('adminhtml')->__('Task Production News'));

			$this->getLayout()->getBlock('head')->setCanLoadExtJs(true);

			//$this->_addContent($this->getLayout()->createBlock('taskproduction/adminhtml_taskproduction_edit'));
			//$this->_addLeft($this->getLayout()->createBlock('taskproduction/adminhtml_taskproduction_edit_tabs'));
			//$this->_addLeft($this->getLayout()->createBlock('taskproduction/adminhtml_taskproduction_edit_tab_leftreplysubmit'));
			//$this->_addContent($this->getLayout()->createBlock('taskproduction/adminhtml_taskproduction_edit_tab_leftreplysubmit'));
			
			$this->renderLayout();
		} else {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('taskproduction')->__('Task Production does not exist'));
			$this->_redirect('*/*/');
		}
	}
 
	public function submitStatusAction(){
		$ch = curl_init();
		// Disable SSL verification
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		// Will return the response, if false it print the response
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_URL,'http://production.idealbrandmarketing.com/magento/task_status_list.php');
		// Execute
		$result=curl_exec($ch);
		// Closing
		curl_close($ch);
		$statuslist = json_decode($result, true);
		$data = $this->getRequest()->getParams();
		$data['statuscode'] = $statuslist[$data['statuscode']];
		//echo $data['statuscode']; exit;
		//echo "<pre>"; print_r($data); print_r($this->getRequest()->getParams()); exit;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, 'task_id='.$data['task_id'].'&statuscode='.$data['statuscode'].'&siteurl='.str_replace("www.","",$_SERVER['HTTP_HOST']));
		curl_setopt($ch, CURLOPT_URL,'http://production.idealbrandmarketing.com/magento/submit_status.php');
		$resultstatus=curl_exec($ch);
		curl_close($ch);
		//echo "<pre>"; print_r(json_decode($resultstatus, true)); exit;
		if(json_decode($resultstatus, true) == 1)
		{
			Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('taskproduction')->__('Ticket saved successfully'));
		}
		else
		{
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('taskproduction')->__('Ticket not saved successfully'));
		}
		$this->getResponse()->setRedirect($this->_getRefererUrl());
		//echo "<pre>"; print_r(json_decode($result, true)); exit;
		//echo json_decode($result, true); exit;
	}
	public function insertClientReplyAction() {
		if ($data = $this->getRequest()->getParams())
		{		
			$imgarrserch = array('name');
			$imgcomment = array();
			$i = 0;
			foreach($_FILES as $filekey => $filevalue)
			{
				foreach($filevalue as $filevaluekey => $filevaluevalue)
				{
					if(in_array($filevaluekey,$imgarrserch))
					{
						//echo "<pre>"; echo $filevaluekey."<br />"; print_r($filevaluevalue); echo "</pre>";
						foreach($filevaluevalue as $filevaluevaluekey => $filevaluevaluevalue)
						{
							if($filevaluevaluevalue){
								$imgcomment[$filevaluekey][] = $filevaluevaluevalue;
							}
						}
						$i++;
					}
				}
			}
			
			$file = new Varien_Io_File();
			$importReadyDirResult = $file->mkdir(Mage::getBaseDir('media').DS.'production');
			for($i=0;$i<5;$i++)
			{
				$target_file = Mage::getBaseDir('media').DS.'production'.DS.$_FILES['comment_img_box']['name'][$i];
				move_uploaded_file($_FILES['comment_img_box']['tmp_name'][$i], $target_file);
			}
			$fields = array(
					'task_id' => $data['task_id'],
					'comment' => $data['comments_box'],
					'siteurl' => str_replace("index.php/","",$this->getUrl()),
					'images' => $_FILES['comment_img_box']['name']
			);
			$fields_string = http_build_query($fields);
			
			//echo "<pre>"; print_r($data); echo "</pre>"; exit;
			$headers = array("Content-Type:multipart/form-data");
			$ch = curl_init();
			// Disable SSL verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// Will return the response, if false it print the response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// Set the parameter
			//curl_setopt($ch, CURLOPT_POSTFIELDS, "task_id=".$data['task_id']."&comment=".$data['comments_box']);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
			//curl_setopt($ch, CURLOPT_HEADER, true);
			//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_INFILESIZE, $imgcomment['size']);
			// Set the url
			curl_setopt($ch, CURLOPT_URL,'http://production.idealbrandmarketing.com/magento/replycomment.php');
			// Execute
			$result=curl_exec($ch);
			// Closing
			curl_close($ch);
			//echo "<pre>"; print_r(json_decode($result, true)); exit;
			if(json_decode($result, true) == 0)
			{
				//echo "<pre>"; print_r(json_decode($result, true)); exit;
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('taskproduction')->__('invalid comment'));
			}
			else
			{
				
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('comment successfully saved'));
			}
			for($i=0;$i<5;$i++)
			{
					unlink(Mage::getBaseDir('media').DS.'production'.DS.$_FILES['comment_img_box']['name'][$i]);
			}
			$this->getResponse()->setRedirect($this->_getRefererUrl());
		}
	}
	
	public function editinsertClientReplyAction()
	{

		if ($data = $this->getRequest()->getParams())
		{
			$imgarrserch = array('name');
			$imgcomment = array();
			$i = 0;
			foreach($_FILES as $filekey => $filevalue)
			{
				foreach($filevalue as $filevaluekey => $filevaluevalue)
				{
					if(in_array($filevaluekey,$imgarrserch))
					{
						//echo "<pre>"; echo $filevaluekey."<br />"; print_r($filevaluevalue); echo "</pre>";
						foreach($filevaluevalue as $filevaluevaluekey => $filevaluevaluevalue)
						{
							if($filevaluevaluevalue){
								$imgcomment[$filevaluekey][] = $filevaluevaluevalue;
							}
						}
						$i++;
					}
				}
			}
				
			$file = new Varien_Io_File();
			$importReadyDirResult = $file->mkdir(Mage::getBaseDir('media').DS.'production');
			for($i=0;$i<5;$i++)
			{
				$target_file = Mage::getBaseDir('media').DS.'production'.DS.$_FILES['comment_img_box']['name'][$i];
				move_uploaded_file($_FILES['comment_img_box']['tmp_name'][$i], $target_file);
			}
			//echo "<pre>"; print_r($_FILES['comment_img_box']['name']); exit;
			$fields = array(
					'task_id' => $data['task_id'],
					'comment' => $data['reply_comment_box'],
					'statuscode' => $data['status_box'],
					'siteurl' => str_replace("www.","",$_SERVER['HTTP_HOST']),
					'images' => $_FILES['comment_img_box']['name']
			);
			$fields_string = http_build_query($fields);
						
			//echo "<pre>"; print_r($fields); echo "</pre>"; exit;
			$headers = array("Content-Type:multipart/form-data");
			$ch = curl_init();
			// Disable SSL verification
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			// Will return the response, if false it print the response
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			// Set the parameter
			//curl_setopt($ch, CURLOPT_POSTFIELDS, "task_id=".$data['task_id']."&comment=".$data['comments_box']);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
			//curl_setopt($ch, CURLOPT_HEADER, true);
			//curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($ch, CURLOPT_INFILESIZE, $imgcomment['size']);
			// Set the url
			curl_setopt($ch, CURLOPT_URL,'http://production.idealbrandmarketing.com/magento/editreplycomment.php');
			// Execute
			$result=curl_exec($ch);
			// Closing
			curl_close($ch);
			//echo "<pre>"; print_r(json_decode($result, true)); exit;
			if(json_decode($result, true) == 0)
			{
			//echo "<pre>"; print_r(json_decode($result, true)); exit;
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('taskproduction')->__('invalid comment'));
			}
			else
			{			
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('comment successfully saved'));
			}
			for($i=0;$i<5;$i++)
			{
				unlink(Mage::getBaseDir('media').DS.'production'.DS.$_FILES['comment_img_box']['name'][$i]);
			}
			$this->getResponse()->setRedirect($this->_getRefererUrl());
		}
	}
	
	public function newAction() {
		$this->_forward('edit');
	}
 
	public function saveAction() {
		if ($data = $this->getRequest()->getPost()) {
			
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
					$path = Mage::getBaseDir('media') . DS . 'evolved' ;
					$uploader->save($path, $_FILES['filename']['name'] );
					
				} catch (Exception $e) {
		      
		        }
	        
		        //this way the name is saved in DB
	  			$data['filename'] = 'evolved/'.$_FILES['filename']['name'];
			}
			else 
			{
				if($data['filename']['delete'] == 1)
				{
					//unset($data['login_background_image']);
					//$data['login_background_image']['value'] = "";
					$data['filename'] = "";
				}
				else
				{
					$data['filename'] = $data['filename']['value'];
				}
			}
	  			
	  			
			$model = Mage::getModel('taskproduction/taskproduction');		
			$model->setData($data)
				->setId($this->getRequest()->getParam('id'));
				
			
			try {
				if ($model->getCreatedTime == NULL || $model->getUpdateTime() == NULL) {
					$model->setCreatedTime(now())
						->setUpdateTime(now());
				} else {
					$model->setUpdateTime(now());
				}
				$model->save();
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('taskproduction')->__('Task Production was successfully saved'));
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
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('taskproduction')->__('Unable to find Taskproduction to save'));
        $this->_redirect('*/*/');
	}
	
	public function deleteAction() {
		if ($task_id = $this->getRequest()->getParam("task_id")) {
			
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_POSTFIELDS, 'task_id='.$task_id.'&siteurl='.str_replace("www.","",$_SERVER['HTTP_HOST']));
			curl_setopt($ch, CURLOPT_URL,'http://production.idealbrandmarketing.com/magento/delete_task.php');
			$result=curl_exec($ch);
			curl_close($ch);
			if(json_decode($result, true) == 1)
			{
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('taskproduction')->__('Ticket deleted successfully'));
			}
			else
			{
				Mage::getSingleton('adminhtml/session')->addError(Mage::helper('taskproduction')->__('Ticket not deleted successfully'));
			}
			$this->_redirect('*/*/');
		}
	}
		
	public function deleteBKPAction() {
		if( $this->getRequest()->getParam('id') > 0 ) {
			try {
				$model = Mage::getModel('taskproduction/taskproduction');
				 
				$model->setId($this->getRequest()->getParam('id'))
					->delete();
					 
				Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('Task Production was successfully deleted'));
				$this->_redirect('*/*/');
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
				$this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
			}
		}
		$this->_redirect('*/*/');
	}

    public function massDeleteAction() {
        $taskproductionIds = $this->getRequest()->getParam('taskproduction');

        if(!is_array($taskproductionIds)) {
			Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Please select Taskproduction(s)'));
        } else {
            try {
                /* foreach ($taskproductionIds as $taskproductionId) {
                    $taskproduction = Mage::getModel('taskproduction/taskproduction')->load($taskproductionId);
                    $taskproduction->delete();
                } */
                Mage::getSingleton('adminhtml/session')->addSuccess(
                    Mage::helper('adminhtml')->__(
                        'Total of %d record(s) were successfully deleted', count($taskproductionIds)
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
        $taskproductionIds = $this->getRequest()->getParam('taskproduction');
        if(!is_array($taskproductionIds)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Taskproduction(s)'));
        } else {
            try {
                foreach ($taskproductionIds as $taskproductionId) {
                    $taskproduction = Mage::getSingleton('taskproduction/taskproduction')
                        ->load($taskproductionId)
                        ->setStatus($this->getRequest()->getParam('status'))
                        ->setIsMassupdate(true)
                        ->save();
                }
                $this->_getSession()->addSuccess(
                    $this->__('Total of %d record(s) were successfully updated', count($taskproductionIds))
                );
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }
  
    public function exportCsvAction()
    {
    	//echo "hello"; exit;
        $fileName   = 'taskproduction.csv';
        $content    = $this->getLayout()->createBlock('taskproduction/adminhtml_taskproduction_grid')
            ->getCsv();
		//echo "<pre>"; print_r($content); exit;
        $this->_sendUploadResponse($fileName, $content);
    }

    public function exportXmlAction()
    {
        $fileName   = 'taskproduction.xml';
        $content    = $this->getLayout()->createBlock('taskproduction/adminhtml_taskproduction_grid')
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
    	return Mage::getSingleton('admin/session')->isAllowed('taskproduction');
    }
}
