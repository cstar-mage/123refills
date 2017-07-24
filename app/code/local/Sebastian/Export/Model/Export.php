<?php

/**
 *
 * Copyright Sebastian Enzinger <sebastian@enzinger.de> www.sebastian-enzinger.de
 *
 * All rights reserved.
 *
 **/

class Sebastian_Export_Model_Export extends Mage_Core_Model_Abstract
{

    public function _construct()
    {
        parent::_construct();
        $this->_init('export/export');
        $this->EXPORT_TYPES = Mage::helper('export')->getExportTypes();
    }

    public function export($export_type, $start, $end, $datefrom, $dateto, $messages = false, $auto = false)
    {
        if (!isset($this->EXPORT_TYPES[strtoupper($export_type)]) && !isset($this->EXPORT_TYPES[strtolower($export_type)])) {
            if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Wrong export type.'));
            Mage::throwException(Mage::helper('export')->__('Wrong export type.'));
        }

        if ($end == 0) {
            $condition = array("from" => $start);
        } else {
            $condition = array("from" => $start, "to" => $end);
        }
        if (!empty($datefrom)) {
            $datefrom = Mage::app()->getLocale()->date($datefrom, Zend_Date::DATE_SHORT);
            $datefrom = $datefrom->toString('YYYY-MM-dd 00:00:00');
        }
        if (!empty($dateto)) {
            $dateto = Mage::app()->getLocale()->date($dateto, Zend_Date::DATE_SHORT);
            $date = new Zend_Date();
            $date->set($dateto, Zend_Date::DATE_SHORT);
            $date->add('1', Zend_Date::DAY);
            $dateto = $date->toString('YYYY-MM-dd 00:00:01');
        }

        $datefrom = new Zend_Date();
        $datefrom->sub('1', Zend_Date::MONTH);
        $datefrom = $datefrom->toString('yyyy-MM-dd 00:00:00');

        if (!empty($datefrom) && !empty($dateto)) {
            $daterange = array("date" => true, "from" => $datefrom, "to" => $dateto);
        } else if (!empty($datefrom)) {
            $daterange = array("date" => true, "from" => $datefrom);
        } else if (!empty($dateto)) {
            $daterange = array("date" => true, "to" => $dateto);
        }

        $start = 1;
        $end = 0;

        if ($end == 0) {
            $condition = array("from" => $start);
        } else {
            $condition = array("from" => $start, "to" => $end);
        }


        #addFieldToFilter('total_paid',Array('gt'=>0));
        $collection = Mage::getResourceModel('sales/order_collection') // order_shipment_collection
            ->addAttributeToSelect('*')
        #->joinAttribute('invoice_id', 'invoice/increment_id', 'entity_id', 'order_id', 'left')
        //->addFieldToFilter('entity_id', $condition);
            ->addAttributeToFilter('entity_id', $condition);

        $collection->addFieldToFilter('status', array('nin' => array('complete', 'canceled')));
        $collection->addAttributeToFilter('created_at', $daterange);

        if (isset($_POST['multiple'])) {
            $multiple = $_POST['multiple'];
            if (!empty($multiple)) {
                $dontupdatestatefile = true;
                $exportIds = explode(",", $multiple);
                $collection->addFieldToFilter('entity_id', $exportIds);
            }
        }
        if (isset($_POST['order_status'])) {
            $order_status = $_POST['order_status'];
            if (!empty($order_status) && $order_status != 'all') {
                $dontupdatestatefile = true;
                $collection->addFieldToFilter('status', $order_status);
            }
        }
        if (!empty($daterange)) {
            $collection->addAttributeToFilter('created_at', $daterange);
            $dontupdatestatefile = true;
        } else {
            $dontupdatestatefile = false;
        }

        if ($export_type == 'xml' || $export_type == 'csv' || $export_type == 'custom') {

            $markup = Mage::getStoreConfig('admin/orderexport/' . $export_type . 'markup', Mage::helper('export')->getSelectedStoreId());
            if (empty($markup)) {
                if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Please insert a valid XSL Template for the "' . $export_type . '" export type at System > Configuration > Admin > Order Export Settings. The export is not functional without a valid XSL Template.'));
                Mage::throwException(Mage::helper('export')->__('Please insert a valid XSL Template for the "' . $export_type . '" export type at System > Configuration > Admin > Order Export Settings. The export is not functional without a valid XSL Template.'));
            }

            if (!@class_exists('XMLWriter')) {
                if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Unable to load class XMLWriter'));
                Mage::throwException(Mage::helper('export')->__('Unable to load class XMLWriter'));
            }

            $xw = new XMLWriter;
            if (!$xw->openMemory()) {
                if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Could not open memory for XMLWriter'));
                Mage::throwException(Mage::helper('export')->__('Could not open memory for XMLWriter'));
            } else {
                $ordercount = 0;
                $totalitemcount = 0;

                //$xw->setIndent(2); 
                $xw->startDocument('1.0', 'UTF-8'); //? ISO-8859-1
                $xw->startElement('orders');

                foreach ($collection as $order) {
                    $ordercount++;
                    $lastOrderId = $order->getData('entity_id');
                    $realOrderId = $order->getData('increment_id');
                    $shipping = $order->getShippingAddress();
                    $billing = $order->getBillingAddress();
                    $payment = $order->getPayment();
                    $items = $order->getAllItems();

                    // Skip AT and non-ups orders.

                    //if ($shipping->getCountryId() == 'AT' || !preg_match('/ups/i', $order->getShippingDescription())) {
                    //continue;
                    //}

                    if (!isset($exportModel)) {
                        // first init so we get the export_id already here, still without creating a new id if no orders are exported
                        $exportModel = Mage::getModel('export/export');
                        $returnModel = $exportModel->save();
                        $exportid = $returnModel->getExportId();
                        $id = $exportid;
                    }

                    // Create PDF with Pick & pack and invoices.
                    /*if (!isset($pdf)){
                        $pdf = Mage::getModel('sales/order_pdf_invoices')->getPdfDefault(array($order->getId()), false, 'invoice');	
                        $pages = Mage::getModel('sales/order_pdf_invoices')->getPdfDefault(array($order->getId()), false, 'pack');	
                        $pdf->pages = array_merge ($pdf->pages, $pages->pages);
                    } else {
                        $pages = Mage::getModel('sales/order_pdf_invoices')->getPdfDefault(array($order->getId()), false, 'invoice');	
                        $pdf->pages = array_merge ($pdf->pages, $pages->pages);
                        $pages = Mage::getModel('sales/order_pdf_invoices')->getPdfDefault(array($order->getId()), false, 'pack');	
                        $pdf->pages = array_merge ($pdf->pages, $pages->pages);
                    }*/


                    $xw->startElement('order');

                    $xw->writeElement('order_line_number', $ordercount);
                    $xw->writeElement('orders_count', $collection->count());
                    $xw->writeElement('export_id', $id);

                    $date = Mage::app()->getLocale()->date();
                    $xw->writeElement('current_timestamp', $date->get(null, Zend_Date::TIMESTAMP));

                    //Export general order data
                    if ($order) {
                        foreach ($order->getData() as $key => $value) {
                            if (gettype($value) != 'array') {
                                if (gettype($value) == 'string') $value = htmlspecialchars($value, ENT_COMPAT);
                                if (!empty($key) && !empty($value)) $xw->writeElement($key, $value);
                                if ($key == 'gift_message_id') {
                                    $message = Mage::getModel('giftmessage/message');
                                    if (!is_null($value)) {
                                        $message->load((int)$value);
                                        $xw->writeElement('gift_message_sender', htmlspecialchars($message->getData('sender'), ENT_COMPAT));
                                        $xw->writeElement('gift_message_recipient', htmlspecialchars($message->getData('recipient'), ENT_COMPAT));
                                        $xw->writeElement('gift_message', htmlspecialchars($message->getData('message'), ENT_COMPAT));
                                    } else {
                                        $xw->writeElement('gift_message_sender', '');
                                        $xw->writeElement('gift_message_recipient', '');
                                        $xw->writeElement('gift_message', '');
                                    }
                                }
                                if ($key == 'created_at' && !empty($value)) {
                                    $date = Mage::app()->getLocale()->storeDate($order->getStore(), strtotime($order->getCreatedAt()), true);
                                    #2009-02-28 06:15:46
                                    #$date = new Zend_Date($value, 'yyyy-MM-dd H:i:s');
                                    $xw->writeElement('created_at_timestamp', $date->get(null, Zend_Date::TIMESTAMP));
                                }
                                if ($key == 'updated_at' && !empty($value)) {
                                    $date = Mage::app()->getLocale()->storeDate($order->getStore(), strtotime($order->getCreatedAt()), true);
                                    $xw->writeElement('updated_at_timestamp', $date->get(null, Zend_Date::TIMESTAMP));
                                }
                            }
                        }
                    }

                    if (Mage::getStoreConfig('admin/orderexport/enablecustomerexport', Mage::helper('export')->getSelectedStoreId())) {
                        $xw->startElement('customer');
                        $customer = Mage::getModel('customer/customer')->load($order->getCustomerId());
                        if ($customer) {
                            foreach ($customer->getData() as $key => $value) {
                                if (gettype($value) != 'array') {
                                    if (gettype($value) == 'string') $value = htmlspecialchars($value, ENT_COMPAT);
                                    if (!empty($key) && !empty($value)) $xw->writeElement($key, $value);
                                }
                            }
                        }
                        $xw->endElement();
                    }

                    $customerGroup = Mage::getModel('customer/group')->load($order->getCustomerGroupId());
                    if ($customerGroup && $customerGroup->getId()) $xw->writeElement('customer_group', $customerGroup->getCustomerGroupCode());

                    /*$couponCode = $order->getCouponCode();
                    if(!empty($couponCode)) {
                      $couponCollection = Mage::getModel('salesrule/rule')->getResourceCollection()->addFieldToFilter('coupon_code', $couponCode)->load();
                      if (!empty($couponCollection)) {
                        foreach($couponCollection as $coupon) {
                          $xw->writeElement('coupon_name', $coupon->getRuleName());
                          break;
                        }
                      }
                    }*/

                    $invoices = Mage::getResourceModel('sales/order_invoice_collection')
                        ->addAttributeToSelect('*')
                        ->setOrderFilter($order->getEntityId())
                        ->load();
                    if ($invoices->getSize() > 0) {
                        foreach ($invoices as $invoice) {
                            $xw->writeElement('invoice_id', $invoice->getIncrementId());
                            break;
                        }
                    }

                    //Export billing data
                    $xw->startElement('billing');
                    if ($billing) {
                        $billing->explodeStreetAddress();
                        foreach ($billing->getData() as $key => $value) {
                            if (gettype($value) != 'array') {
                                if (gettype($value) == 'string') $value = htmlspecialchars($value, ENT_COMPAT);
                                if (!empty($key) && !empty($value)) $xw->writeElement($key, $value);
                                if ($key == 'created_at' && !empty($value)) {
                                    $date = Mage::app()->getLocale()->storeDate($order->getStore(), strtotime($order->getCreatedAt()), true);
                                    $xw->writeElement('created_at_timestamp', $date->get(null, Zend_Date::TIMESTAMP));
                                }
                                if ($key == 'updated_at' && !empty($value)) {
                                    $date = Mage::app()->getLocale()->storeDate($order->getStore(), strtotime($order->getCreatedAt()), true);
                                    $xw->writeElement('updated_at_timestamp', $date->get(null, Zend_Date::TIMESTAMP));
                                }
                                if ($key == 'region_id' && !empty($value)) {
                                    $region = Mage::getModel('directory/region')->load((int)$value);
                                    $xw->writeElement('region_code', $region->getData('code'));
                                    unset($region);
                                }
                            }
                        }
                    }
                    $xw->endElement();
                    //End billing data

                    //Export shipping data
                    $xw->startElement('shipping');
                    if ($shipping) {
                        #$shipment = Mage::getModel('sales/order_shipment')->loadByIncrementId($shipping->getEntityId());
                        #foreach ($shipment->getAllTracks() as $track) {
                        #    $result['tracks'][] = $this->_getAttributes($track, 'shipment_track');
                        #}
                        $shipping->explodeStreetAddress();
                        foreach ($shipping->getData() as $key => $value) {
                            if (gettype($value) != 'array') {
                                if (gettype($value) == 'string') $value = htmlspecialchars($value, ENT_COMPAT);
                                if (!empty($key) && !empty($value)) $xw->writeElement($key, $value);
                                if ($key == 'created_at' && !empty($value)) {
                                    $date = Mage::app()->getLocale()->storeDate($order->getStore(), strtotime($order->getCreatedAt()), true);
                                    $xw->writeElement('created_at_timestamp', $date->get(null, Zend_Date::TIMESTAMP));
                                }
                                if ($key == 'updated_at' && !empty($value)) {
                                    $date = Mage::app()->getLocale()->storeDate($order->getStore(), strtotime($order->getCreatedAt()), true);
                                    $xw->writeElement('updated_at_timestamp', $date->get(null, Zend_Date::TIMESTAMP));
                                }
                                if ($key == 'region_id' && !empty($value)) {
                                    $region = Mage::getModel('directory/region')->load((int)$value);
                                    $xw->writeElement('region_code', $region->getData('code'));
                                    unset($region);
                                }
                                /*if ($key == 'street' && !empty($value)) {
                                  $street = $value;
                                  $street = explode(" ", $street);
                                  if (count($street) > 0) {
                                    $street_name = str_replace($street[count($street)-1], '', $value);
                                    $street_last = $street[count($street)-1];
                                    if (is_numeric($street_last)) {
                                      $street_add = '';
                                      $street_number = $street_last;
                                    } else {
                                      $street_number = intval($street_last);
                                      $street_add = $street_last[count($street_last)+1];
                                    }
                                    $xw->writeElement('street_first', $street_name);
                                    $xw->writeElement('street_number', $street_number);
                                    $xw->writeElement('street_add', $street_add);
                                  }
                                }*/
                            }
                        }
                    }
                    $xw->endElement();
                    //End shipping data

                    //Export payment data
                    $xw->startElement('payment');
                    if ($payment) {
                        foreach ($payment->getData() as $key => $value) {
                            if (gettype($value) != 'array') {
                                if ($key == 'cc_number_enc' && !empty($value)) {
                                    $xw->writeElement('cc_number_dec', preg_replace("/[^0-9\-]/", "", Mage::helper('core')->decrypt($value)));
                                    if ($cvv2 = $payment->getCcCid() && !empty($cvv2)) {
                                        $xw->writeElement('cc_cvv2', htmlspecialchars($cvv2, ENT_COMPAT));
                                    }
                                }
                                if (gettype($value) == 'string') $value = htmlspecialchars($value, ENT_COMPAT);
                                if (!empty($key) && !empty($value)) $xw->writeElement($key, $value);
                                if ($key == 'created_at' && !empty($value)) {
                                    $date = Mage::app()->getLocale()->storeDate($order->getStore(), strtotime($order->getCreatedAt()), true);
                                    $xw->writeElement('created_at_timestamp', $date->get(null, Zend_Date::TIMESTAMP));
                                }
                                if ($key == 'updated_at' && !empty($value)) {
                                    $date = Mage::app()->getLocale()->storeDate($order->getStore(), strtotime($order->getCreatedAt()), true);
                                    $xw->writeElement('updated_at_timestamp', $date->get(null, Zend_Date::TIMESTAMP));
                                }
                            }
                        }
                    }
                    $xw->endElement();
                    //End payment data

                    //Export item data
                    $xw->startElement('items');
                    $itemcount = 0;
                    $totalqtyordered = 0;
                    if ($items) {
                        foreach ($items as $item) {
                            $itemcount++;
                            $totalitemcount++;

                            $xw->startElement('item');
                            $xw->writeElement('order_product_number', $itemcount);
                            $totalqtyordered += $item->getQtyOrdered();

                            foreach ($item->getData() as $key => $val) {
                                if (gettype($val) != 'array') {
                                    if (gettype($val) == 'string') $value = htmlspecialchars($val, ENT_COMPAT);
                                    /*if ($key == 'cost') {
                                      $product = Mage::getModel('catalog/product')->load($item->getProductId());
                                      if ($product && $product->getCost() !== NULL) {
                                        $xw->writeElement('cost', $product->getCost());
                                        continue;
                                      }
                                    }*/
                                    /*if ($key == 'description') {
                                      $product = Mage::getModel('catalog/product')->load($item->getProductId());
                                      if ($product && $desc = $product->getShortDescription() && !empty($desc)) {
                                        $xw->writeElement('short_description', $product->getShortDescription());
                                      }
                                    }*/
                                    if (!empty($key) && !empty($val)) $xw->writeElement($key, $val);
                                    if ($key == 'gift_message_id') {
                                        $message = Mage::getModel('giftmessage/message');
                                        if (!is_null($val)) {
                                            $message->load((int)$val);
                                            $xw->writeElement('gift_message_sender', htmlspecialchars($message->getData('sender'), ENT_COMPAT));
                                            $xw->writeElement('gift_message_recipient', htmlspecialchars($message->getData('recipient'), ENT_COMPAT));
                                            $xw->writeElement('gift_message', htmlspecialchars($message->getData('message'), ENT_COMPAT));
                                        } else {
                                            $xw->writeElement('gift_message_sender', '');
                                            $xw->writeElement('gift_message_recipient', '');
                                            $xw->writeElement('gift_message', '');
                                        }
                                    }
                                }
                            }

                            //Export aitoc data
                            /*
                            //Export aitoc data
                            $xw->startElement('aitoc');
                            $oAitcheckoutfields  = Mage::getModel('aitcheckoutfields/aitcheckoutfields');
                            $CustomAtrrList = $oAitcheckoutfields->getOrderCustomData($order->getEntityId(), $order->getStoreId(), true);
                            foreach ($CustomAtrrList as $aCustomAtrrList) {
                              if (isset($aCustomAtrrList['label']) && isset($aCustomAtrrList['value'])) {
                                $key = @$aCustomAtrrList['label'];
                                $value = @$aCustomAtrrList['value'];
                                if (gettype($value) != 'array') {
                                  $xw->startElement('option');
                                  if (gettype($value) == 'string') $value = htmlspecialchars($value, ENT_COMPAT);
                                  if (!empty($key) && !empty($value)) $xw->writeElement('name', trim($key));
                                  if (!empty($key) && !empty($value)) $xw->writeElement('value', $value);
                                  $xw->endElement();
                                }
                              }
                            }
                            $xw->endElement();
                            //End aitoc data
                            */
                            //End aitoc data

                            if ($options = $item->getProductOptions()) {
                                $productAttributes = array();
                                $productOptions = array();
                                if (isset($options['options'])) {
                                    $productOptions = $options['options'];
                                }
                                /*if (isset($options['additional_options'])) {
                                  $result = array_merge($result, $options['additional_options']);
                                }*/
                                if (isset($options['attributes_info'])) {
                                    $productAttributes = $options['attributes_info'];
                                }
                            }
                            if (Mage::getStoreConfig('admin/orderexport/enableproductoptions', Mage::helper('export')->getSelectedStoreId())) {
                                if (isset($productAttributes)) {
                                    $xw->startElement('product_options');
                                    foreach ($productAttributes as $attribute) {
                                        if (isset($attribute['label']) && isset($attribute['value']) && gettype($attribute['label']) == 'string' && gettype($attribute['value']) == 'string') {
                                            $xw->startElement('option');
                                            $label = htmlspecialchars($attribute['label'], ENT_COMPAT);
                                            $value = htmlspecialchars($attribute['value'], ENT_COMPAT);
                                            if (!empty($label) && !empty($value)) $xw->writeElement('name', str_replace(array('&', '\'', '"', '<', '>', ' '), array('&amp;', '&apos;', '&quot;', '&lt;', '&gt;', '_'), $label));
                                            if (!empty($label) && !empty($value)) $xw->writeElement('value', $value);
                                            $xw->endElement();
                                        }
                                    }
                                    $xw->endElement();
                                }
                                if (isset($productOptions)) {
                                    $xw->startElement('custom_options');
                                    foreach ($productOptions as $attribute) {
                                        if (isset($attribute['label']) && isset($attribute['value']) && gettype($attribute['label']) == 'string' && gettype($attribute['value']) == 'string') {
                                            $xw->startElement('option');
                                            $label = htmlspecialchars($attribute['label'], ENT_COMPAT);
                                            $value = htmlspecialchars($attribute['value'], ENT_COMPAT);
                                            if (!empty($label) && !empty($value)) $xw->writeElement('name', str_replace(array('&', '\'', '"', '<', '>'), array('&amp;', '&apos;', '&quot;', '&lt;', '&gt;'), $label));
                                            if (!empty($label) && !empty($value)) $xw->writeElement('value', $value);
                                            $xw->endElement();
                                        }
                                    }
                                    $xw->endElement();
                                }
                            }
                            if (Mage::getStoreConfig('admin/orderexport/enableproductattributes', Mage::helper('export')->getSelectedStoreId())) {
                                $xw->startElement('product_attributes');
                                $product = Mage::getModel('catalog/product')->setStoreId($order->getStoreId())->load($item->getProductId());
                                if ($product->getId()) {
                                    foreach ($product->getAttributes(null, true) as $attribute) {
                                        $label = $attribute->getFrontend()->getLabel();
                                        $value = $attribute->getFrontend()->getValue($product);
                                        if (!empty($label) && gettype($value) == 'string' && gettype($label) == 'string') {
                                            #$label = htmlspecialchars($label, ENT_COMPAT);
                                            $value = htmlspecialchars($value, ENT_COMPAT);
                                            $xw->writeElement($attribute->getAttributeCode(), $value);
                                            #$xw->writeElement(str_replace(array('&','\'','"','<','>',' '),array('&amp;','&apos;','&quot;','&lt;','&gt;','_'), Mage::helper('export')->XMLEntities($label)), $value);
                                        }
                                    }
                                }
                                $xw->endElement();
                            }
                            $xw->endElement();
                        }
                    }
                    $xw->endElement();
                    $xw->writeElement('order_product_count', $itemcount);
                    $xw->writeElement('order_total_qty_ordered', $totalqtyordered);
                    //End item data

                    $xw->endElement(); // Order

                    #if ($order->getStatus() == 'processing') {
                    $setStatus = Mage::getStoreConfig('admin/orderexport/setstatus', Mage::helper('export')->getSelectedStoreId());
                    if (!empty($setStatus) && $setStatus != 'no_change') {
                        if (!isset($statuses)) {
                            $statuses = array();
                            foreach (Mage::getConfig()->getNode('global/sales/order/statuses')->children() as $status) {
                                $statuses[$status->getName()] = $status;
                            }
                        }
                        if (!isset($statuses) || !isset($statuses[$setStatus])) {
                            if ($messages) Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('export')->__('The status orders should be set to after exporting could not be found. Status not changed for all orders.'));
                        } else {
                            $order->setStatus($setStatus, true)->save();
                        }
                        #}            
                    }
                }

                $xw->endElement(); // Orders
                $xw->endDocument();
            }
            //die();
            #echo $xw->outputMemory(); die();

            if (!isset($lastOrderId)) {
                if ($messages) Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('export')->__('0 orders have been exported, so no new file has been created.'));
                return null;
            }

            $xwoutput = $xw->outputMemory();


            if (!@class_exists('XSLTProcessor')) {
                if ($messages) Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('export')->__('Unable to load class XSLTProcessor'));
            }
            if (!@class_exists('DOMDocument')) {
                if ($messages) Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('export')->__('Unable to load class DOMDocument'));
            }

            $files = array();

            if ((!@class_exists('DOMDocument')) || (!@class_exists('XSLTProcessor'))) {
                if ($messages) Mage::getSingleton('adminhtml/session')->addWarning('Could not load XSLTProcessor or DOMDocument, writing default xml. To fix this, please install XSLTProcessor (libxslt) and/or DOMDocument for PHP');

                if (!@file_put_contents(Mage::helper('export')->getBaseDir() . "/export/" . $id . "_default.xml", $xw->outputMemory())) {
                    if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Could not open export file. Please check that we\'ve got write access to ' . Mage::helper('export')->getBaseDir() . '/export/' . $id . '_default.xml'));
                    Mage::throwException(Mage::helper('export')->__('Could not open export file. Please check that we\'ve got write access to ' . Mage::helper('export')->getBaseDir() . '/export/' . $id . '_default.xml'));
                }
                $files[] = array("path" => Mage::helper('export')->getBaseDir() . "/export", "id" => $id, "filename" => 'default.xml');
            } else {
                if (!$markup = Mage::getStoreConfig('admin/orderexport/' . $export_type . 'markup', Mage::helper('export')->getSelectedStoreId()) || empty($markup)) {
                    if ($messages) Mage::getSingleton('adminhtml/session')->addNotice(Mage::helper('export')->__('No XML-Markup found, writing default xml.'));
                    if (!@file_put_contents(Mage::helper('export')->getBaseDir() . "/export/" . $id . "_default.xml", $xw->outputMemory())) {
                        if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Could not open export file. Please check that we\'ve got write access to ' . Mage::helper('export')->getBaseDir() . '/export/' . $id . '_default.xml'));
                        Mage::throwException(Mage::helper('export')->__('Could not open export file. Please check that we\'ve got write access to ' . Mage::helper('export')->getBaseDir() . '/export/' . $id . '_default.xml'));
                    }
                    $files[] = array("path" => Mage::helper('export')->getBaseDir() . "/export", "id" => $id, "filename" => 'default.xml');
                } else {
                    $markup = Mage::getStoreConfig('admin/orderexport/' . $export_type . 'markup', Mage::helper('export')->getSelectedStoreId());

                    $xsl = new SimpleXMLElement($markup, null, strpos($markup, '<') === false);
                    if ($xsl) {
                        $xpathres = $xsl->xpath('//files/file');
                        if ($xpathres) {
                            foreach ($xpathres as $xmlel) {
                                $attributes = $xmlel->attributes();
                                if ($attributes) {
                                    //Attributes for each file
                                    $filename = $attributes->filename;
                                    $encoding = $attributes->encoding;
                                    $escaping = $attributes->escaping;
                                    $path = $attributes->path;
                                    $active = $attributes->active;
                                    $ftpupload = $attributes->ftp;
                                    $ftppath = $attributes->ftppath;
                                    if (!empty($filename) || !empty($path)) {
                                        if ($active == 'true') {
                                            $export_dir = Mage::helper('export')->getBaseDir() . $path;
                                            if (!file_exists($export_dir)) {
                                                // Create export directory
                                                if (!@mkdir($export_dir)) {
                                                    if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Could not create export directory. Please check that we\'ve got write access to "' . Mage::helper('export')->getBaseDir() . '"'));
                                                    Mage::throwException(Mage::helper('export')->__('Could not create export directory. Please check that we\'ve got write access to "' . Mage::helper('export')->getBaseDir() . '"'));
                                                }
                                            }
                                            if (!file_exists($export_dir . "/.htaccess")) {
                                                // Create .htaccess file for directory so there is no directory listing
                                                if (!@file_put_contents($export_dir . "/.htaccess", 'deny from all')) {
                                                    if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Could not create export directory .htaccess file. Please check that we\'ve got write access to "' . Mage::helper('export')->getBaseDir() . '"'));
                                                    Mage::throwException(Mage::helper('export')->__('Could not create export directory .htaccess file. Please check that we\'ve got write access to "' . Mage::helper('export')->getBaseDir() . '"'));
                                                }
                                            }

                                            $row = $xmlel->xpath('*');
                                            if ($row && isset($row[0])) {
                                                $xsl = new XSLTProcessor();
                                                $xsl->registerPHPFunctions();
                                                $doc = new DOMDocument();
                                                # http://us2.php.net/manual/en/xsltprocessor.setparameter.php
                                                if ($totalitemcount) {
                                                    $xsltemplate = preg_replace(array("/\_\_TOTALITEMCOUNT\_\_/", "/\_\_EXPORTID\_\_/"), array($totalitemcount, $id), $row[0]->asXML());
                                                } else {
                                                    $xsltemplate = $row[0]->asXML();
                                                }
                                                $doc->loadXML($xsltemplate);
                                                $xsl->importStyleSheet($doc);
                                                $doc->loadXML($xwoutput);

                                                //Format filename
                                                $s = array('/%d%/', '/%m%/', '/%y%/', '/%Y%/', '/%h%/', '/%i%/', '/%s%/', '/%orderid%/', '/%realorderid%/', '/%ordercount%/', '/%uuid%/', '/%exportid%/');
                                                $r = array(Mage::getSingleton('core/date')->date('d'), Mage::getSingleton('core/date')->date('m'), Mage::getSingleton('core/date')->date('y'), Mage::getSingleton('core/date')->date('Y'), Mage::getSingleton('core/date')->date('H'), Mage::getSingleton('core/date')->date('i'), Mage::getSingleton('core/date')->date('s'), $lastOrderId, $realOrderId, $ordercount, uniqid(), $id);
                                                $filename = preg_replace($s, $r, $filename);

                                                //Write to file
                                                if (!empty($encoding) && @function_exists('iconv')) {
                                                    $output = iconv('UTF-8', $encoding, $xsl->transformToXML($doc));
                                                } else {
                                                    $output = $xsl->transformToXML($doc);
                                                }
                                                /*
                                                if (isset($_POST['http_post'])) {
                                                  $ch=curl_init();
                                                  curl_setopt($ch, CURLOPT_URL, '');
                                                  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                                                  curl_setopt($ch, CURLOPT_POST, 1) ;
                                                  curl_setopt($ch, CURLOPT_POSTFIELDS, urlencode($output));
                                                  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
                                                  curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
                                                  $result = curl_exec($ch);
                                                  curl_close($ch);
                                                  if ($messages) Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('export')->__('Post returned: '.$result));
                                                }
                                                */
                                                if ($escaping == 'true') {
                                                    $output = Mage::helper('export')->XMLEntities($output);
                                                } else {
                                                    #$output = html_entity_decode($output, ENT_COMPAT);
                                                }

                                                if ($export_type == 'csv') {
                                                    $output = iconv("UTF-8", "WINDOWS-1252//TRANSLIT//IGNORE", $output);
                                                }

                                                if (!@file_put_contents($export_dir . "/" . $filename, $output)) {
                                                    //Mage::throwException(Mage::helper('export')->__('Could not open export file. Please check that we\'ve got write access to "'.$export_dir."/".$id."_".$filename.'"'));
                                                } else {
                                                    $files[] = array("path" => $export_dir, "origpath" => $attributes->path, "id" => $id, "filename" => $filename, "ftpupload" => $ftpupload, "ftppath" => $ftppath);
                                                }

                                                if ($ftpupload == 'true') $doftpupload = true;

                                                // Create PDF with Pick & pack and invoices.
                                                //$pdf->save($export_dir."/pdf/rechnungen_packlisten_".$id.".pdf");


                                                unset($xsl);
                                                unset($doc);
                                            }
                                        }
                                    } else {
                                        if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Could not find attributes in XML Markup (' . htmlspecialchars('<files><file active="true" ...>...</file></files>') . ')'));
                                        Mage::throwException(Mage::helper('export')->__('Could not find attributes in XML Markup (' . htmlspecialchars('<files><file active="true" ...>...</file></files>') . ')'));
                                    }
                                } else {
                                    if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Could not find attributes in XML Markup (' . htmlspecialchars('<files><file active="true" ...>...</file></files>') . ')'));
                                    Mage::throwException(Mage::helper('export')->__('Could not find attributes in XML Markup (' . htmlspecialchars('<files><file active="true" ...>...</file></files>') . ')'));
                                }
                            }
                        } else {
                            if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Could not find attributes in XML Markup (' . htmlspecialchars('<files><file active="true" ...>...</file></files>') . ')'));
                            Mage::throwException(Mage::helper('export')->__('Could not find attributes in XML Markup (' . htmlspecialchars('<files><file active="true" ...>...</file></files>') . ')'));
                        }
                    } else {
                        if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Could not find XML Markup (' . htmlspecialchars('<files><file active="true" ...>...</file></files>') . ')'));
                        Mage::throwException(Mage::helper('export')->__('Could not find XML Markup (' . htmlspecialchars('<files><file active="true" ...>...</file></files>') . ')'));
                    }

                }
            }

            unset($xw);
        }

        $ftpstatus = 0;
        if (isset($doftpupload) && count($files) > 0) {
            $ftpstatus = 2;
            $server = Mage::getStoreConfig('admin/orderexportftp/server', Mage::helper('export')->getSelectedStoreId());
            $port = Mage::getStoreConfig('admin/orderexportftp/port', Mage::helper('export')->getSelectedStoreId());
            $username = Mage::getStoreConfig('admin/orderexportftp/username', Mage::helper('export')->getSelectedStoreId());
            $password = Mage::getStoreConfig('admin/orderexportftp/password', Mage::helper('export')->getSelectedStoreId());
            $path = Mage::getStoreConfig('admin/orderexportftp/path', Mage::helper('export')->getSelectedStoreId());
            $usessl = Mage::getStoreConfig('admin/orderexportftp/usessl', Mage::helper('export')->getSelectedStoreId());
            if (!empty($server) && !empty($port) && !empty($username) && !empty($password)) {
                if ($usessl) {
                    if (function_exists('ftp_ssl_connect')) {
                        $conn = @ftp_ssl_connect($server, (int)$port, 15);
                    } else {
                        if ($messages) Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('export')->__('No FTP-SSL functions found.'));
                    }
                } else {
                    if (function_exists('ftp_connect')) {
                        $conn = @ftp_connect($server, (int)$port, 15);
                    } else {
                        if ($messages) Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('export')->__('No FTP functions found.'));
                    }
                }
                if ($conn) {
                    if (@ftp_login($conn, $username, $password)) {
                        # ftp_pasv($conn, true); # FTP: Uncomment to enable PASV mode
                        foreach ($files as $file) {
                            if ($file['ftpupload'] == 'true') {
                                $fpath = (isset($file['ftppath'])) ? $file['ftppath'] : $path;
                                if (@ftp_put($conn, $fpath . $file['filename'], $file['path'] . "/" . $file['filename'], FTP_BINARY)) {
                                    $ftpstatus = 1;
                                }
                                if ($ftpstatus == 1 && $messages) Mage::getSingleton('adminhtml/session')->addSuccess('Export uploaded successfully to FTP server.');
                                else if ($messages && $ftpstatus == 2) Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('export')->__("Could not upload export to '" . $fpath . $file['filename'] . " from " . $file['path'] . "/" . $id . "_" . $file['filename'] . "' to FTP server."));
                            }
                        }
                    } else {
                        if ($messages) Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('export')->__('Wrong login for FTP-Server.'));
                    }
                    ftp_quit($conn);
                } else {
                    if ($messages) Mage::getSingleton('adminhtml/session')->addWarning(Mage::helper('export')->__('Could not connect to FTP-Server.'));
                }
            }
        }

        if (empty($files)) {
            if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('No export files have been created, stopping export.'));
            Mage::throwException(Mage::helper('export')->__('No export files have been created, stopping export.'));
        }

        $dbfiles = '';
        $displayfiles = '';
        foreach ($files as $file) {
            if (empty($dbfiles) && empty($displayfiles)) {
                $dbfiles = $file['origpath'] . "/" . $file['filename'];
                $displayfiles = $file['filename'];
            } else {
                $dbfiles = $dbfiles . ',' . $file['origpath'] . "/" . $file['filename'];
                $displayfiles = $displayfiles . ',' . $file['filename'];
            }
        }

        try {
            if ($ftpstatus == 1 && Mage::getStoreConfig('admin/orderexportftp/setstatus', Mage::helper('export')->getSelectedStoreId())) $exportModel->setDownloaded(1);
            $returnModel = $exportModel->setFiles($dbfiles)
                ->setDisplayfiles($displayfiles)
                ->setType($export_type)
                ->setCount($ordercount)
                ->setFtpupload($ftpstatus)
                ->setAutoexport($auto)
                ->setCreated(Mage::getSingleton('core/date')->gmtDate())
                ->save();
        } catch (Exception $e) {
            if ($messages) Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
        }

        if (!$dontupdatestatefile) {
            if (!file_exists(Mage::helper('export')->getBaseDir() . "/export/")) {
                // Create export directory
                if (!@mkdir(Mage::helper('export')->getBaseDir() . "/export/")) {
                    if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Could not create export directory. Please check that we\'ve got write access to "' . Mage::helper('export')->getBaseDir() . '"'));
                    Mage::throwException(Mage::helper('export')->__('Could not create export directory. Please check that we\'ve got write access to "' . Mage::helper('export')->getBaseDir() . '"'));
                }
            }
            if (!file_put_contents(Mage::helper('export')->getBaseDir() . "/export/export.state", $realOrderId)) {
                if (!$messages) return Mage::helper('export')->errorlog(Mage::helper('export')->__('Could not create export directory. Please check that we\'ve got write access to "' . Mage::helper('export')->getBaseDir() . '"'));
                Mage::throwException(Mage::helper('export')->__('Could not create export state file. Please check that we\'ve got write access to "' . Mage::helper('export')->getBaseDir() . '"'));
            }
        }


        if ($messages) Mage::getSingleton('adminhtml/session')->addSuccess($ordercount . ' ' . sprintf(Mage::helper('export')->__('orders have been exported successfully. Click here to download the export file: <a href="%s">%s</a>'), Mage::getSingleton('adminhtml/url')->getUrl('export/index/get') . "export_id/" . $exportid, Mage::helper('export')->__('Download File')));

        return $exportid;
    }

}