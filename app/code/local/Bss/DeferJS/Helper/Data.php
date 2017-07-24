<?php
/**
* BSS Commerce Co.
*
* NOTICE OF LICENSE
*
* This source file is subject to the EULA
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://bsscommerce.com/Bss-Commerce-License.txt
*
* =================================================================
*                 MAGENTO EDITION USAGE NOTICE
* =================================================================
* This package designed for Magento COMMUNITY edition
* BSS Commerce does not guarantee correct work of this extension
* on any other Magento edition except Magento COMMUNITY edition.
* BSS Commerce does not provide extension support in case of
* incorrect edition usage.
* =================================================================
*
* @category   BSS
* @package    Bss_DeferJS
* @author     Extension Team
* @copyright  Copyright (c) 2014-2105 BSS Commerce Co. ( http://bsscommerce.com )
* @license    http://bsscommerce.com/Bss-Commerce-License.txt
*/
class Bss_DeferJS_Helper_Data extends Mage_Core_Helper_Abstract
{
 public function regexMatchSimple($regex, $matchTerm,$type) {

  if (!$regex)
    return false;

  $rules = @unserialize($regex);

  if (empty($rules))
   return false;

 foreach ($rules as $rule) {
  $regex = trim($rule['regexp'], '#');
  if($type == 1) {
    $regexs = explode('_', $regex);
    switch(count($regexs)) {
      case 1:
      $regex = $regex.'_index_index';
      break;
      case 2:
      $regex = $regex.'_index';
      break;
      default:
      break;
    }
  }

  $regexp = '#' . $regex . '#';
  if (@preg_match($regexp, $matchTerm))
   return true;

}

return false;

}

public function isEnabled()
{
 $module = Mage::app()->getFrontController()->getRequest()->getModuleName();
 $controller = Mage::app()->getFrontController()->getRequest()->getControllerName();
 $action = Mage::app()->getFrontController()->getRequest()->getActionName();

 if(Mage::app()->getStore()->isAdmin() || 
   !Mage::getStoreConfig('deferjs/general/active') || 
   Mage::helper('bss_deferjs')->regexMatchSimple(Mage::getStoreConfig('deferjs/general/deferjs_exclude_controllers'),"{$module}_{$controller}_{$action}",1) ||
   Mage::helper('bss_deferjs')->regexMatchSimple(Mage::getStoreConfig('deferjs/general/deferjs_exclude_path'),Mage::app()->getRequest()->getRequestUri(),2))
   return false;

 if(Mage::getStoreConfig('deferjs/general/exclude_home_page')) {

   $is_homepage = Mage::getBlockSingleton('page/html_header')->getIsHomePage();
   if($is_homepage) return false;

 }

 return true;
}

public function isInBodyTag() {
  return Mage::getStoreConfigFlag('deferjs/general/in_body');
}

public function deferJs($html) {
  //get and remove script in <if> tag
  $conditionalJsPattern = '#(<\!--\[if[^\>]*>\s*<script.*</script>\s*<\!\[endif\]-->)|(<script(?! nodefer).*</script>)#isU';
  preg_match_all($conditionalJsPattern, $html, $_matches);
  $_js_if = implode('', $_matches[0]);

  $html = preg_replace($conditionalJsPattern, '' , $html);

  if(Mage::getStoreConfig('deferjs/general/show_path')) {
   $module = Mage::app()->getFrontController()->getRequest()->getModuleName();
   $controller = Mage::app()->getFrontController()->getRequest()->getControllerName();
   $action = Mage::app()->getFrontController()->getRequest()->getActionName();

   $h = '<table cellspacing="0" cellpadding="2" border="1" style="width:auto;background-color:white">
   <tbody>
    <tr>
     <th>Module</th>
     <th>Controller</th>
     <th>Action</th>
     <th>Path</th>
   </tr>
   <tr>
     <td align="left">'.$module.'.</td>
     <td>'.$controller.'</td>
     <td align="right">'.$action.'</td>
     <td align="right">'.Mage::app()->getRequest()->getRequestUri().'</td>
   </tr>
 </tbody>
</table>';
$html .= $h;
}

//merger script to end of body
if(Mage::helper('bss_deferjs')->isInBodyTag()) {
  //remove <body></html>
  $conditionalJsPattern = '#</body>\s*</html>#isU';
  preg_match_all($conditionalJsPattern, $html, $_matches);
  $_end = implode('', $_matches[0]);
  $html = preg_replace($conditionalJsPattern,'',$html);
  $html .= $_js_if.$_end;
}else {
  $html .= $_js_if;
}

return $html;
}
}