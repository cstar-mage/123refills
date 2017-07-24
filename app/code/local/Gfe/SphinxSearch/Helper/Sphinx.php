<?php

class Gfe_SphinxSearch_Helper_Sphinx extends Mage_Core_Helper_Abstract
{
    const REINDEX_SUCCESS_MESSAGE = 'rotating indices: succesfully sent SIGHUP to searchd';

    public function isSphinxFounded()
    {
        $exec = $this->_exec('searchd --config /fake/fake/sphinx.conf');

        if (strpos($exec['data'], 'sphinx.conf') === false) {
            return false;
        }

        return true;
    }

    public function getSphinxVersion()
    {
        $version = '2.0';
        $cmd     = $this->_searchdCommand . ' --help';
        $exec    = $this->_exec($cmd);
        $res     = preg_match('/Sphinx[\s]?([\d.]*)([\s\w\d.-]*)?/i', $exec['data'], $match);
        if ($res === 1 && ($match[1] != '' || null != $match[1])) {
            if ($match[1] > 2.1) {
                $version = '2.2';
            }
        }

        return $version;
    }

    public function _exec($command)
    {
        $status = null;
        $data   = array();

        if (function_exists('exec')) {
            exec($command, $data, $status);
//            Mage::helper('mstcore/logger')->log($this, __FUNCTION__, $command."\n".implode("\n", $data));
        } else {
//            Mage::helper('mstcore/logger')->log($this, __FUNCTION__, 'PHP function "exec" not available');

            Mage::throwException('PHP function "exec" not available');
        }

        return array('status' => $status, 'data' => implode(PHP_EOL, $data));
    }
}