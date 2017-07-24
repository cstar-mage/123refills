<?php 
	echo getcwd();
?><?php
echo "<br/>";
require 'app/Mage.php';
echo Mage::getVersion();


phpinfo();
?>