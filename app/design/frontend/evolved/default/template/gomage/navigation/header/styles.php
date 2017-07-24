<style type="text/css">
	
	.gan-loadinfo{
		
		<?php if($_color = Mage::getStoreConfig('gomage_navigation/ajaxloader/bordercolor')):?>
		border-color:<?php echo Mage::helper('gomage_navigation')->formatColor($_color);?> !important;
		<?php endif;?>
		
		<?php if($_color = Mage::getStoreConfig('gomage_navigation/ajaxloader/bgcolor')):?>
		background-color:<?php echo Mage::helper('gomage_navigation')->formatColor($_color);?> !important;
		<?php endif;?>
		
		<?php if($_width = intval(Mage::getStoreConfig('gomage_navigation/ajaxloader/width'))):?>
		width:<?php echo $_width;?>px !important;
		<?php endif;?>
		
		<?php if($_height = intval(Mage::getStoreConfig('gomage_navigation/ajaxloader/height'))):?>
		height:<?php echo $_height;?>px !important;
		<?php endif;?>
		
		<?php if(0 == intval(Mage::getStoreConfig('gomage_navigation/ajaxloader/enable'))):?>
		display:none !important;
		<?php endif;?>
		
	}
	/* Background Color */
	.block-layered-nav .block-content{
		<?php if($_color = Mage::getStoreConfig('gomage_navigation/filter/style')):?>
		background:<?php echo Mage::helper('gomage_navigation')->formatColor($_color);?>;
		<?php else:?>
		background:#E7F1F4;
		<?php endif;?>
	}
	
	/* Buttons Color */
	.block-layered-nav .block-content button.button span span{
		<?php if($_color = Mage::getStoreConfig('gomage_navigation/filter/button_style')):?>
		color:<?php echo Mage::helper('gomage_navigation')->formatColor($_color);?>;
		<?php else:?>
		color:#519cde;
		<?php endif;?>
		
	}
	
	/* Slider Color */	
	#narrow-by-list .gan-slider-span{
		<?php if($_color = Mage::getStoreConfig('gomage_navigation/filter/slider_style')):?>
		background:<?php echo Mage::helper('gomage_navigation')->formatColor($_color);?>;
		<?php else:?>
		background:#0000FF;
		<?php endif;?>
	}
	
	/* Popup Window Background */
	#gan-left-nav-main-container .filter-note-content,
	#gan-right-nav-main-container .filter-note-content,
	#narrow-by-list dd.filter-note-content{
		<?php if($_color = Mage::getStoreConfig('gomage_navigation/filter/popup_style')):?>
		background:<?php echo Mage::helper('gomage_navigation')->formatColor($_color);?>;
		<?php else:?>
		background:#FFFFFF;
		<?php endif;?>
	}
	
	/* Help Icon View */
	#gan-left-nav-main-container .filter-note-handle,
	#gan-right-nav-main-container .filter-note-handle,
	#narrow-by-list .filter-note-handle{
		<?php if($_color = Mage::getStoreConfig('gomage_navigation/filter/icon_style')):?>
		color:<?php echo Mage::helper('gomage_navigation')->formatColor($_color);?>;
		<?php else:?>
		color:#519cde;
		<?php endif;?>
	}
</style>
<script type="text/javascript">
	
	// <![CDATA[
	
	<?php if($loadimage = Mage::getStoreConfig('gomage_navigation/ajaxloader/loadimage')):?>
	var loadimage = '<?php echo Mage::getBaseUrl("media")."gomage/config/".$loadimage;?>';
	<?php else:?>
	var loadimage = '<?php echo $this->getSkinUrl("images/gomage/loadinfo.gif");?>';
	<?php endif;?>
	var loadimagealign = '<?php echo Mage::getStoreConfig('gomage_navigation/ajaxloader/imagealign');?>';
	
	<?php
		
		$text = trim(Mage::getStoreConfig('gomage_navigation/ajaxloader/text')) ? trim(Mage::getStoreConfig('gomage_navigation/ajaxloader/text')) : $this->__('Loading, please wait...');
		$text = addslashes(str_replace("\n", "<br/>", str_replace("\r", '', $text)));
		
	?>
	
	var gomage_navigation_loadinfo_text = "<?php echo $text?>";
	
	// ]]>
	
</script>