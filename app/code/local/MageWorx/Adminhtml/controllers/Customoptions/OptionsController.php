<?php

/**
 * MageWorx
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the MageWorx EULA that is bundled with
 * this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.mageworx.com/LICENSE-1.0.html
 *
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@mageworx.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade the extension
 * to newer versions in the future. If you wish to customize the extension
 * for your needs please refer to http://www.mageworx.com/ for more information
 * or send an email to sales@mageworx.com
 *
 * @category   MageWorx
 * @package    MageWorx_Adminhtml
 * @copyright  Copyright (c) 2009 MageWorx (http://www.mageworx.com/)
 * @license    http://www.mageworx.com/LICENSE-1.0.html
 */

/**
 * MageWorx Adminhtml extension
 *
 * @category   MageWorx
 * @package    MageWorx_Adminhtml
 * @author     MageWorx Dev Team <dev@mageworx.com>
 */
class MageWorx_Adminhtml_Customoptions_OptionsController extends Mage_Adminhtml_Controller_Action {

    protected function _init() {
        $sessionStore = Mage::getSingleton('adminhtml/session')->getData('store_id');
        if (!is_null($this->getRequest()->getParam('store'))) {
            Mage::getSingleton('adminhtml/session')->setData('store_id', $this->_getStoreId());
        } elseif (!is_null($sessionStore)) {
            $this->getRequest()->setParam('store', $sessionStore);
        }
        Mage::register('store_id', $this->_getStoreId());
    }

    protected function _getStoreId() {
        if (Mage::app()->isSingleStoreMode()) {
            return Mage::app()->getStore()->getId();
        }
        return Mage::app()->getStore($this->getRequest()->getParam('store', 0))->getId();
    }

    protected function _initAction() {
        $this->loadLayout()
                ->_setActiveMenu('catalog/customoptions')
                ->_addBreadcrumb(
                        $this->__('Custom Options'),
                        $this->__('Custom Options')
        );

        return $this;
    }

    public function indexAction() {
        $this->_init();
        $this->_initAction()->renderLayout();
    }

    protected function _redirect($path, $arguments = array()) {
        $arguments['store'] = $this->_getStoreId();
        parent::_redirect($path, $arguments);
    }

    public function newAction() {
        $this->_forward('edit');
    }

    public function editAction() {        
        $this->_init();
        $id = (int) $this->getRequest()->getParam('group_id');
        $model = Mage::getModel('customoptions/group')->load($id);

        if ($model->getId() || $id == 0) {
            $data = Mage::getSingleton('adminhtml/session')->getFormData(true);
            if (!empty($data)) {
                $model->setData($data);
                if ($id) {
                    $model->setId($id);
                }
            }
                        
            Mage::register('customoptions_data', $model);

            $this->_initAction();
            $this->_addContent($this->getLayout()->createBlock('mageworx/customoptions_options_edit'))
                    ->_addLeft($this->getLayout()->createBlock('mageworx/customoptions_options_edit_tabs'));

            $this->renderLayout();
        } else {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Options do not exist'));
            $this->_redirect('*/*/');
        }
    }

    private function _isEmptyOptions($options) {
        $result = true;
        if ($options && is_array($options)) {
            foreach ($options as $value) {
                if ($value['is_delete'] != 1) {
                    $result = false;
                    break;
                }
            }
        }
        return $result;
    }

    private function _prepareOptions($options, $groupId) {                
        
        if ($options && is_array($options)) {
            // is_delete + sort_order            
            $optionPrepare = array();
            foreach ($options as $key => $value) {
                
                // option
                $options[$key]['previous_type'] = $value['type'];
                if ($value['is_delete'] != 1) {                   
                    $sortOrder = substr('00000000'.$value['sort_order'], -8).'_'.$key;
                    
                    if (isset($value['id']) && ($value['type']=='field' || $value['type']=='area')) {
                        if (Mage::helper('customoptions')->isCustomOptionsFile($groupId, $value['id'])) {                        
                            $value['image_path'] = $groupId . DS . $value['id'] . DS;
                        } else {
                            $value['image_path'] = '';
                        }                    
                    }                    
                    
                    $optionPrepare[$sortOrder] = $value;                                    
                    // item option
                    if (isset($value['values']) && is_array($value['values'])) {
                        $itemOptionPrepare = array();
                        foreach ($value['values'] as $vKey => $val) {
                            if ($val['is_delete'] != 1) {
                                $itemSortOrder = substr('00000000'.$val['sort_order'], -8).'_'.$vKey;
                                if (Mage::helper('customoptions')->isCustomOptionsFile($groupId, $value['id'], $vKey)) {
                                    $val['image_path'] = $groupId . DS . $value['id'] . DS . $vKey;
                                } else {
                                    $val['image_path'] = '';
                                }
                                $itemOptionPrepare[$itemSortOrder] = $val;
                            }                            
                        }                        
                        ksort($itemOptionPrepare);                        
                        unset($optionPrepare[$sortOrder]['values']);                        
                        foreach ($itemOptionPrepare as $val) {
                            $optionPrepare[$sortOrder]['values'][$val['option_type_id']] = $val;
                        }                        
                    }                                        
                }                                
                
            }
            ksort($optionPrepare);
            $options = array();            
            foreach ($optionPrepare as $value) {
                $options[$value['option_id']] = $value;
            }            
        }        
        return $options;
    }

    public function duplicateAction() {
        $this->_init();
        
        $id = (int) $this->getRequest()->getParam('group_id');

        try {
            $group = Mage::getSingleton('customoptions/group')->load($id);
            $newGroupId = $group->duplicate();
            
            $helper = Mage::helper('customoptions');
            
            $helper->copyFolder($helper->getCustomOptionsPath($id), $helper->getCustomOptionsPath($newGroupId));
            
        } catch (Exception $e) {
            if ($e->getMessage()) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('group_id' => $id));
            }
        }

        Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Options were successfully duplicated'));
        
        $this->_redirect('*/*/edit', array('group_id' => $newGroupId));
    }

    public function saveAction() {                
        $this->_init();
        $data = $this->getRequest()->getPost();
        $id = (int) $this->getRequest()->getParam('group_id');        
        $error = false;        
        if ($data) {
            $data = Mage::helper('customoptions')->getFilter($data);
            
            try {
                $productOptions = array();
                if (!isset($data['product']['options']) || $this->_isEmptyOptions($data['product']['options'])) {
                    Mage::getSingleton('adminhtml/session')->addError($this->__('There are no Options'));
                    $error = true;
                } else {
                    $productOptions = $data['product']['options'];

                    foreach ($productOptions as $i => $option) {
                        if (isset($option['values'])) {
                            //$option['values'] = array_reverse($option['values'], true);
                            foreach($option['values'] as $key => $value) {
                                if ($value['option_type_id'] == '-1') {
                                    $option['values'][$key]['option_type_id'] = (string)$key;
                                }
                            }
                        }
                        $option['option_id'] = $i;
                        // qnty_input
                        if (!isset($option['qnty_input']) || ($option['type']!='drop_down' && $option['type']!='radio' && $option['type']!='checkbox')) $option['qnty_input'] = 0;                        
                        $productOptions[$i] = $option;
                    }                    
                    $data['general']['hash_options'] = serialize(array());
                }
                if ($error) {
                    if (isset($data['in_products']) && is_array($data['in_products']) && count($data['in_products']) > 0) {
                        $data['in_products'] = implode(',', $data['in_products']);
                    }
                    throw new Exception();
                }

                $optionsPrev = array();
                $prevGroupIsActive = 1;
                if ($id) {
                    $group = Mage::getSingleton('customoptions/group')->load($id);
                    $prevGroupIsActive = $group->getIsActive();
                    if ($group->getHashOptions()!='') $optionsPrev = unserialize($group->getHashOptions());
                } else {
                    $group = Mage::getSingleton('customoptions/group');
                }                
                
                
                // insert
                if (!$id) {
                    $group->setData($data['general']);
                    $group->save();
                    $id = $group->getId();
                }                                
                
                //print_r($data); exit;
                $productIds = array();
                if (isset($data['in_products']) && $data['in_products']) {
                    $productIds = explode(',', $data['in_products']);
                }                                

                //remove file
                if (isset($data['image_delete'])) {
                    foreach ($data['image_delete'] as $key1 => $optionId) {
                        if (!is_array($optionId)) {
                            Mage::getSingleton('catalog/product_option')->removeOptionFile($group->getId(), $optionId, false, true);
                        } else {
                            foreach ($optionId as $valueId => $optionId2) {
                                Mage::getSingleton('catalog/product_option')->removeOptionFile($group->getId(), $optionId2, $valueId, true);                                
                            }
                        }
                    }
                }                
                
                //upload file
                foreach ($productOptions as $option) {
                    if ($option['option_id'] == 0) {
                        $option['option_id'] = 1;
                    }
                    switch ($option['type']) {
                        case 'field':
                        case 'area':                        
                            $this->_uploadImage('file_' . $option['option_id'], $id, $option['option_id']);
                            break;
                        case 'drop_down':
                        case 'radio':
                        case 'checkbox':
                        case 'multiple':
                            foreach ($option['values'] as $key => $value) {
                                $counter = $value['option_type_id'] == '-1' ? $key : $value['option_type_id'];
                                $this->_uploadImage('file_' . $option['option_id'] . '-' . $counter, $id, $option['option_id'], $counter);
                            }
                            break;
                        case 'file':
                        case 'date':
                        case 'date_time':
                        case 'time':
                            // no image
                            if (isset($option['option_id'])) {                                
                                Mage::getSingleton('catalog/product_option')->removeOptionFile($id, $option['option_id'], false, true);                                
                            }
                            break;
                    }
                }
                
                // update                
                $data['general']['hash_options'] = serialize($this->_prepareOptions($productOptions, $id));
                $group->setData($data['general']);
                $group->setId($id);
                $group->save();
                
                                
                $productOptionModel = Mage::getModel('catalog/product_option');                
                if ($productOptions && isset($productIds) && is_array($productIds)) {                    
                    if (count($productIds) > 0) {                        
                        $productOptionModel->saveProductOptions($productOptions, $optionsPrev, $productIds, $group, $prevGroupIsActive, false); //$optionsPrev
                    } else {
                        $relation = Mage::getResourceSingleton('customoptions/relation');
                        $productIdsToDelete = $relation->getProductIds($group->getId());
                        $productOptionModel->deleteProductsFromOptions($productOptions, $productIdsToDelete, $group);
                    }
                }

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Options were successfully saved'));
                Mage::getSingleton('adminhtml/session')->setData('customoptions_data');

                if ($this->getRequest()->getParam('back')) {
                    $this->_redirect('*/*/edit', array('group_id' => $group->getId()));
                    return;
                }
                $this->_redirect('*/*/');
                return;
            } catch (Exception $e) {
                if ($e->getMessage()) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
                Mage::getSingleton('adminhtml/session')->setData('customoptions_data', $data);
                $this->_redirect('*/*/edit', array('group_id' => $id));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError($this->__('Unable to find Options to save'));
        $this->_redirect('*/*/');
    }

    public function productGridAction() {
        $this->loadLayout();
        $this->getResponse()->setBody(
                $this->getLayout()->createBlock('mageworx/customoptions_options_edit_tab_product')->toHtml()
        );
    }

//    public function getImageAction() {
//        $data = $this->getRequest()->getParams();
//        return Mage::helper('customoptions')->getImageView(isset($data['group_id']) ? $data['group_id'] : false, $data['option_id'], isset($data['value_id']) ? $data['value_id'] : false, false);
//    }

    public function deleteAction() {        
        $this->_init();
        $id = (int) $this->getRequest()->getParam('group_id');
        if ($id > 0) {
            try {
                $model = Mage::getModel('customoptions/group');
                $model->load($id);
                $model->setId($id)->delete();
                
                $helper = Mage::helper('customoptions');
                $helper->deleteFolder($helper->getCustomOptionsPath($id));

                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Options were successfully deleted'));
                $this->_redirect('*/*/');
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $id));
            }
        }
        $this->_redirect('*/*/');
    }

    public function massDeleteAction() {
        $this->_init();
        $ids = $this->getRequest()->getParam('groups');
        if (!is_array($ids)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Option(s)'));
        } else {
            try {
                if (isset($ids) && is_array($ids))
                    foreach ($ids as $id) {
                        $model = Mage::getModel('customoptions/group')->load($id);
                        $model->delete();
                    }
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Total of %d record(s) were successfully deleted', count($ids)));
            } catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massStatusAction() {
        $this->_init();
        $ids = $this->getRequest()->getParam('groups');
        if (!is_array($ids)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Option(s)'));
        } else {
            try {
                $data = array();
                $relation = Mage::getSingleton('customoptions/relation');
                $model = Mage::getSingleton('customoptions/group');
                if (isset($ids) && is_array($ids)) {
                    foreach ($ids as $id) {
                        $model->load($id)
                            ->setIsActive((int) $this->getRequest()->getParam('is_active'))
                            ->save();
                        $relation->changeOptionsStatus($model);
                        $data[$model->getId()] = $model->getIsActive();
                    }
                    $relation->changeHasOptions($data);
                    $this->_getSession()->addSuccess($this->__('Total of %d record(s) were successfully updated', count($ids)));
                }
            } catch (Exception $e) {
                $this->_getSession()->addError($e->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    private function _uploadImage($keyFile, $groupId, $optionId, $valueId = false) {
        if (isset($_FILES[$keyFile]['name']) && $_FILES[$keyFile]['name'] != '') {
            try {
                Mage::helper('customoptions')->deleteValueFile($groupId, $optionId, $valueId);

                $uploader = new Varien_File_Uploader($keyFile);
                $uploader->setAllowedExtensions(array('jpg', 'jpeg', 'gif', 'png'));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);

                $uploader->save(Mage::helper('customoptions')->getCustomOptionsPath($groupId, $optionId, $valueId), $_FILES[$keyFile]['name']);
            } catch (Exception $e) {
                if ($e->getMessage()) {
                    Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                }
            }
        }
    }
    protected function _isAllowed()
    {
    	return Mage::getSingleton('admin/session')->isAllowed('catalog/customoptions');
    }
}
