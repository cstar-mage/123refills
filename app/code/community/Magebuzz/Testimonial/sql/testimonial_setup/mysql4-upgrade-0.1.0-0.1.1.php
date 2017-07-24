<?php
$installer = $this;
$installer->startSetup();
	$installer->run("
		RENAME TABLE Magebuzz_testimonial TO simple_testimonial;		
	");	
$installer->endSetup(); 

?>
