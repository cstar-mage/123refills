<?

class Varien_Data_Form_Element_Gallery57 extends Varien_Data_Form_Element_Abstract
{
    public function __construct($data)
    {
        parent::__construct($data);
        $this->setType('text');
    }

    public function getElementHtml()
    {
        $gallery = $this->getValue();
		
        $resource = Mage::getSingleton('core/resource');
        $readConnection = $resource->getConnection('core_read');
        $table_name = Mage::getSingleton('core/resource')->getTableName('eternity_stone_qty');
        $query = "SELECT * FROM ".$table_name." order by shape ASC";
        $results = $readConnection->fetchAll($query);
        $data_count = count($results);
	
        for($c=0;$c<$data_count;$c++)
		{
			$shape[] = $results[$c]['shape'];
			$ring_size[] = $results[$c]['ring_size'];
			$fivect[] = $results[$c]['0_5ct'];
			$tenct[] = $results[$c]['0_10ct'];
			$fifteenct[] = $results[$c]['0_15ct'];
			$twentyct[] = $results[$c]['0_20ct'];
			$twentyfivect[] = $results[$c]['0_25ct'];
			$thirtythreect[] = $results[$c]['0_33ct'];
			$fourtyct[] = $results[$c]['0_40ct'];
			$fiftyct[] = $results[$c]['0_50ct'];
			$id[] = $results[$c]['id'];
		}	

		$count = count($shape);

	
	
		$html = "
		<input type='hidden' value='".$count."' id='stoneqtycount' name='stoneqtycount' /><table width='100%' id='stoneqtytable'>
		<tr><td>Shape</td><td>Ring Size</td><td>0.05ct</td><td>0.10ct</td><td>0.15ct</td><td>0.20ct</td><td>0.25ct</td><td>0.33ct</td><td>0.40ct</td><td>0.50ct</td></tr>
		";
		
		
		for($i=0; $i<$count; $i++) 
        { 
        			
		$html .= "<tr id='stone_qty-row-".$i."'>
		<td><input type='text' name='stone_qty[".$i."][shape]' value=".$shape[$i]." style='width:60px' /></td>
		<td><input type='text' name='stone_qty[".$i."][ring_size]' value=".$ring_size[$i]." style='width:60px' /></td><td><input type='text' name='stone_qty[".$i."][0_5ct]' value=".$fivect[$i]." style='width:60px' /></td><td><input type='text' name='stone_qty[".$i."][0_10ct]' value=".$tenct[$i]." style='width:60px' /></td><td><input type='text' name='stone_qty[".$i."][0_15ct]' value=".$fifteenct[$i]." style='width:60px' /></td><td><input type='text' name='stone_qty[".$i."][0_20ct]' value=".$twentyct[$i]." style='width:60px' /></td><td><input type='text' name='stone_qty[".$i."][0_25ct]' value=".$twentyfivect[$i]." style='width:60px' /></td><td><input type='text' name='stone_qty[".$i."][0_33ct]' value=".$thirtythreect[$i]." style='width:60px' /></td><td><input type='text' name='stone_qty[".$i."][0_40ct]' value=".$fourtyct[$i]." style='width:60px' /></td><td><input type='text' name='stone_qty[".$i."][0_50ct]' value=".$fiftyct[$i]." style='width:60px' /><input type='hidden' name='stone_qty[".$i."][id]' value=".$id[$i]." /></td></tr>";
		 }
		 
		/* for($j=100; $j<200; $j++) 
        { 
		
		$html .= "<tr id='stone_qty-row-".$j."' class='no-display'>
		<td ><input name='stone_qty_1-".$j."'  /></td>
		<td ><input name='stone_qty_2-".$j."'  /></td><td ><input name='stone_qty_3-".$j."'  /></td><td ><input name='stone_qty_4-".$j."'  /></td></tr>";
		 }*/
		
		$html .= "</table>";
		


        $html .= '<table id="gallery3" class="gallery" border="0" cellspacing="3" cellpadding="0">';
        $html .= '<thead id="gallery_thead_4" class="gallery"><tr class="gallery"><td class="gallery" valign="middle" align="center">Shape</td><td class="gallery" valign="middle" align="center">Ring Size</td><td class="gallery" valign="middle" align="center">0.05ct</td><td class="gallery" valign="middle" align="center">0.10ct</td><td class="gallery" valign="middle" align="center">0.15ct</td><td class="gallery" valign="middle" align="center">0.20ct</td><td class="gallery" valign="middle" align="center">0.25ct</td><td class="gallery" valign="middle" align="center">0.33ct</td><td class="gallery" valign="middle" align="center">0.40ct</td><td class="gallery" valign="middle" align="center">0.50ct</td><td class="gallery" valign="middle" align="center">Sort Order</td><td class="gallery" valign="middle" align="center">Delete</td></tr></thead>';
        $widgetButton = $this->getForm()->getParent()->getLayout();
        $buttonHtml = $widgetButton->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
					    'label'     => 'Add New Stone Quantity',
                        'onclick'   => 'addNewImg5()',
                        'class'     => 'add'))
                ->toHtml();

        $html .= '<tfoot class="gallery">';
        $html .= '<tr class="gallery">';
        $html .= '<td class="gallery" valign="middle" align="left" colspan="5">'.$buttonHtml.'</td>';
        $html .= '</tr>';
        $html .= '</tfoot>';

        $html .= '<tbody class="gallery">';

        $i = 0;
        if (!is_null($this->getValue())) {
            foreach ($this->getValue() as $image) {
                $i++;
                $html .= '<tr class="gallery">';
                foreach ($this->getValue()->getAttributeBackend()->getImageTypes() as $type) {
                    $url = $image->setType($type)->getSourceUrl();
                    $html .= '<td class="gallery" align="center" style="vertical-align:bottom;">';
                    $html .= '<a href="'.$url.'" target="_blank" onclick="imagePreview(\''.$this->getHtmlId().'_image_'.$type.'_'.$image->getValueId().'\');return false;">
                    <img id="'.$this->getHtmlId().'_image_'.$type.'_'.$image->getValueId().'" src="'.$url.'" alt="'.$image->getValue().'" height="25" align="absmiddle" class="small-image-preview"></a><br/>';
                    $html .= '<input type="text" name="'.$this->getName().'_'.$type.'['.$image->getValueId().']" size="1"></td>';
                }
                $html .= '<td class="gallery" align="center" style="vertical-align:bottom;"><input type="input" name="'.parent::getName().'[position]['.$image->getValueId().']" value="'.$image->getPosition().'" id="'.$this->getHtmlId().'_position_'.$image->getValueId().'" size="3"/></td>';
                $html .= '<td class="gallery" align="center" style="vertical-align:bottom;"><input type="checkbox" name="'.parent::getName().'[delete]['.$image->getValueId().']" value="'.$image->getValueId().'" id="'.$this->getHtmlId().'_delete_'.$image->getValueId().'"/></td>';
                $html .= '</tr>';
            }
        }
        if ($i==0) {
            $html .= '<script type="text/javascript">document.getElementById("gallery_thead_4").style.visibility="hidden";</script>';
        }

        $html .= '</tbody></table>';

/*
        $html .= '<script language="javascript">
                    var multi_selector = new MultiSelector( document.getElementById( "gallery" ),
                    "'.$this->getName().'",
                    -1,
                        \'<a href="file:///%file%" target="_blank" onclick="imagePreview(\\\''.$this->getHtmlId().'_image_new_%id%\\\');return false;"><img src="file:///%file%" width="50" align="absmiddle" class="small-image-preview" style="padding-bottom:3px; width:"></a> <div id="'.$this->getHtmlId().'_image_new_%id%" style="display:none" class="image-preview"><img src="file:///%file%"></div>\',
                        "",
                        \'<input type="file" name="'.parent::getName().'[new_image][%id%][%j%]" size="1" />\'
                    );
                    multi_selector.addElement( document.getElementById( "'.$this->getHtmlId().'" ) );
                    </script>';
*/

        $name = $this->getName();
        $parentName = parent::getName();

        $html .= <<<EndSCRIPT

        <script language="javascript">
        id4 = $count;  

        function addNewImg5(){
			
        	id4++;			
      	 	
			document.getElementById("stoneqtycount").value = id4;
          	var table = document.getElementById("stoneqtytable");
			var row = table.insertRow(id4);
			row.id = 'stone_qty-row-'+id4;  			
         	
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(0);
			var cell3 = row.insertCell(0);
         	var cell4 = row.insertCell(0);	
        	var cell5 = row.insertCell(0);
			var cell6 = row.insertCell(0);
			var cell7 = row.insertCell(0);
         	var cell8 = row.insertCell(0);     
			var cell9 = row.insertCell(0);
         	var cell10 = row.insertCell(0);
      	 	
			cell10.innerHTML = "<input name='stone_qty["+id4+"][shape]'/>";
			cell9.innerHTML = "<input name='stone_qty["+id4+"][ring_size]'/>";			
			cell8.innerHTML = "<input name='stone_qty["+id4+"][0_5ct]'/>";
			cell7.innerHTML = "<input name='stone_qty["+id4+"][0_10ct]'/>";
			cell6.innerHTML = "<input name='stone_qty["+id4+"][0_15ct]'/>";
			cell5.innerHTML = "<input name='stone_qty["+id4+"][0_20ct]'/>";			
			cell4.innerHTML = "<input name='stone_qty["+id4+"][0_25ct]'/>";
			cell3.innerHTML = "<input name='stone_qty["+id4+"][0_33ct]'/>";
			cell2.innerHTML = "<input name='stone_qty["+id4+"][0_40ct]'/>";
			cell1.innerHTML = "<input name='stone_qty["+id4+"][0_50ct]'/>";	
	    }
        </script>

EndSCRIPT;
        $html.= $this->getAfterElementHtml();
        return $html;
    }

    public function getName()
    {
        return $this->getData('name');
    }

    public function getParentName()
    {
        return parent::getName();
    }
}
