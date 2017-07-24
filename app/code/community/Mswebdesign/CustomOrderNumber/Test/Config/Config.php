<?php
/**
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Mswebdesign
 * @package    Mswebdesign_Mswebdesign_CustomOrderNumber
 * @copyright  Copyright (c) 2013 münster-webdesign.net (http://www.muenster-webdesign.net)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @author     Christian Grugel <cgrugel@muenster-webdesign.net>
 */
class Mswebdesign_CustomOrderNumber_Test_Config_Config extends EcomDev_PHPUnit_Test_Case_Config
{
    public function testModuleDefinitionFile()
    {
        $this->assertModuleCodePool('community');
        $this->assertModuleVersion('1.0.0');
        $this->assertModuleIsActive();
    }

    public function testHelperAlias()
    {
        $this->assertHelperAlias('mswebdesign_customordernumber', 'Mswebdesign_CustomOrderNumber_Helper_Data');
    }

    public function testModelAliases()
    {
        $this->assertModelAlias('mswebdesign_customordernumber/adminhtml_system_config_source_dateprefix', 'Mswebdesign_CustomOrderNumber_Model_Adminhtml_System_Config_Source_Dateprefix');
        $this->assertModelAlias('eav/entity_type', 'Mswebdesign_CustomOrderNumber_Model_Eav_Entity_Type');
    }

    public function testClassExists_Mswebdesign_CustomOrderNumber_Model_Adminhtml_System_Config_Source_Dateprefix()
    {
        $this->assertTrue(class_exists('Mswebdesign_CustomOrderNumber_Model_Adminhtml_System_Config_Source_Dateprefix'));
    }

    public function testCallExists_Mswebdesign_CustomOrderNumber_Model_Eav_Entity_Type()
    {
        $this->assertTrue(class_exists('Mswebdesign_CustomOrderNumber_Model_Eav_Entity_Type'));
    }

}