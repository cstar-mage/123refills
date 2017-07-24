<?php

/**
 * Cron functions
 *
 * @category  ProxiBlue
 * @package   DynCatProd
 * @author    Lucas van Staden <sales@proxiblue.com.au>
 * @copyright 2016 Lucas van Staden (ProxiBlue)
 * @license   http://www.proxiblue.com.au/eula EULA
 * @link      http://www.proxiblue.com.au
 */
class ProxiBlue_DynCatProd_Model_Cron
{

    protected $_helper = null;

    /**
     * Rebuild all dynamic categories
     *
     * @param object|bool $schedule
     *
     * @return string
     */
    public static function rebuildAllDynamic($schedule)
    {
        if (is_bool($schedule) || Mage::getStoreConfig('dyncatprod/rebuild/use_external_crons') == false) {
            $tempDir = sys_get_temp_dir() . "/";
            $filePointer = fopen(
                $tempDir . "dyncatprod_rebuild.lock",
                "w+"
            );
            try {
                if (flock(
                    $filePointer,
                    LOCK_EX | LOCK_NB
                )) {

                    if (!Mage::getStoreConfig('dyncatprod/rebuild/max_exec')) {
                        ini_set(
                            'max_execution_time',
                            Mage::getStoreConfig('dyncatprod/rebuild/max_exec_time')
                        );
                    }
                    self::getHelper()->debug("DynCatProd - rebuildAllDynamic (parents)");
                    $categories = Mage::getModel('catalog/category')
                        ->getCollection()
                        ->addAttributeToSelect('*')
                        ->addAttributeToFilter(
                            'parent_dynamic_attributes',
                            array(
                                'notnull' => true)
                        );
                    self::rebuildCategories($categories);
                    self::getHelper()->debug("DynCatProd - rebuildAllDynamic (direct)");
                    $categories = Mage::getModel('catalog/category')
                        ->getCollection()
                        ->addAttributeToSelect('*')
                        ->addAttributeToFilter(
                            'dynamic_attributes',
                            array(
                                'notnull' => true)
                        );
                    self::rebuildCategories($categories);
                    // initiate a delayed rebuild, to catch any children that was scheduled.
                    self::getHelper()->debug("DynCatProd - rebuildDelayed initiated from all build");
                    self::rebuildDelayed(true);
                    flock(
                        $filePointer,
                        LOCK_UN
                    );
                    unlink($tempDir . "dyncatprod_rebuild.lock");
                } else {
                    self::getHelper()->debug(
                        'Could not execute cron for rebuildAllDynamic - file lock (' . $tempDir
                        . 'dyncatprod_rebuild.lock) is in place, job may be running'
                    );
                }
            } catch (Exception $e) {
                flock(
                    $filePointer,
                    LOCK_UN
                );
                unlink($tempDir . "dyncatprod_rebuild.lock");
                mage::logException($e);
                self::getHelper()->debug($e->getMessage());

                return $e->getMessage();
            }
        }
    }

    public static function getHelper()
    {
        return mage::helper('dyncatprod');
    }

    /**
     * common function to rebuild categories
     *
     * @param array $categories
     *
     * @return void
     */
    public static function rebuildCategories($categories)
    {
        if (!Mage::getStoreConfig('dyncatprod/rebuild/max_exec')) {
            ini_set(
                'max_execution_time',
                Mage::getStoreConfig('dyncatprod/rebuild/max_exec_time')
            );
        }
        foreach ($categories as $category) {
            try {
                $ruleData = mage::helper('dyncatprod')->loadRuleData($category);
                if (count($ruleData) > 0 || Mage::getStoreConfig('dyncatprod/rebuild/force_filters')) {
                    self::getHelper()->debug(
                        "rebuilding :" . $category->getName() . ' '
                        . $category->getPath()
                    );
                    Mage::helper('dyncatprod')->disableIndexes();
                    $resourceModel = Mage::getResourceModel('dyncatprod/category');
                    $currentProducts = $resourceModel->getCurrentProducts(
                        $category
                    );
                    $category->setPostedProducts($currentProducts);
                    $category->setIsDynamicCronRun(true);
                    mage::helper('dyncatprod')->rebuildCategory(
                        $category,
                        true
                    );
                    $category->save();
                    Mage::helper('dyncatprod')->reIndex();
                } else {

                }
            } catch (Exception $e) {
                self::getHelper()->debug(
                    "ERROR rebuilding :" . $category->getName() . ' '
                    . $category->getPath() . " - Message was: "
                    . $e->getMessage()
                );
            }
        }

    }

    /**
     * Rebuild only categories that has products that changed attribute values
     *
     * @param object|bool $schedule
     *
     * @return string
     */
    public static function rebuildChangedDynamic($schedule)
    {
        if (is_bool($schedule) || Mage::getStoreConfig('dyncatprod/rebuild/use_external_crons') == false) {
            $tempDir = sys_get_temp_dir() . "/";
            $filePointer = fopen(
                $tempDir . "dyncatprod_changed_dynamic.lock",
                "w+"
            );
            try {
                if (flock(
                    $filePointer,
                    LOCK_EX | LOCK_NB
                )) {

                    self::getHelper()->debug("DynCatProd - rebuildChangedDynamic");

                    $rebuildCollection = Mage::getModel('dyncatprod/rebuild')
                        ->getCollection();
                    $rebuildCollection->getSelect()->limit(Mage::getStoreConfig('dyncatprod/rebuild/cron_records'));
                    $changed = array();
                    foreach ($rebuildCollection as $rebuild) {
                        $changed[] = array(
                            'like' => '%' . $rebuild->getAttributeCode() . '%');
                        $rebuild->delete();
                    }
                    if (count($changed) > 0) {
                        $categories = Mage::getModel('catalog/category')
                            ->getCollection()
                            ->addAttributeToSelect('*')
                            ->addAttributeToFilter(
                                array(
                                    array('attribute' => 'dynamic_attributes', $changed),
                                    array('attribute' => 'parent_dynamic_attributes', $changed)
                                )
                            );
                        self::rebuildCategories($categories);
                    }
                    flock(
                        $filePointer,
                        LOCK_UN
                    );
                    unlink($tempDir . "dyncatprod_changed_dynamic.lock");
                } else {
                    self::getHelper()->debug(
                        'Could not execute cron for rebuildChangedDynamic '
                        . '- file lock (' . $tempDir
                        . 'dyncatprod_changed_dynamic.lock) is in place, job may be running'
                    );
                }
            } catch (Exception $e) {
                flock(
                    $filePointer,
                    LOCK_UN
                );
                unlink($tempDir . "dyncatprod_changed_dynamic.lock");
                mage::logException($e);
                self::getHelper()->debug($e->getMessage());

                return $e->getMessage();
            }
        }
    }

    /**
     * Rebuild any delayed category
     *
     * @param object|bool $schedule
     *
     * @return string
     */
    public static function rebuildDelayed($schedule)
    {
        if (is_bool($schedule) || Mage::getStoreConfig('dyncatprod/rebuild/use_external_crons') == false) {
            $tempDir = sys_get_temp_dir() . "/";
            $filePointer = fopen(
                $tempDir . "dyncatprod_delayed_dynamic.lock",
                "w+"
            );
            try {
                if (flock(
                    $filePointer,
                    LOCK_EX | LOCK_NB
                )) {

                    self::getHelper()->debug("DynCatProd - rebuildDelayed");

                    $rebuildCollection = Mage::getModel('dyncatprod/delaybuild')
                        ->getCollection();
                    $rebuildCollection->getSelect()->limit(Mage::getStoreConfig('dyncatprod/rebuild/cron_records')); // impose a limit
                    $delayed = array();
                    foreach ($rebuildCollection as $rebuild) {
                        $delayed[] = $rebuild->getCategoryId();
                        $rebuild->delete();
                    }
                    if (count($delayed) > 0) {
                        $categories = Mage::getModel('catalog/category')
                            ->getCollection()
                            ->addAttributeToSelect('*')
                            ->addAttributeToFilter(
                                'entity_id',
                                array(
                                    'in' => $delayed)
                            );
                        self::rebuildCategories($categories);
                    }
                    flock(
                        $filePointer,
                        LOCK_UN
                    );
                    unlink($tempDir . "dyncatprod_delayed_dynamic.lock");
                } else {
                    self::getHelper()->debug(
                        'Could not execute cron for rebuildDelayed - file lock (' . $tempDir
                        . 'dyncatprod_delayed_dynamic.lock) is in place, job may be running'
                    );
                }
            } catch (Exception $e) {
                flock(
                    $filePointer,
                    LOCK_UN
                );
                unlink($tempDir . "dyncatprod_delayed_dynamic.lock");
                mage::logException($e);
                self::getHelper()->debug($e->getMessage());

                return $e->getMessage();
            }
        }
    }

    /**
     * Rebuild one dynamic category
     *
     * @param type $catid
     *
     * @return type
     */
    public static function rebuildOneDynamic($catid, $children = false)
    {
        $tempDir = sys_get_temp_dir() . "/";
        $filePointer = fopen(
            $tempDir . "dyncatprod_rebuild_one.lock",
            "w+"
        );
        try {
            if (flock(
                $filePointer,
                LOCK_EX | LOCK_NB
            )) {
                self::getHelper()->debug("DynCatProd - rebuildOneDynamic");
                if (!Mage::getStoreConfig('dyncatprod/rebuild/max_exec')) {
                    ini_set(
                        'max_execution_time',
                        Mage::getStoreConfig('dyncatprod/rebuild/max_exec_time')
                    );
                }
                $category = Mage::getModel('catalog/category')->load($catid);
                $categories = array(
                    $category);
                if ($children) {
                    $children = Mage::getModel('catalog/category')
                        ->getCategories($category->getId());
                    foreach ($children as $category) {
                        $categories[] = $category;
                    }
                }
                self::rebuildCategories($categories);

                flock(
                    $filePointer,
                    LOCK_UN
                );
                unlink($tempDir . "dyncatprod_rebuild_one.lock");
            } else {
                self::getHelper()->debug(
                    'Could not execute cron for rebuildOneDynamic -file lock is in place, job may be running'
                );
            }
        } catch (Exception $e) {
            flock(
                $filePointer,
                LOCK_UN
            );
            unlink($tempDir . "dyncatprod_rebuild_one.lock");
            mage::logException($e);
            self::getHelper()->debug($e->getMessage());

            return $e->getMessage();
        }
    }

    /**
     * Rebuild one dynamic category
     *
     * @param type
     *
     * @return type
     */
    public static function importDynamic($schedule)
    {
        $tempDir = sys_get_temp_dir() . "/";
        $filePointer = fopen(
            $tempDir . "dyncatprod_import.lock",
            "w+"
        );
        try {
            if (flock(
                $filePointer,
                LOCK_EX | LOCK_NB
            )) {
                $importFile = Mage::getBaseDir('var') . DS . 'importexport/dyncatprod.csv';
                self::getHelper()->debug("DynCatProd - importDynamic");
                if (!Mage::getStoreConfig('dyncatprod/rebuild/max_exec')) {
                    ini_set(
                        'max_execution_time',
                        Mage::getStoreConfig('dyncatprod/rebuild/max_exec_time')
                    );
                }
                if (!file_exists($importFile)) {
                    self::getHelper()->debug(
                        "Import file " . $importFile . " does not exist."
                    );

                } else {
                    $import = Mage::getModel('dyncatprod/import');
                    $validationResult = $import->validateSource(
                        $importFile
                    );
                    if (!$import->getProcessedRowsCount()) {
                        self::getHelper()->debug('File does not contain data. Please upload another one');
                    } else {
                        if (!$validationResult) {
                            self::getHelper()->debug('File is invalid. Please fix errors and re-upload file');
                            // errors info
                            foreach ($import->getErrors() as $errorCode => $rows) {
                                self::getHelper()->debug($errorCode . ' in rows: ' . implode(', ', $rows));
                            }
                            self::getHelper()->debug($import->getNotices());
                            self::getHelper()->debug(
                                'Checked rows: ' . $import->getProcessedRowsCount() . ', invalid rows: ' .
                                ' ' .
                                $import->getInvalidRowsCount()
                            );
                        } else {
                            self::getHelper()->debug('File is valid!');
                            $import->importSource();
                        }
                    }
                }
                flock(
                    $filePointer,
                    LOCK_UN
                );
                unlink($tempDir . "dyncatprod_import.lock");
            } else {
                self::getHelper()->debug(
                    'Could not execute cron for importDynamic - file lock is in place, job may be running'
                );
            }
        } catch (Exception $e) {
            flock(
                $filePointer,
                LOCK_UN
            );
            unlink($tempDir . "dyncatprod_import.lock");
            mage::logException($e);
            self::getHelper()->debug($e->getMessage());

            return $e->getMessage();
        }
    }


}
