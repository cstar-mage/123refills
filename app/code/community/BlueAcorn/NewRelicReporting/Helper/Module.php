<?php

/**
 * @package     BlueAcorn\Reporting
 * @version     1.1
 * @author      Magento, Inc. <eeadmin@magentocommerce.com>
 * @copyright   Copyright © 2014 Magento, Inc.
 */
class BlueAcorn_NewRelicReporting_Helper_Module extends Mage_Core_Helper_Abstract
{
    /**#@+
     * Flags for module states
     */
    const INSTALLED = 'installed';
    const UNINSTALLED = 'uninstalled';
    const ENABLED = 'enabled';
    const DISABLED = 'disabled';
    /**#@-*/

    /**
     * Gets a list of all modules from the configuration
     * @return array
     */
    protected function _getAllModules()
    {
        $modules = Mage::getConfig()->getNode('modules');
        return (array)$modules;
    }

    /**
     * Collects required data about the modules
     * @return array
     */
    public function getModuleData()
    {

        $callback = function ($value) {
            return $value->getName();
        };

        $configModules = $this->_getAllModules();
        $dbModuleArray = Mage::getModel('blueacorn_newrelicreporting/module')->getCollection()->getItems();

        $nameValues = array_map($callback, $dbModuleArray);
        $moduleChanges = array();

        foreach($configModules as $key=>$module) {

            $config = $module->asArray();

            if (isset($config['depends'])) {
                unset($config['depends']);
            }

            //Set State based on module active
            Mage::helper('core')->isModuleEnabled($key) ? $state = self::ENABLED : $state = self::DISABLED;

            //If module found in config file is not in DB, save it to DB
            if(!in_array($key, $nameValues)) {
                //Create New Model
                $newModule = Mage::getModel('blueacorn_newrelicreporting/module');
                //Set Data
                $data = array(
                    'name' => $key,
                    'active' => $config['active'],
                    'codepool' => $config['codePool'],
                    'version' => $config['version'],
                    'state' => $state,
                    'updated_at' => Mage::getModel('core/date')->date('Y-m-d H:i:s')
                );
                $newModule->setData($data);
                //Save
                $newModule->save();

                $moduleChanges[] = array('name'=>$data['name'], 'version'=>$data['version'], 'type'=>self::INSTALLED);

            } else {

                //Get the single module from the DB to check
                $dbModule = $dbModuleArray[array_search($key, $nameValues)];

                //Data from DB
                $changeTest = $dbModule->getData();

                //Grab an array of all changes that occurred
                $changes = array_diff($config, $changeTest);

                //Remove changes that will never be stored
                foreach($changes as $key=>$change) {
                    if($key != 'active' && $key != 'codePool' && $key != 'version'){
                        unset($changes[$key]);
                    }
                }

                if(count($changes) > 0 ||
                    ($changeTest['state']==self::UNINSTALLED &&
                        (Mage::helper('core')->isModuleEnabled($changeTest['name']) && $config['version'] != null))) {

                    $data = array(
                        'entity_id'=>$changeTest['entity_id'],
                        'name'=>$changeTest['name'],
                        'active'=>$config['active'],
                        'codepool'=>$config['codePool'],
                        'version'=>$config['version'],
                        'state'=>$state,
                        'updated_at' => Mage::getModel('core/date')->date('Y-m-d H:i:s')
                    );

                    $dbModule->setData($data);
                    $dbModule->save();

                    $moduleChanges[] = array('name'=>$data['name'], 'version'=>$data['version'], 'type'=>$state);

                }
            }
        }

        //Check for and update uninstalled modules
        $arrayKeys = array_keys($configModules);
        foreach($dbModuleArray as $module) {
            if(!in_array($module->getName(), $arrayKeys) && $module->getState() != self::UNINSTALLED){
                $moduleChanges[] = array('name' => $module->getName(), 'version' => $module->getVersion(), 'type' => self::UNINSTALLED);
                $module->setData(array('entity_id' => $module->getEntityId(), 'state' => self::UNINSTALLED));
                $module->save();
            }
        }

        //Grab the collection items one more time to get final counts
        $finalDbModuleArray = Mage::getModel('blueacorn_newrelicreporting/module')->getCollection()->getItems();

        //Get all the states in the items
        $stateCallback = function ($value) {
            return $value->getState();
        };

        $stateValues = array_map($stateCallback, $finalDbModuleArray);

        //Set Counts
        $installedCount = count($stateValues);
        $disabledCount = $enabledCount = $uninstalledCount = 0;

        foreach($stateValues as $state) {
            switch($state){
                case self::ENABLED: {
                    $enabledCount++;
                    break;
                }

                case self::DISABLED: {
                    $disabledCount++;
                    break;
                }

                case self::UNINSTALLED: {
                    $uninstalledCount++;
                    break;
                }
            }
        }

        $installedCount -= $uninstalledCount;

        //Final object as an array
        $finalObject = array(
            self::INSTALLED => $installedCount,
            self::UNINSTALLED => $uninstalledCount,
            self::ENABLED=> $enabledCount,
            self::DISABLED => $disabledCount,
            'changes' => $moduleChanges
        );

        return $finalObject;
    }
}