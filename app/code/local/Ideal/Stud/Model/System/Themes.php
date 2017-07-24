<?php
class Ideal_Stud_Model_System_Themes
{
	public function toOptionArray()
	{
		$themes = array();
		$dirs = scandir("dlpro-dynamic/themes");
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
?>