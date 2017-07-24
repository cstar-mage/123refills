<?php

/**
 * Class IWD_OrderManager_Model_Conflicts
 */
class IWD_OrderManager_Model_Conflicts extends Mage_Core_Model_Abstract
{
    /**
     * @var array
     */
    protected $rewritesModules = array();

    /**
     * @return array
     */
    public function getTypes()
    {
        return array(
            'model' => Mage::helper('iwd_ordermanager')->__('Model'),
            'block' => Mage::helper('iwd_ordermanager')->__('Block'),
            'helper' => Mage::helper('iwd_ordermanager')->__('Helper'),
        );
    }

    /**
     * @return array
     */
    public function getRewritesClasses()
    {
        $this->rewritesModules = array();

        foreach ($this->getTypes() as $type => $typeLabel) {
            $rewritesModules = $this->_collectRewrites($type);
            foreach ($rewritesModules as $base => $rewrites) {
                if (count($rewrites) > 1) {
                    foreach ($rewrites as $class) {
                        $pos = strpos($class, 'IWD_OrderManager');
                        if ($pos === 0) {
                            $this->rewritesModules[$base] = $rewrites;
                            break;
                        }
                    }
                }
            }
        }

        return $this->rewritesModules;
    }

    /**
     * @param $type
     * @return array
     */
    protected function _collectRewrites($type)
    {
        $rewritesModules = array();
        $moduleConfigBase = Mage::getModel('core/config_base');
        $moduleConfig = Mage::getModel('core/config_base');

        $modules = Mage::getConfig()->getNode('modules')->children();
        foreach ($modules as $moduleName => $moduleSettings) {
            if (!$moduleSettings->is('active')) {
                continue;
            }

            $configFile = Mage::getConfig()->getModuleDir('etc', $moduleName) . DS . 'config.xml';
            $moduleConfigBase->loadFile($configFile);

            $moduleConfig->loadString('<config/>');
            $moduleConfig->extend($moduleConfigBase, true);

            $nodeType = $moduleConfig->getNode()->global->{$type . 's'};

            if (!$nodeType) {
                continue;
            }

            $nodeTypeChildren = $nodeType->children();

            foreach ($nodeTypeChildren as $nodeName => $config) {
                $rewrites = $config->rewrite;
                if ($rewrites) {
                    foreach ($rewrites->children() as $class => $new_class) {
                        $baseClass = $this->_getClassName($type, $nodeName, $class);
                        if (!isset($rewritesModules[$baseClass])
                            || (isset($rewritesModules[$baseClass]) && !in_array($new_class, $rewritesModules[$baseClass]))
                        ) {
                            if (strpos($new_class, 'IWD_All') === 0 || strpos($new_class, 'IWD_POS') === 0) {
                                continue;
                            }
                            $rewritesModules[$baseClass][] = $new_class;
                        }
                    }
                }
            }
        }

        return $rewritesModules;
    }

    /**
     * @param $type
     * @param $group
     * @param $class
     * @return string
     */
    protected function _getClassName($type, $group, $class)
    {
        $config = Mage::getConfig()->getNode()->global->{$type . 's'}->{$group};

        $className = (!empty($config)) ? $config->getClassName() : "";
        $className = (empty($className)) ? 'mage_' . $group . '_' . $type : $className;
        $className .= (!empty($class)) ? '_' . $class : $className;

        return uc_words($className);
    }
}
