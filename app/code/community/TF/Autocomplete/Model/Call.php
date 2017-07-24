<?php
/**
 * This script 'calls home' every day with information that help us to
 * guage the popularity of the module.
 *
 * The information we collect is listed below:
 *
 * 		- Store URL
 */
class TF_Autocomplete_Model_Call {
	const ENABLE = true;

	public function home() {
		if (self::ENABLE) {
			$post = new Zend_Http_Client();
			$post->setMethod(Zend_Http_Client::POST);
			$post->setUri('http://www.tonyfox.co.uk/module_stats/tracker.php');
			$post->setParameterPost(array(
				'module' => 'TF_Autocomplete',
				'module_version' => '1.1.0',
				'store_url' => Mage::getStoreConfig('web/secure/base_url')
			));

			$response = $post->request();

			echo 'Response: ' . $response->getStatus() . ' ' . $response->getMessage();
			echo $response->getBody();
		}
	}
}