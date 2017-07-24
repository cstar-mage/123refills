<?php

class Gfe_SphinxSearch_Model_Engine
{
    public function reindex()
    {
        $result = '<pre>';
        
        $helper = Mage::helper('sphinxsearch/sphinx');

        $configPath = Mage::getBaseDir('app') . '/code/local/Gfe/SphinxSearch/etc/conf/sphinx.conf';

        $varSphinxDir = Mage::getBaseDir('var').DS.'sphinx';

        if (!file_exists($configPath)) {
            $dbConfig = Mage::getConfig()->getResourceConnectionConfig('default_setup');

            $placeholderValues = array(
                'index_path' => Mage::getBaseDir('app') . '/code/local/Gfe/SphinxSearch/etc/conf/fulltext',
                'pid_file' => $varSphinxDir.DS.'searchd.pid',
                'log' => $varSphinxDir.DS.'searchd.log',

                'db_host' => (string)$dbConfig->host,
                'db_user' => (string)$dbConfig->username,
                'db_pass' => (string)$dbConfig->password,
                'db_name' => (string)$dbConfig->dbname,
                'db_port' => '3306'
            );

            $framePath = Mage::getBaseDir('app') . '/code/local/Gfe/SphinxSearch/etc/conf/sphinx_frame.conf';
            $file = file_get_contents($framePath);

            foreach ($placeholderValues as $placeholderName => $value) {
                $file = $this->replacePlaceholder($file, $placeholderName, $value);
            }

            file_put_contents($configPath, $file);
        }

        if (!file_exists($varSphinxDir)) {
            $helper->_exec('mkdir '.$varSphinxDir);
            $result .= 'Directory ' . $varSphinxDir . ' was created.<br><br>';
        }

        $command = 'searchd --config '.$configPath;
        $result .= $command . '<br/><br/>';

        $exec = $helper->_exec($command);

        $result .= print_r($exec);

        $result .= '<br><br>';

        $command = 'indexer -c '.$configPath.' --rotate fulltext --print-queries';
        $result .= $command . '<br/><br/>';

        $exec   = $helper->_exec($command);
        $res = ($exec['status'] == 0) || (strpos($exec['data'], Gfe_SphinxSearch_Helper_Sphinx::REINDEX_SUCCESS_MESSAGE) !== FALSE);

        $result .= print_r($exec);

        if (!$res) {
            //Mage::throwException('Error on reindex '.$exec['data']);
            die('Error on reindex '.$exec['data']);
        }

        return $result;
    }
    
    public function replacePlaceholder($string, $placeholderName, $value)
    {
        $placeholder = '{{'.$placeholderName.'}}';
        return str_replace($placeholder, $value, $string);
    }
}