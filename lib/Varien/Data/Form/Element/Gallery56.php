<?

class Varien_Data_Form_Element_Gallery56 extends Varien_Data_Form_Element_Abstract
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
  	   $table_name = Mage::getSingleton('core/resource')->getTableName('eternity_dia_price');
   	   $query = "SELECT * FROM ".$table_name;
   	   $results = $readConnection->fetchAll($query);
       $data_count = count($results);	
		
		for($b=0;$b<$data_count;$b++)
		{
			$shape[] = $results[$b]['shape'];
			$carat[] = $results[$b]['carat'];
			$fvs2price[] = $results[$b]['fvs2price'];
			$gs11price[] = $results[$b]['gs11price'];
			$jkind[] = $results[$b]['jkind'];
			$id[] = $results[$b]['id'];
		}

		$count = count($shape);		
	
		$html = "
		<input type='hidden' value='".$count."' id='diapricecount' name='diapricecount' /><table width='100%' id='diapricetable'>
		<tr><td>Shape</td><td>Carat</td><td>F VS2 (Value is $ / Carat)</td><td>G S11 (Value is $ / Carat)</td><td>jk industrial (Value is $ / Carat)</td></tr>
		";
		
		
		
		for($i=0; $i<$count; $i++) 
        { 
		
		$html .= "<tr id='dia_price-row-".$i."'>
		<td><input type='text' name='dia_price[".$i."][shape]' value=".$shape[$i]." /></td>
		<td><input type='text' name='dia_price[".$i."][carat]' value=".$carat[$i]." /></td><td><input type='text' name='dia_price[".$i."][fvs2price]' value=".$fvs2price[$i]." /></td><td><input type='text' name='dia_price[".$i."][gs11price]' value=".$gs11price[$i]." /><input type='hidden' name='dia_price[".$i."][id]' value=".$id[$i]." /></td><td><input type='text' name='dia_price[".$i."][jkind]' value=".$jkind[$i]." /></td></tr>";
		 } 
	
		
		$html .= "</table>";
		


        $html .= '<table id="gallery1" class="gallery" border="0" cellspacing="3" cellpadding="0">';
        $html .= '<thead id="gallery_thead_2" class="gallery"><tr class="gallery"><td class="gallery" valign="middle" align="center">Shape</td><td class="gallery" valign="middle" align="center">Carat</td><td class="gallery" valign="middle" align="center">F VS2 (Value is $ / Carat)</td><td class="gallery" valign="middle" align="center">G S11 (Value is $ / Carat)</td><td class="gallery" valign="middle" align="center">Sort Order</td><td class="gallery" valign="middle" align="center">Delete</td></tr></thead>';
        $widgetButton = $this->getForm()->getParent()->getLayout();
        $buttonHtml = $widgetButton->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
					    'label'     => 'Add New Dia Price',
                        'onclick'   => 'addNewImg3()',
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
            $html .= '<script type="text/javascript">document.getElementById("gallery_thead_2").style.visibility="hidden";</script>';
        }

        $html .= '</tbody></table>';


        $name = $this->getName();
        $parentName = parent::getName();

        $html .= <<<EndSCRIPT

        <script language="javascript">
         
         id3 = $count;     

        function addNewImg3(){
		
			id3++;			
      	 	
			document.getElementById("diapricecount").value = id3;
          	var table = document.getElementById("diapricetable");
			var row = table.insertRow(id3);
			row.id = 'dia_price-row-'+id3;     	 		
         	
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(0);
			var cell3 = row.insertCell(0);
         	var cell4 = row.insertCell(0);
         	var cell5 = row.insertCell(0);	
      	 		
			cell5.innerHTML = "<input name='dia_price["+id3+"][shape]'/>";
			cell4.innerHTML = "<input name='dia_price["+id3+"][carat]'/>";
			cell3.innerHTML = "<input name='dia_price["+id3+"][fvs2price]'/>";
			cell2.innerHTML = "<input name='dia_price["+id3+"][gs11price]'/>";	
         	cell1.innerHTML = "<input name='dia_price["+id3+"][jkind]'/>";	

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
