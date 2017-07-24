<?

class Varien_Data_Form_Element_Gallery58 extends Varien_Data_Form_Element_Abstract
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
        $table_name = Mage::getSingleton('core/resource')->getTableName('eternity_ring_cost');
        $query = "SELECT * FROM ".$table_name;
        $results = $readConnection->fetchAll($query);
        $data_count = count($results);
        
        for($d=0;$d<$data_count;$d++)
	    {
			$size[] = $results[$d]['size'];
			$ftgold[] = $results[$d]['14k_gold'];
			$etgold[] = $results[$d]['18k_gold'];
			$platinum[] = $results[$d]['platinum'];
			$id[] = $results[$d]['id'];
		}	

		$count = count($size);
	
		$html = "
		<input type='hidden' value='".$count."' id='ringcostcount' name='ringcostcount' /><table width='100%' id='ringcosttable'>
		<tr><td>Size</td><td>14k white gold</td><td>18k white gold</td><td>platinum</td></tr>
		";
		
		
		for($i=0; $i<$count; $i++) 
        { 
		
		$j++;
		
		$html .= "<tr id='ring_cost-row-".$i."'>
		<td><input type='text' name='ring_cost[".$i."][size]' value=".$size[$i]." /></td>
		<td><input type='text' name='ring_cost[".$i."][14k_gold]' value=".$ftgold[$i]." /></td><td><input type='text' name='ring_cost[".$i."][18k_gold]' value=".$etgold[$i]." /></td><td><input type='text' name='ring_cost[".$i."][platinum]' value=".$platinum[$i]." /><input type='hidden' name='ring_cost[".$i."][id]' value=".$id[$i]." /></td></tr>";
		 }
		 
		/* for($j=100; $j<200; $j++) 
        { 
		
		$html .= "<tr id='dia_price-row-".$j."' class='no-display'>
		<td ><input name='dia_price_1-".$j."'  /></td>
		<td ><input name='dia_price_2-".$j."'  /></td><td ><input name='dia_price_3-".$j."'  /></td><td ><input name='dia_price_4-".$j."'  /></td></tr>";
		 }*/
		
		$html .= "</table>";
		


        $html .= '<table id="gallery2" class="gallery" border="0" cellspacing="3" cellpadding="0">';
        $html .= '<thead id="gallery_thead_3" class="gallery"><tr class="gallery"><td class="gallery" valign="middle" align="center">Size</td><td class="gallery" valign="middle" align="center">18k white gold</td><td class="gallery" valign="middle" align="center">18k white gold</td><td class="gallery" valign="middle" align="center">platinum</td><td class="gallery" valign="middle" align="center">Sort Order</td><td class="gallery" valign="middle" align="center">Delete</td></tr></thead>';
        $widgetButton = $this->getForm()->getParent()->getLayout();
        $buttonHtml = $widgetButton->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
					    'label'     => 'Add New Ring cost',
                        'onclick'   => 'addNewImg4()',
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
            $html .= '<script type="text/javascript">document.getElementById("gallery_thead_3").style.visibility="hidden";</script>';
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
        id5 = $count;

        function addNewImg4(){
        		
			id5++;			      	 	
			document.getElementById("ringcostcount").value = id5;
          	var table = document.getElementById("ringcosttable");
			var row = table.insertRow(id5);
			row.id = 'ring_cost-row-'+id5;     	 		
         	
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(0);
			var cell3 = row.insertCell(0);
         	var cell4 = row.insertCell(0);
					
			cell4.innerHTML = "<input name='ring_cost["+id5+"][size]'/>";
			cell3.innerHTML = "<input name='ring_cost["+id5+"][14k_gold]'/>";
			cell2.innerHTML = "<input name='ring_cost["+id5+"][18k_gold]'/>";
			cell1.innerHTML = "<input name='ring_cost["+id5+"][platinum]'/>";
			
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
