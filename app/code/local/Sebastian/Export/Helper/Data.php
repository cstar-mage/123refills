<?php

/**
 *
 * Copyright Sebastian Enzinger <sebastian@enzinger.de> www.sebastian-enzinger.de
 *
 * All rights reserved.
 *
**/

class Sebastian_Export_Helper_Data extends Mage_Core_Helper_Abstract {
    
    function getSelectedStoreId() {
      if ($store_id = Mage::app()->getRequest()->getPost('store')) {
        if ($store_id == '') {
          return NULL;
        } else {
          return $store_id;
        }
      }
    }

    function errorlog($message) {
      if ($fh = @fopen(Mage::helper('export')->getBaseDir()."/export/export.log", 'a')) {
        fwrite($fh, $message."\n");
        fclose($fh);
      }
      return false;
    }

    function getBaseDir() {
      $basedir = Mage::getStoreConfig('admin/orderexport/basedir', $this->getSelectedStoreId());
      if (!empty($basedir) && file_exists($basedir)) {
        return $basedir;
      } else {
        return Mage::getBaseDir();
      }
    }

    function getExportTypes() {
      $types = array("xml" => array("content-type" => "text/xml"), "csv" => array("content-type" => "application/csv-tab-delimited-table"), "custom" => array("content-type" => "vary"));
      return $types;
    }

    function getLastExportedOrder() {
      if (!file_exists(Mage::helper('export')->getBaseDir()."/export/export.state")) {
        return 1;
      } else {
        $id = file_get_contents(Mage::helper('export')->getBaseDir()."/export/export.state");
        return $id;
      }
    }

    function getLastOrderId() {
      $collection = Mage::getModel('sales/order')->getCollection()
      ->addAttributeToSelect('increment_id')
      ->addAttributeToSort('increment_id', 'desc')
      ->setPage(1, 1);

      $order = $collection->getFirstItem();

      return ($order->getIncrementId() ? $order->getIncrementId() : 0);
    }

    function XMLEntities($string) { 
        $string = preg_replace('/[^\x09\x0A\x0D\x20-\x7F]/e', '$this->_privateXMLEntities("$0")', $string); 
        $string = str_replace(' ', '_', $string);
        return $string; 
    } 

    function _privateXMLEntities($num) { 
    $chars = array( 
        9 => '&#9;',
        34 => '&#34;',
        59 => '&#59;',
        44 => '&#44;', 
        128 => '&#8364;', 
        130 => '&#8218;', 
        131 => '&#402;', 
        132 => '&#8222;', 
        133 => '&#8230;', 
        134 => '&#8224;', 
        135 => '&#8225;', 
        136 => '&#710;', 
        137 => '&#8240;', 
        138 => '&#352;', 
        139 => '&#8249;', 
        140 => '&#338;', 
        142 => '&#381;', 
        145 => '&#8216;', 
        146 => '&#8217;', 
        147 => '&#8220;', 
        148 => '&#8221;', 
        149 => '&#8226;', 
        150 => '&#8211;', 
        151 => '&#8212;', 
        152 => '&#732;', 
        153 => '&#8482;', 
        154 => '&#353;', 
        155 => '&#8250;', 
        156 => '&#339;', 
        158 => '&#382;', 
        159 => '&#376;'); 
        $num = ord($num); 
        return ((($num > 127 && $num < 160) || ($num == 9 || $num == 34 || $num == 59 || $num == 44)) ? $chars[$num] : "&#".$num.";" ); 
    } 

    function formatXmlString($xml, $nbsp = false) {  
      $xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);
      
      $token      = strtok($xml, "\n");
      $result     = '';
      $pad        = 0;
      $matches    = array();
      
      while ($token !== false) : 
        if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) : 
          $indent=0;
        elseif (preg_match('/^<\/\w/', $token, $matches)) :
          $pad--;
        elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
          $indent=1;
        else :
          $indent = 0; 
        endif;

        if ($nbsp) {
          $string = '&nbsp;';
        } else {
          $string = ' ';
        }
        $line    = str_pad($token, strlen($token)+$pad, $string, STR_PAD_LEFT);
        $result .= $line . "\n";
        $token   = strtok("\n");
        $pad    += $indent;  
      endwhile; 
      
      return $result;
    }


}
