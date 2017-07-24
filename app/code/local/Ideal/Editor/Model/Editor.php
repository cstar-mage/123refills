<?php

class Ideal_Editor_Model_Editor extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('editor/editor');
    }
    public function cssCollection($path){
    	$themes = array();
    	$dirs = scandir($path);
    	unset($dirs[array_search(".",$dirs)]);
    	unset($dirs[array_search("..",$dirs)]);
    	foreach($dirs as $dir)
    	{
    		if($dir !== "." || $dir !== "..")
    		{
    			$themes[$dir] = $dir;
    		}
    	}
    	return $themes;
    }
}