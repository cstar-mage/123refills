<?php
/* @var $installer Mage_Core_Model_Resource_Setup */
$installer = $this;

$installer->startSetup();

$profile = Mage::getModel('dataflow/profile');

$data = array(
    'name' => "Import Dynamic Category Rules",
    'actions_xml' => '<action type="dataflow/convert_adapter_io" method="load">
    <var name="type">file</var>
    <var name="path">var/import/</var>
    <var name="filename"><![CDATA[dyncatprod.csv]]></var>
    <var name="format"><![CDATA[csv]]></var>
</action>

<action type="dataflow/convert_parser_csv" method="parse">
    <var name="delimiter"><![CDATA[,]]></var>
    <var name="enclose"><![CDATA["]]></var>
    <var name="number_of_records">300</var>
    <var name="adapter">dyncatprod/convert_adapter_category</var>
    <var name="method">saveRow</var>
</action>'
);

$profile->addData($data);

try {
    $profile->save();
} catch (Exception $e) {
    Mage::logException($e);
}

$profile = Mage::getModel('dataflow/profile');

$data = array(
    'name' => "Export Dynamic Category Rules",
    'actions_xml' => '<action type="dyncatprod/convert_parser_category" method="unparse">
     <var name="store"><![CDATA[1]]></var>
</action>

<action type="dyncatprod/convert_parser_csv" method="unparse">
    <var name="delimiter"><![CDATA[,]]></var>
    <var name="enclose"><![CDATA["]]></var>
</action>

<action type="dataflow/convert_adapter_io" method="save">
    <var name="type">file</var>
    <var name="path">var/export</var>
    <var name="filename"><![CDATA[dyncatprod.csv]]></var>
</action>'
);

$profile->addData($data);

try {
    $profile->save();
} catch (Exception $e) {
    Mage::logException($e);
}




$installer->endSetup();