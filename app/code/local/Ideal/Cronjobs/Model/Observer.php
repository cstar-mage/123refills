<?php 
class Ideal_Cronjobs_Model_Observer {
	
	const XML_PATH_SITEMAP_ENABLED = 'cronjobs/sitemap/enabled';
	const XML_PATH_CLEANLOGS_ENABLED = 'cronjobs/logcleanup/enabled';
	const XML_PATH_CATALOGRULE_ENABLED = 'cronjobs/applycatalogrules/enabled';
	const XML_PATH_REINDEX_ENABLED = 'cronjobs/reindex/enabled';
	
	public function generateSitemaps() {
		
		if (!Mage::getStoreConfigFlag(self::XML_PATH_SITEMAP_ENABLED)) {
			return;
		}
		
    	$id = 1;
        $sitemap = Mage::getModel('sitemap/sitemap');
        /* @var $sitemap Mage_Sitemap_Model_Sitemap */
        $sitemap->load($id);
        // if sitemap record exists
        if ($sitemap->getId()) {
            try {
                $sitemap->generateXml();

                echo 'The sitemap "'.$sitemap->getSitemapFilename().'" has been generated.';
            }
            catch (Mage_Core_Exception $e) {
                echo "Unable to generate the sitemap.";
            }
            catch (Exception $e) {
               echo "Unable to generate the sitemap.";
            }
        }
        else {
            echo "Unable to generate the sitemap.";
        }
        
        return $this;
    }
    
    public function applycatalogrulesCron() {
    	
    	if (!Mage::getStoreConfigFlag(self::XML_PATH_CATALOGRULE_ENABLED)) {
    		return;
    	}
    	
    	Mage::getSingleton('core/session', array('name'=>'adminhtml'));
    	$session = Mage::getSingleton('admin/session');
    	$session->start();
    	
    	Mage::getModel('catalogrule/rule')->applyAll();
    	Mage::app()->removeCache('catalog_rules_dirty');
    	
    	echo "Cron Successful";
    	return $this;
    }
    
    public function reindexCron() {
    	
    	if (!Mage::getStoreConfigFlag(self::XML_PATH_REINDEX_ENABLED)) {
    		return;
    	}
    	
    	$indexCollection = Mage::getModel('index/process')->getCollection();
    	foreach ($indexCollection as $index) {
    		/* @var $index Mage_Index_Model_Process */
    		$index->reindexAll();
    	}
    	echo "Reindex Successful.";
    	return $this;
    }
    
    public function cleanLogs() {
    	
    	if (!Mage::getStoreConfigFlag(self::XML_PATH_CLEANLOGS_ENABLED)) {
    		return;
    	}
    	
    	$logTables = array(
    			'dataflow_batch_export',
				'dataflow_batch_import',
				//'log_customer',
				'log_quote',
				'log_summary',
				'log_summary_type',
				'log_url',
				'log_url_info',
				'log_visitor',
				'log_visitor_info',
				'log_visitor_online',
				'index_event',
				'report_event',
				'report_viewed_product_index',
				'report_compared_product_index',
				'catalog_compare_item'
    	);
    	
    	$write = Mage::getSingleton('core/resource')->getConnection('core_write');
    	$write->query("SET FOREIGN_KEY_CHECKS = 0");
    	
    	foreach($logTables as $table) {
    		// now $write is an instance of Zend_Db_Adapter_Abstract
    		$tableName = Mage::getSingleton("core/resource")->getTableName($table);
    		$write->query("TRUNCATE table `".$tableName."`");
    	}
    	
    	$write->query("SET FOREIGN_KEY_CHECKS = 1");
    	
    	echo "Logs tables cleared...";
    	
    	
    	$logEnableSwitch = new Mage_Core_Model_Config();
    	$logEnableSwitch->saveConfig('dev/log/active', "0", 'default', 0);
    	echo "Log Settings:Disabled...";
    	
    	//clean the logs and cache
    	$this->clean_var_directory();
    	
    	echo "Log Files removed...";
    	
    	return $this;
    }
    
    public function clean_var_directory() {
    	$dirs = array(
    			//'downloader/.cache/',
				'downloader/pearlib/cache/*',
				'downloader/pearlib/download/*',
				//'media/css/',
				//'media/css_secure/',
				//'media/import/',
				'media/js/',
				//'var/cache/',
				'var/locks/',
				'var/log/',
				'var/report/',
				'var/session/',
				'var/tmp/'
    	);
    
    	$basepath = Mage::getBaseDir() . DS;
    	
    	foreach($dirs as $dir) {
    		//exec('rm -rf '.$dir);
    		$this->rrmdir($basepath.$dir);
    	}
    }
    
    # recursively remove a directory
    public function rrmdir($dir) {
    	foreach(glob($dir . '/*') as $file) {
    		if(is_dir($file))
    			$this->rrmdir($file);
    		else
    			unlink($file);
    	}
    	rmdir($dir);
    }
	
} 
?>