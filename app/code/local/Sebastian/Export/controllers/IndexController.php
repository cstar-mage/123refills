<?php

/**
 *
 * Copyright Sebastian Enzinger <sebastian@enzinger.de> www.sebastian-enzinger.de
 *
 * All rights reserved.
 *
**/

class Sebastian_Export_indexController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction() {
      if (!extension_loaded('xsl')) {
        Mage::getSingleton('adminhtml/session')->addWarning($this->__('Could not find PHP XSL-Extension. Please refer to <a href="http://www.adobe.com/devnet/dreamweaver/articles/config_php_xslt_07.html" target="_blank">this link</a> to install XSL support, or contact your server administrator to install php5-xsl and/or libxslt 1.1'));
      }
      if (!@class_exists('XSLTProcessor')) {
        Mage::getSingleton('adminhtml/session')->addWarning($this->__('Could not find PHP XSLTProcessor. Please refer to <a href="http://www.adobe.com/devnet/dreamweaver/articles/config_php_xslt_07.html" target="_blank">this link</a> to install XSL support, or contact your server administrator to install php5-xsl and/or libxslt 1.1'));
      }
      $this->loadLayout();
      $this->renderLayout();
    }
    
    public function postAction() {
      $request = $this->getRequest();
      $post = $request->getPost();

      if (empty($post)) {
        Mage::getSingleton('adminhtml/session')->addError($this->__('Invalid form data.'));
        $this->_redirect('*');
        return;
      }
      $start = $request->getPost('start', Mage::helper('export')->getLastExportedOrder());
      if ($start == 0) $start = 1;
      $end = $request->getPost('end', 0);
      $type = $request->getPost('type', 'xml');
      $datefrom = $request->getPost('from', null);
      $dateto = $request->getPost('to', null);

      try {
        $exportid = Mage::getModel('export/export')->export($type, (int)$start, (int)$end, $datefrom, $dateto, ($request->getPost('startdownload'))?false:true, false);
      } catch (Exception $e) {
        Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
      }

      if ($request->getPost('startdownload') && !empty($exportid)) {
        $this->_redirect('*/*/get/export_id/'.(int)$exportid);
      } else {
        $this->_redirect('*');
      }
    }


    public function getAction() {
      $response = $this->getResponse();
      $id = $this->getRequest()->getParam('export_id');
      $export = Mage::getModel('export/export')->load($id);
      $types = Mage::helper('export')->getExportTypes();

      $files = $export->getFiles();
      $displayfiles = $export->getDisplayfiles();
      $files = explode(",", $files);
      $displayfiles = explode(",", $displayfiles);
      if (count($files) > 1) {
        if (!@class_exists('ZipArchive')) {
          $this->_getSession()->addError($this->__('PHP Zip extension not found'));
          $this->_redirect('*');
          return;
        }
        $zip = new ZipArchive();
        $zipfile = Mage::helper('export')->getBaseDir()."/export/order_export.zip";
        if (file_exists($zipfile)) {
          @unlink($zipfile);
        }
        if ($zip->open($zipfile, ZIPARCHIVE::CREATE)!==TRUE) {
          $this->_getSession()->addError($this->__('Could not open '.$zipfile));
          $this->_redirect('*');
          return;
        }
        $i = 0;
        foreach ($files as $file) {
          if (file_exists(Mage::helper('export')->getBaseDir().$file)) {
            if (isset($displayfiles[$i])) $outf = $displayfiles[$i]; else $outf = $file;
            $zip->addFile(Mage::helper('export')->getBaseDir().$file, $outf);
          }        
          $i++;
        }
        $zip->close();
        $file = $zipfile;
        $filename = $id."_order_export.zip";
        $response->setHeader('Content-type', 'application/zip');
      } else {
        if (isset($files[0])) {
          $file = Mage::helper('export')->getBaseDir().$files[0];
          if (isset($displayfiles[0])) $filename = $displayfiles[0]; else $filename = $files[0];
          if ($export->getType()) {
            if ($types[$export->getType()]['content-type'] == 'vary') {
              $response->setHeader('Vary', 'Accept');
            } else {
              $response->setHeader('Content-type', $types[$export->getType()]['content-type']."; charset=UTF-8");
            }
          }
        } else {
          Mage::getSingleton('adminhtml/session')->addError($this->__('File does not exist.'));
          $this->_redirect('*');
        }
      }
      if (!empty($file) && $filename != '') {
        if (file_exists($file)) {
          $content = file_get_contents($file);

          $response->setHeader('HTTP/1.1 200 OK','');

          $response->setHeader('Pragma', 'public', true);
          $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);

          $response->setHeader('Content-Disposition', 'attachment; filename='.$filename);
          $response->setHeader('Last-Modified', date('r'));
          $response->setHeader('Accept-Ranges', 'bytes');
          $response->setHeader('Content-Length', strlen($content));
          $response->setBody($content);
          $response->sendResponse();
          $export->setDownloaded(1)->save();
          die();
        } else {
          Mage::getSingleton('adminhtml/session')->addError($this->__('File does not exist anymore on the webserver.'));
          $this->_redirect('export');
        }
      } else {
        Mage::getSingleton('adminhtml/session')->addError($this->__('No file given to export.'));
        $this->_redirect('export');
      }
    }



    // Grid Stuff
    public function gridAction() {
      $this->getResponse()->setBody($this->getLayout()->createBlock('export/grid_grid')->toHtml());
    }

    public function deleteAction() {
      if ($id = $this->getRequest()->getParam('export_id')) {
        $export = Mage::getModel('export/export')->setId((int)$id)->load((int)$id);
        if (!$export) {
          $this->_getSession()->addError('Could not load export_id');
          $this->getResponse()->setRedirect($this->getUrl('*'));
          return;
        }

        try {
          $files = explode(",", $export->getFiles());
          foreach ($files as $file) {
            if (file_exists(Mage::helper('export')->getBaseDir().$file)) @unlink(Mage::helper('export')->getBaseDir().$file);
          }
          $export->delete();
          $this->_getSession()->addSuccess($this->__('Export deleted'));
        }
        catch (Exception $e){
          $this->_getSession()->addError($e->getMessage());
        }
      }
      $this->getResponse()->setRedirect($this->getUrl('*'));
    }

    public function massDeleteAction() {
      $exportIds = $this->getRequest()->getParam('export');
      if (!is_array($exportIds)) {
        $this->_getSession()->addError($this->__('Please select export(s)'));
      }
      else {
        try {
          foreach ($exportIds as $exportId) {
            $export = Mage::getSingleton('export/export')->load((int)$exportId);
            if (!$export) {
              $this->_getSession()->addError('Could not load export_id');
              $this->getResponse()->setRedirect($this->getUrl('*'));
              return;
            }
            $files = explode(",", $export->getFiles());
            foreach ($files as $file) {
              if (file_exists(Mage::helper('export')->getBaseDir().$file)) @unlink(Mage::helper('export')->getBaseDir().$file);
            }
            $export->delete();
          }
          $this->_getSession()->addSuccess($this->__('Total of %d record(s) were successfully deleted', count($exportIds)));
        } catch (Exception $e) {
          $this->_getSession()->addError($e->getMessage());
        }
      }
      $this->_redirect('*');
    }

    public function massDownloadAction() {
      $exportIds = $this->getRequest()->getParam('export');
      if (!is_array($exportIds)) {
        $this->_getSession()->addError($this->__('Please select export(s)'));
      }
      else {
        if (!@class_exists('ZipArchive')) {
          $this->_getSession()->addError($this->__('PHP Zip extension not found'));
          $this->_redirect('*');
          return;
        }
        $zip = new ZipArchive();
        $filename = Mage::helper('export')->getBaseDir()."/export/order_export.zip";
        if (file_exists($filename)) {
          @unlink($filename);
        }
        if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
          $this->_getSession()->addError($this->__('Could not open '.$filename));
          $this->_redirect('*');
          return;
        }
        try {
          foreach ($exportIds as $exportId) {
            $export = Mage::getSingleton('export/export')->load((int)$exportId);
            if (!$export) {
              $this->_getSession()->addError('Could not load export_id');
              $this->getResponse()->setRedirect($this->getUrl('*'));
              return;
            }
            $files = explode(",", $export->getFiles());
            $displayfiles = explode(",", $export->getDisplayfiles());
            $i = 0;
            foreach ($files as $file) {
              if (file_exists(Mage::helper('export')->getBaseDir().$file)) {
                if (isset($displayfiles[$i])) $outf = $displayfiles[$i]; else $outf = $file;
                $zip->addFile(Mage::helper('export')->getBaseDir().$file, $exportId."_".$outf);
              }
              $i++;
            }
          }
          $zip->close();

          if (file_exists($filename)) {
            $content = file_get_contents($filename);

            $response = $this->getResponse();
            $response->setHeader('HTTP/1.1 200 OK','');

            $response->setHeader('Pragma', 'public', true);
            $response->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true);

            $response->setHeader('Content-Disposition', 'attachment; filename=order_export.zip');
            $response->setHeader('Last-Modified', date('r'));
            $response->setHeader('Accept-Ranges', 'bytes');
            $response->setHeader('Content-Length', strlen($content));
            $response->setHeader('Content-type', 'application/zip');
            $response->setBody($content);
            $response->sendResponse();
            die();
          } else {
            $this->_getSession()->addError($this->__('Zip creation failed'));
          }
        } catch (Exception $e) {
          $this->_getSession()->addError($e->getMessage());
        }
      }
      $this->_redirect('*');
    }


    public function changeLocaleAction()
    {
        $locale = $this->getRequest()->getParam('locale');
        if ($locale) {
            Mage::getSingleton('adminhtml/session')->setLocale($locale);
        }
        $this->_redirectReferer();
    }

}
