<?php

/**
 *
 * Copyright Sebastian Enzinger <sebastian@enzinger.de> www.sebastian-enzinger.de
 *
 * All rights reserved.
 *
**/

class Sebastian_Export_markupController extends Mage_Adminhtml_Controller_Action
{
    const XMLMarkup = '<?xml version="1.0" encoding="UTF-8"?><orders> <order>  <entity_id>entity_id</entity_id>  <entity_type_id>entity_type_id</entity_type_id>  <attribute_set_id>attribute_set_id</attribute_set_id>  <increment_id>increment_id</increment_id>  <parent_id>parent_id</parent_id>  <store_id>store_id</store_id>  <created_at>created_at</created_at>  <updated_at>updated_at</updated_at>  <is_active>is_active</is_active>  <customer_id>customer_id</customer_id>  <tax_amount>tax_amount</tax_amount>  <shipping_amount>shipping_amount</shipping_amount>  <discount_amount>discount_amount</discount_amount>  <subtotal>subtotal</subtotal>  <grand_total>grand_total</grand_total>  <total_paid>total_paid</total_paid>  <total_refunded>total_refunded</total_refunded>  <total_qty_ordered>total_qty_ordered</total_qty_ordered>  <total_canceled>total_canceled</total_canceled>  <total_invoiced>total_invoiced</total_invoiced>  <total_online_refunded>total_online_refunded</total_online_refunded>  <total_offline_refunded>total_offline_refunded</total_offline_refunded>  <base_tax_amount>base_tax_amount</base_tax_amount>  <base_shipping_amount>base_shipping_amount</base_shipping_amount>  <base_discount_amount>base_discount_amount</base_discount_amount>  <base_subtotal>base_subtotal</base_subtotal>  <base_grand_total>base_grand_total</base_grand_total>  <base_total_paid>base_total_paid</base_total_paid>  <base_total_refunded>base_total_refunded</base_total_refunded>  <base_total_qty_ordered>base_total_qty_ordered</base_total_qty_ordered>  <base_total_canceled>base_total_canceled</base_total_canceled>  <base_total_invoiced>base_total_invoiced</base_total_invoiced>  <base_total_online_refunded>base_total_online_refunded</base_total_online_refunded>  <base_total_offline_refunded>base_total_offline_refunded</base_total_offline_refunded>  <subtotal_refunded>subtotal_refunded</subtotal_refunded>  <subtotal_canceled>subtotal_canceled</subtotal_canceled>  <tax_refunded>tax_refunded</tax_refunded>  <tax_canceled>tax_canceled</tax_canceled>  <shipping_refunded>shipping_refunded</shipping_refunded>  <shipping_canceled>shipping_canceled</shipping_canceled>  <base_subtotal_refunded>base_subtotal_refunded</base_subtotal_refunded>  <base_subtotal_canceled>base_subtotal_canceled</base_subtotal_canceled>  <base_tax_refunded>base_tax_refunded</base_tax_refunded>  <base_tax_canceled>base_tax_canceled</base_tax_canceled>  <base_shipping_refunded>base_shipping_refunded</base_shipping_refunded>  <base_shipping_canceled>base_shipping_canceled</base_shipping_canceled>  <subtotal_invoiced>subtotal_invoiced</subtotal_invoiced>  <tax_invoiced>tax_invoiced</tax_invoiced>  <shipping_invoiced>shipping_invoiced</shipping_invoiced>  <base_subtotal_invoiced>base_subtotal_invoiced</base_subtotal_invoiced>  <base_tax_invoiced>base_tax_invoiced</base_tax_invoiced>  <base_shipping_invoiced>base_shipping_invoiced</base_shipping_invoiced>  <shipping_tax_amount>shipping_tax_amount</shipping_tax_amount>  <base_shipping_tax_amount>base_shipping_tax_amount</base_shipping_tax_amount>  <store_to_base_rate>store_to_base_rate</store_to_base_rate>  <store_to_order_rate>store_to_order_rate</store_to_order_rate>  <weight>weight</weight>  <remote_ip>remote_ip</remote_ip>  <customer_email>customer_email</customer_email>  <base_currency_code>base_currency_code</base_currency_code>  <store_currency_code>store_currency_code</store_currency_code>  <order_currency_code>order_currency_code</order_currency_code>  <coupon_code>coupon_code</coupon_code>  <applied_rule_ids>applied_rule_ids</applied_rule_ids>  <shipping_method>shipping_method</shipping_method>  <shipping_description>shipping_description</shipping_description>  <state>state</state>  <status>status</status>  <store_name>store_name</store_name>  <quote_id>quote_id</quote_id>  <customer_group_id>customer_group_id</customer_group_id>  <customer_note_notify>customer_note_notify</customer_note_notify>  <customer_is_guest>customer_is_guest</customer_is_guest>  <is_virtual>is_virtual</is_virtual>  <email_sent>email_sent</email_sent>  <billing_address_id>billing_address_id</billing_address_id>  <shipping_address_id>shipping_address_id</shipping_address_id>  <billing>   <entity_id>entity_id</entity_id>   <entity_type_id>entity_type_id</entity_type_id>   <attribute_set_id>attribute_set_id</attribute_set_id>   <increment_id>increment_id</increment_id>   <parent_id>parent_id</parent_id>   <store_id>store_id</store_id>   <created_at>created_at</created_at>   <updated_at>updated_at</updated_at>   <is_active>is_active</is_active>   <address_type>address_type</address_type>   <prefix>prefix</prefix>   <firstname>firstname</firstname>   <lastname>lastname</lastname>   <company>company</company>   <street>street</street>   <city>city</city>   <region>region</region>   <postcode>postcode</postcode>   <country_id>country_id</country_id>   <telephone>telephone</telephone>   <fax>fax</fax>   <region_id>region_id</region_id>  </billing>  <shipping>   <entity_id>entity_id</entity_id>   <entity_type_id>entity_type_id</entity_type_id>   <attribute_set_id>attribute_set_id</attribute_set_id>   <increment_id>increment_id</increment_id>   <parent_id>parent_id</parent_id>   <store_id>store_id</store_id>   <created_at>created_at</created_at>   <updated_at>updated_at</updated_at>   <is_active>is_active</is_active>   <address_type>address_type</address_type>   <prefix>prefix</prefix>   <firstname>firstname</firstname>   <lastname>lastname</lastname>   <company>company</company>   <street>street</street>   <city>city</city>   <region>region</region>   <postcode>postcode</postcode>   <country_id>country_id</country_id>   <telephone>telephone</telephone>   <fax>fax</fax>   <region_id>region_id</region_id>  </shipping>  <payment>   <entity_id>entity_id</entity_id>   <entity_type_id>entity_type_id</entity_type_id>   <attribute_set_id>attribute_set_id</attribute_set_id>   <increment_id>increment_id</increment_id>   <parent_id>parent_id</parent_id>   <store_id>store_id</store_id>   <created_at>created_at</created_at>   <updated_at>updated_at</updated_at>   <is_active>is_active</is_active>   <amount_ordered>amount_ordered</amount_ordered>   <base_amount_ordered>base_amount_ordered</base_amount_ordered>   <shipping_amount>shipping_amount</shipping_amount>   <base_shipping_amount>base_shipping_amount</base_shipping_amount>   <method>method</method>   <po_number>po_number</po_number>   <cc_type>cc_type</cc_type>   <cc_number_enc>cc_number_enc</cc_number_enc>   <cc_last4>cc_last4</cc_last4>   <cc_owner>cc_owner</cc_owner>   <cc_exp_month>cc_exp_month</cc_exp_month>   <cc_exp_year>cc_exp_year</cc_exp_year>   <cc_ss_start_month>cc_ss_start_month</cc_ss_start_month>   <cc_ss_start_year>cc_ss_start_year</cc_ss_start_year>  </payment>  <items>   <item>    <item_id>item_id</item_id>    <order_id>order_id</order_id>    <parent_item_id>parent_item_id</parent_item_id>    <quote_item_id>quote_item_id</quote_item_id>    <created_at>created_at</created_at>    <updated_at>updated_at</updated_at>    <product_id>product_id</product_id>    <product_type>product_type</product_type>    <product_options>product_options</product_options>    <weight>weight</weight>    <is_virtual>is_virtual</is_virtual>    <sku>sku</sku>    <name>name</name>    <description>description</description>    <applied_rule_ids>applied_rule_ids</applied_rule_ids>    <additional_data>additional_data</additional_data>    <free_shipping>free_shipping</free_shipping>    <is_qty_decimal>is_qty_decimal</is_qty_decimal>    <no_discount>no_discount</no_discount>    <qty_backordered>qty_backordered</qty_backordered>    <qty_canceled>qty_canceled</qty_canceled>    <qty_invoiced>qty_invoiced</qty_invoiced>    <qty_ordered>qty_ordered</qty_ordered>    <qty_refunded>qty_refunded</qty_refunded>    <qty_shipped>qty_shipped</qty_shipped>    <cost>cost</cost>    <price>price</price>    <base_price>base_price</base_price>    <original_price>original_price</original_price>    <base_original_price>base_original_price</base_original_price>    <tax_percent>tax_percent</tax_percent>    <tax_amount>tax_amount</tax_amount>    <base_tax_amount>base_tax_amount</base_tax_amount>    <tax_invoiced>tax_invoiced</tax_invoiced>    <base_tax_invoiced>base_tax_invoiced</base_tax_invoiced>    <discount_percent>discount_percent</discount_percent>    <discount_amount>discount_amount</discount_amount>    <base_discount_amount>base_discount_amount</base_discount_amount>    <discount_invoiced>discount_invoiced</discount_invoiced>    <base_discount_invoiced>base_discount_invoiced</base_discount_invoiced>    <amount_refunded>amount_refunded</amount_refunded>    <base_amount_refunded>base_amount_refunded</base_amount_refunded>    <row_total>row_total</row_total>    <base_row_total>base_row_total</base_row_total>    <row_invoiced>row_invoiced</row_invoiced>    <base_row_invoiced>base_row_invoiced</base_row_invoiced>    <row_weight>row_weight</row_weight>    <gift_message_id>gift_message_id</gift_message_id><gift_message>gift_message</gift_message><gift_message_recipient>gift_message_recipient</gift_message_recipient><gift_message_sender>gift_message_sender</gift_message_sender>    <gift_message_available>gift_message_available</gift_message_available>    <base_tax_before_discount>base_tax_before_discount</base_tax_before_discount>    <tax_before_discount>tax_before_discount</tax_before_discount>   </item>  </items> </order></orders>';


    public function indexAction()
    {
        if (!extension_loaded('xsl')) {
          Mage::getSingleton('adminhtml/session')->addWarning($this->__('Could not find PHP XSL-Extension. Output will be XML. Please refer to <a href="http://www.adobe.com/devnet/dreamweaver/articles/config_php_xslt_07.html" target="_blank">this link</a> to install XSL support, or contact your server administrator to install php5-xsl and libxslt.'));
        }
        if (!@class_exists('XSLTProcessor')) {
          Mage::getSingleton('adminhtml/session')->addWarning($this->__('Could not find PHP XSLTProcessor. Output will be XML. Please refer to <a href="http://www.adobe.com/devnet/dreamweaver/articles/config_php_xslt_07.html" target="_blank">this link</a> to install XSL support, or contact your server administrator to install php5-xsl and libxslt.'));
        }
        $this->loadLayout();
        $this->renderLayout();
    }

    public function postAction() {
      $request = $this->getRequest();
      $input = $request->getPost('input', '');
      $indent = $request->getPost('indent', false);
      if (empty($input)) return;
      $xsl = new XSLTProcessor(); 
      $xsl->registerPHPFunctions();
      $doc = new DOMDocument();
      $doc->loadXML($input);
      $xsl->importStyleSheet($doc);
      $doc->loadXML(self::XMLMarkup);

      //Output
      if ($indent == 'on') {
        echo Mage::helper('export')->formatXmlString($xsl->transformToXML($doc));
      } else {
        echo $xsl->transformToXML($doc);
      }
    }

    public function getXMLMarkupAction() {
      echo '<pre>&lt;?xml version="1.0" encoding="UTF-8"?&gt;';
      ?>

&lt;orders&gt;
 &lt;order&gt;
  &lt;entity_id&gt;entity_id&lt;/entity_id&gt;
  &lt;entity_type_id&gt;entity_type_id&lt;/entity_type_id&gt;
  &lt;attribute_set_id&gt;attribute_set_id&lt;/attribute_set_id&gt;
  &lt;increment_id&gt;increment_id&lt;/increment_id&gt;
  &lt;parent_id&gt;parent_id&lt;/parent_id&gt;
  &lt;store_id&gt;store_id&lt;/store_id&gt;
  &lt;created_at&gt;created_at&lt;/created_at&gt;
  &lt;updated_at&gt;updated_at&lt;/updated_at&gt;
  &lt;is_active&gt;is_active&lt;/is_active&gt;
  &lt;customer_id&gt;customer_id&lt;/customer_id&gt;
  &lt;tax_amount&gt;tax_amount&lt;/tax_amount&gt;
  &lt;shipping_amount&gt;shipping_amount&lt;/shipping_amount&gt;
  &lt;discount_amount&gt;discount_amount&lt;/discount_amount&gt;
  &lt;subtotal&gt;subtotal&lt;/subtotal&gt;
  &lt;grand_total&gt;grand_total&lt;/grand_total&gt;
  &lt;total_paid&gt;total_paid&lt;/total_paid&gt;
  &lt;total_refunded&gt;total_refunded&lt;/total_refunded&gt;
  &lt;total_qty_ordered&gt;total_qty_ordered&lt;/total_qty_ordered&gt;
  &lt;total_canceled&gt;total_canceled&lt;/total_canceled&gt;
  &lt;total_invoiced&gt;total_invoiced&lt;/total_invoiced&gt;
  &lt;total_online_refunded&gt;total_online_refunded&lt;/total_online_refunded&gt;
  &lt;total_offline_refunded&gt;total_offline_refunded&lt;/total_offline_refunded&gt;
  &lt;base_tax_amount&gt;base_tax_amount&lt;/base_tax_amount&gt;
  &lt;base_shipping_amount&gt;base_shipping_amount&lt;/base_shipping_amount&gt;
  &lt;base_discount_amount&gt;base_discount_amount&lt;/base_discount_amount&gt;
  &lt;base_subtotal&gt;base_subtotal&lt;/base_subtotal&gt;
  &lt;base_grand_total&gt;base_grand_total&lt;/base_grand_total&gt;
  &lt;base_total_paid&gt;base_total_paid&lt;/base_total_paid&gt;
  &lt;base_total_refunded&gt;base_total_refunded&lt;/base_total_refunded&gt;
  &lt;base_total_qty_ordered&gt;base_total_qty_ordered&lt;/base_total_qty_ordered&gt;
  &lt;base_total_canceled&gt;base_total_canceled&lt;/base_total_canceled&gt;
  &lt;base_total_invoiced&gt;base_total_invoiced&lt;/base_total_invoiced&gt;
  &lt;base_total_online_refunded&gt;base_total_online_refunded&lt;/base_total_online_refunded&gt;
  &lt;base_total_offline_refunded&gt;base_total_offline_refunded&lt;/base_total_offline_refunded&gt;
  &lt;subtotal_refunded&gt;subtotal_refunded&lt;/subtotal_refunded&gt;
  &lt;subtotal_canceled&gt;subtotal_canceled&lt;/subtotal_canceled&gt;
  &lt;tax_refunded&gt;tax_refunded&lt;/tax_refunded&gt;
  &lt;tax_canceled&gt;tax_canceled&lt;/tax_canceled&gt;
  &lt;shipping_refunded&gt;shipping_refunded&lt;/shipping_refunded&gt;
  &lt;shipping_canceled&gt;shipping_canceled&lt;/shipping_canceled&gt;
  &lt;base_subtotal_refunded&gt;base_subtotal_refunded&lt;/base_subtotal_refunded&gt;
  &lt;base_subtotal_canceled&gt;base_subtotal_canceled&lt;/base_subtotal_canceled&gt;
  &lt;base_tax_refunded&gt;base_tax_refunded&lt;/base_tax_refunded&gt;
  &lt;base_tax_canceled&gt;base_tax_canceled&lt;/base_tax_canceled&gt;
  &lt;base_shipping_refunded&gt;base_shipping_refunded&lt;/base_shipping_refunded&gt;
  &lt;base_shipping_canceled&gt;base_shipping_canceled&lt;/base_shipping_canceled&gt;
  &lt;subtotal_invoiced&gt;subtotal_invoiced&lt;/subtotal_invoiced&gt;
  &lt;tax_invoiced&gt;tax_invoiced&lt;/tax_invoiced&gt;
  &lt;shipping_invoiced&gt;shipping_invoiced&lt;/shipping_invoiced&gt;
  &lt;base_subtotal_invoiced&gt;base_subtotal_invoiced&lt;/base_subtotal_invoiced&gt;
  &lt;base_tax_invoiced&gt;base_tax_invoiced&lt;/base_tax_invoiced&gt;
  &lt;base_shipping_invoiced&gt;base_shipping_invoiced&lt;/base_shipping_invoiced&gt;
  &lt;shipping_tax_amount&gt;shipping_tax_amount&lt;/shipping_tax_amount&gt;
  &lt;base_shipping_tax_amount&gt;base_shipping_tax_amount&lt;/base_shipping_tax_amount&gt;
  &lt;store_to_base_rate&gt;store_to_base_rate&lt;/store_to_base_rate&gt;
  &lt;store_to_order_rate&gt;store_to_order_rate&lt;/store_to_order_rate&gt;
  &lt;weight&gt;weight&lt;/weight&gt;
  &lt;remote_ip&gt;remote_ip&lt;/remote_ip&gt;
  &lt;customer_email&gt;customer_email&lt;/customer_email&gt;
  &lt;base_currency_code&gt;base_currency_code&lt;/base_currency_code&gt;
  &lt;store_currency_code&gt;store_currency_code&lt;/store_currency_code&gt;
  &lt;order_currency_code&gt;order_currency_code&lt;/order_currency_code&gt;
  &lt;coupon_code&gt;coupon_code&lt;/coupon_code&gt;
  &lt;applied_rule_ids&gt;applied_rule_ids&lt;/applied_rule_ids&gt;
  &lt;shipping_method&gt;shipping_method&lt;/shipping_method&gt;
  &lt;shipping_description&gt;shipping_description&lt;/shipping_description&gt;
  &lt;state&gt;state&lt;/state&gt;
  &lt;status&gt;status&lt;/status&gt;
  &lt;store_name&gt;store_name&lt;/store_name&gt;
  &lt;quote_id&gt;quote_id&lt;/quote_id&gt;
  &lt;customer_group_id&gt;customer_group_id&lt;/customer_group_id&gt;
  &lt;customer_note_notify&gt;customer_note_notify&lt;/customer_note_notify&gt;
  &lt;customer_is_guest&gt;customer_is_guest&lt;/customer_is_guest&gt;
  &lt;is_virtual&gt;is_virtual&lt;/is_virtual&gt;
  &lt;email_sent&gt;email_sent&lt;/email_sent&gt;
  &lt;billing_address_id&gt;billing_address_id&lt;/billing_address_id&gt;
  &lt;shipping_address_id&gt;shipping_address_id&lt;/shipping_address_id&gt;
  &lt;billing&gt;
   &lt;entity_id&gt;entity_id&lt;/entity_id&gt;
   &lt;entity_type_id&gt;entity_type_id&lt;/entity_type_id&gt;
   &lt;attribute_set_id&gt;attribute_set_id&lt;/attribute_set_id&gt;
   &lt;increment_id&gt;increment_id&lt;/increment_id&gt;
   &lt;parent_id&gt;parent_id&lt;/parent_id&gt;
   &lt;store_id&gt;store_id&lt;/store_id&gt;
   &lt;created_at&gt;created_at&lt;/created_at&gt;
   &lt;updated_at&gt;updated_at&lt;/updated_at&gt;
   &lt;is_active&gt;is_active&lt;/is_active&gt;
   &lt;address_type&gt;address_type&lt;/address_type&gt;
   &lt;prefix&gt;prefix&lt;/prefix&gt;
   &lt;firstname&gt;firstname&lt;/firstname&gt;
   &lt;lastname&gt;lastname&lt;/lastname&gt;
   &lt;company&gt;company&lt;/company&gt;
   &lt;street&gt;street&lt;/street&gt;
   &lt;city&gt;city&lt;/city&gt;
   &lt;region&gt;region&lt;/region&gt;
   &lt;postcode&gt;postcode&lt;/postcode&gt;
   &lt;country_id&gt;country_id&lt;/country_id&gt;
   &lt;telephone&gt;telephone&lt;/telephone&gt;
   &lt;fax&gt;fax&lt;/fax&gt;
   &lt;region_id&gt;region_id&lt;/region_id&gt;
  &lt;/billing&gt;
  &lt;shipping&gt;
   &lt;entity_id&gt;entity_id&lt;/entity_id&gt;
   &lt;entity_type_id&gt;entity_type_id&lt;/entity_type_id&gt;
   &lt;attribute_set_id&gt;attribute_set_id&lt;/attribute_set_id&gt;
   &lt;increment_id&gt;increment_id&lt;/increment_id&gt;
   &lt;parent_id&gt;parent_id&lt;/parent_id&gt;
   &lt;store_id&gt;store_id&lt;/store_id&gt;
   &lt;created_at&gt;created_at&lt;/created_at&gt;
   &lt;updated_at&gt;updated_at&lt;/updated_at&gt;
   &lt;is_active&gt;is_active&lt;/is_active&gt;
   &lt;address_type&gt;address_type&lt;/address_type&gt;
   &lt;prefix&gt;prefix&lt;/prefix&gt;
   &lt;firstname&gt;firstname&lt;/firstname&gt;
   &lt;lastname&gt;lastname&lt;/lastname&gt;
   &lt;company&gt;company&lt;/company&gt;
   &lt;street&gt;street&lt;/street&gt;
   &lt;city&gt;city&lt;/city&gt;
   &lt;region&gt;region&lt;/region&gt;
   &lt;postcode&gt;postcode&lt;/postcode&gt;
   &lt;country_id&gt;country_id&lt;/country_id&gt;
   &lt;telephone&gt;telephone&lt;/telephone&gt;
   &lt;fax&gt;fax&lt;/fax&gt;
   &lt;region_id&gt;region_id&lt;/region_id&gt;
  &lt;/shipping&gt;
  &lt;payment&gt;
   &lt;entity_id&gt;entity_id&lt;/entity_id&gt;
   &lt;entity_type_id&gt;entity_type_id&lt;/entity_type_id&gt;
   &lt;attribute_set_id&gt;attribute_set_id&lt;/attribute_set_id&gt;
   &lt;increment_id&gt;increment_id&lt;/increment_id&gt;
   &lt;parent_id&gt;parent_id&lt;/parent_id&gt;
   &lt;store_id&gt;store_id&lt;/store_id&gt;
   &lt;created_at&gt;created_at&lt;/created_at&gt;
   &lt;updated_at&gt;updated_at&lt;/updated_at&gt;
   &lt;is_active&gt;is_active&lt;/is_active&gt;
   &lt;amount_ordered&gt;amount_ordered&lt;/amount_ordered&gt;
   &lt;base_amount_ordered&gt;base_amount_ordered&lt;/base_amount_ordered&gt;
   &lt;shipping_amount&gt;shipping_amount&lt;/shipping_amount&gt;
   &lt;base_shipping_amount&gt;base_shipping_amount&lt;/base_shipping_amount&gt;
   &lt;method&gt;method&lt;/method&gt;
   &lt;po_number&gt;po_number&lt;/po_number&gt;
   &lt;cc_type&gt;cc_type&lt;/cc_type&gt;
   &lt;cc_number_enc&gt;cc_number_enc&lt;/cc_number_enc&gt;
   &lt;cc_last4&gt;cc_last4&lt;/cc_last4&gt;
   &lt;cc_owner&gt;cc_owner&lt;/cc_owner&gt;
   &lt;cc_exp_month&gt;cc_exp_month&lt;/cc_exp_month&gt;
   &lt;cc_exp_year&gt;cc_exp_year&lt;/cc_exp_year&gt;
   &lt;cc_ss_start_month&gt;cc_ss_start_month&lt;/cc_ss_start_month&gt;
   &lt;cc_ss_start_year&gt;cc_ss_start_year&lt;/cc_ss_start_year&gt;
  &lt;/payment&gt;
  &lt;items&gt;
   &lt;item&gt;
    &lt;item_id&gt;item_id&lt;/item_id&gt;
    &lt;order_id&gt;order_id&lt;/order_id&gt;
    &lt;parent_item_id&gt;parent_item_id&lt;/parent_item_id&gt;
    &lt;quote_item_id&gt;quote_item_id&lt;/quote_item_id&gt;
    &lt;created_at&gt;created_at&lt;/created_at&gt;
    &lt;updated_at&gt;updated_at&lt;/updated_at&gt;
    &lt;product_id&gt;product_id&lt;/product_id&gt;
    &lt;product_type&gt;product_type&lt;/product_type&gt;
    &lt;product_options&gt;product_options&lt;/product_options&gt;
    &lt;weight&gt;weight&lt;/weight&gt;
    &lt;is_virtual&gt;is_virtual&lt;/is_virtual&gt;
    &lt;sku&gt;sku&lt;/sku&gt;
    &lt;name&gt;name&lt;/name&gt;
    &lt;description&gt;description&lt;/description&gt;
    &lt;applied_rule_ids&gt;applied_rule_ids&lt;/applied_rule_ids&gt;
    &lt;additional_data&gt;additional_data&lt;/additional_data&gt;
    &lt;free_shipping&gt;free_shipping&lt;/free_shipping&gt;
    &lt;is_qty_decimal&gt;is_qty_decimal&lt;/is_qty_decimal&gt;
    &lt;no_discount&gt;no_discount&lt;/no_discount&gt;
    &lt;qty_backordered&gt;qty_backordered&lt;/qty_backordered&gt;
    &lt;qty_canceled&gt;qty_canceled&lt;/qty_canceled&gt;
    &lt;qty_invoiced&gt;qty_invoiced&lt;/qty_invoiced&gt;
    &lt;qty_ordered&gt;qty_ordered&lt;/qty_ordered&gt;
    &lt;qty_refunded&gt;qty_refunded&lt;/qty_refunded&gt;
    &lt;qty_shipped&gt;qty_shipped&lt;/qty_shipped&gt;
    &lt;cost&gt;cost&lt;/cost&gt;
    &lt;price&gt;price&lt;/price&gt;
    &lt;base_price&gt;base_price&lt;/base_price&gt;
    &lt;original_price&gt;original_price&lt;/original_price&gt;
    &lt;base_original_price&gt;base_original_price&lt;/base_original_price&gt;
    &lt;tax_percent&gt;tax_percent&lt;/tax_percent&gt;
    &lt;tax_amount&gt;tax_amount&lt;/tax_amount&gt;
    &lt;base_tax_amount&gt;base_tax_amount&lt;/base_tax_amount&gt;
    &lt;tax_invoiced&gt;tax_invoiced&lt;/tax_invoiced&gt;
    &lt;base_tax_invoiced&gt;base_tax_invoiced&lt;/base_tax_invoiced&gt;
    &lt;discount_percent&gt;discount_percent&lt;/discount_percent&gt;
    &lt;discount_amount&gt;discount_amount&lt;/discount_amount&gt;
    &lt;base_discount_amount&gt;base_discount_amount&lt;/base_discount_amount&gt;
    &lt;discount_invoiced&gt;discount_invoiced&lt;/discount_invoiced&gt;
    &lt;base_discount_invoiced&gt;base_discount_invoiced&lt;/base_discount_invoiced&gt;
    &lt;amount_refunded&gt;amount_refunded&lt;/amount_refunded&gt;
    &lt;base_amount_refunded&gt;base_amount_refunded&lt;/base_amount_refunded&gt;
    &lt;row_total&gt;row_total&lt;/row_total&gt;
    &lt;base_row_total&gt;base_row_total&lt;/base_row_total&gt;
    &lt;row_invoiced&gt;row_invoiced&lt;/row_invoiced&gt;
    &lt;base_row_invoiced&gt;base_row_invoiced&lt;/base_row_invoiced&gt;
    &lt;row_weight&gt;row_weight&lt;/row_weight&gt;
    &lt;gift_message_id&gt;gift_message_id&lt;/gift_message_id&gt;
    &lt;gift_message_available&gt;gift_message_available&lt;/gift_message_available&gt;
    &lt;base_tax_before_discount&gt;base_tax_before_discount&lt;/base_tax_before_discount&gt;
    &lt;tax_before_discount&gt;tax_before_discount&lt;/tax_before_discount&gt;
   &lt;/item&gt;
  &lt;/items&gt;
 &lt;/order&gt;
&lt;/orders&gt;
      <?
      echo "</pre>";
      die();
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
