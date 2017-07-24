
<?php 
class Varien_Data_Form_Element_Gallery27 extends Varien_Data_Form_Element_Abstract
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
            $table_name = Mage::getSingleton('core/resource')->getTableName('stud');
            $query = "SELECT * FROM ".$table_name." WHERE `shape` = 'trillion' ";
            $results = $readConnection->fetchAll($query);
            $data_count = count($results);

            for($p=0;$p<$data_count;$p++){
               $dbf1[] = $results[$p]['carat'];
            }


            $dbf1 = array_unique($dbf1);
            
            $carat1Json = json_encode($dbf1);

            $collections = Mage::getModel('stud/clarity')->getCollection(); 
           
            $caratcollection = Mage::getModel('stud/carat')->getCollection(); 

  

            $caratcount = count($caratcollection); 

            $newArray = array();
            foreach ($results as $result) {
                  if(isset($result['carat'])){
                    $newArray[$result['carat']][] = $result;   
                }
            }

         

            $caratrowcount = count($newArray);

            $rowcount=count($collections);
           
            for($k=1;$k<=$rowcount;$k++){

                $k1[]=$k;

            }



           
            foreach ($collections as $_item){

                 $dbf[] = $_item['dbfield'];
                
                $html1.='<td data-title="'.$_item['dbfield'].'">'.$_item['label'].'</td>';    

            }

             foreach ($caratcollection as $_item1){

                 $caratweight[] = $_item1['caratweight'];             

           }

       
                $unique=array_unique(array_merge($dbf1, $caratweight) );
                $caratfc=array_diff($unique, $dbf1);

            $caratfcc = count($caratfc);


           $caratweightJson = json_encode($caratweight);


            $dbfJson = json_encode($dbf);
    
            for($k=0;$k<$caratcount;$k++){ 


            }
           
            $html = "<input type='hidden' value='".$caratrowcount."' id='trillioncount' name='trillioncount' />
                <table width='100%' id='trilliontable'>
                <tr><td>Carat</td>".$html1."</tr>";

            $i = 1;
 
        
            foreach ($newArray as $caratkey => $caratarray) {

                $html .= "<tr id='trillion-row-".$i."'>
                                                 <td><p class='caratvalue'>".$caratkey."</p><input type='hidden' class='validate-number' name='trillion-".$i."[]' value=".$caratkey." /><input type='hidden' name='trillion-".$i."[]' value='trillion' />                         
                         </td>";
                $a=0;
                $columncount = 2;
               


                foreach($caratarray as $key => $value){             

                                           
                    $key1 = array_search($value['dbfield'],$k3);


                        $html .= "<td><input type='text' class='validate-number required-entry' name='trillion-".$i."[]' value=".$value['price']." />                       
                        <input type='hidden' name='trillion-".$i."[]' value=".$value['diamondstud_id']." />
                        <input type='hidden' name='trillion-".$i."[]' value=".$value['dbfield']." />
                        </td>";
                       
                        $a++;
            
                }

                

                if($a != $rowcount){




                    $remainrow = $rowcount - $a;



                    $dbfcount = count($dbf); 
                    $p = $dbfcount;
                    $p--;
                      for($n=0;$n<$remainrow;$n++){

                       $hhh[] =  $dbf[$p];
                        $p--;
                     } 
                     $hhh = array_reverse($hhh);
                                      
                     for($n=0;$n<$remainrow;$n++){
                         
                        $html .= "<td><input type='text' class='validate-number required-entry' name='trillion-".$i."[]' value='' /><input type='hidden' name='trillion-".$i."[]' value='' />
                        <input type='hidden' name='trillion-".$i."[]' value='".$hhh[$n]."' />
                        </td>";

                        
                        
                    }  
                    echo "<br>";






                }
                $html .= "</tr>"; 
                $i++;   
            }
                
         
        $html .= "</table>";
        


        $html .= '<table id="gallery" class="gallery" border="0" cellspacing="3" cellpadding="0">';
       $html .= '<thead id="gallery_thead_2" class="gallery"></thead>';
        $widgetButton = $this->getForm()->getParent()->getLayout();
        $buttonHtml = $widgetButton->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
                        'label'     => 'Add trillion Price',
                        'onclick'   => 'addtrillion()',
                        'class'     => 'add'))
                ->toHtml();

        $html .= '<tfoot class="gallery">';
        $html .= '<tr class="gallery">';
 
         if($caratfcc != 0){
            $html .= '<td class="gallery" valign="middle" align="left" colspan="5">'.$buttonHtml.'</td>';
        }elseif ($caratrowcount == 0) {
            $html .= '<td class="gallery" valign="middle" align="left" colspan="5">'.$buttonHtml.'</td>';
        }

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

        <script language="javascript" type="text/javascript">

        var catarray = $dbfJson;

        var caratcount =  $caratcount;

        var caratarray = $caratweightJson;

        var caratexist = $carat1Json;
          
        var caratexist1 = [];
        for (var prop in caratexist) {
            caratexist1.push(caratexist[prop]);
        }         

        var caratfinaltrillion = caratarray.filter(function(val) {return caratexist1.indexOf(val) == -1;});

            


        var caratfcounttrillion = caratfinaltrillion.length;
              
        catarray = catarray.reverse();

        trillionid2 = $caratrowcount+1; 
      
        d3 = $caratrowcount+1;  
        
        rowid  = $rowcount+1; 


        
        function addtrillion(){
        
        var table = document.getElementById("trilliontable");
        document.getElementById("trillioncount").value = trillionid2;
        var row = table.insertRow(trillionid2);
        row.id = 'trillion-row-'+ trillionid2;
      
        j=rowid;
        t=0;
        for(j=rowid;j>=1;j--){
         
           if(j==1){

            var cell1 = 'cell'+j; 
            var cell1 = row.insertCell(0); 
 
            var aaa = "";

            for(k=0;k<caratfcounttrillion;k++){
                aaa += "<option value="+caratfinaltrillion[k]+">"+caratfinaltrillion[k]+"</option>";  
            }
          
             cell1.innerHTML = "<select style='width:157px' name='trillion-"+trillionid2+"[]'>"+aaa+"</select><input type='hidden' value='trillion' name='trillion-"+trillionid2+"[]'/>";
        //    cell1.innerHTML = "<input type='text' class='validate-number required-entry' name='trillion-"+trillionid2+"[]'/><input type='hidden' value='trillion' name='trillion-"+trillionid2+"[]'/>"; 

           }else{

            var cell1 = 'cell'+j;
            var cell1 = row.insertCell(0);
            cell1.innerHTML = "<input type='text' class='validate-number required-entry' name='trillion-"+trillionid2+"[]'/><input type='hidden' name='trillion-"+trillionid2+"[]'/><input type='hidden' value='"+catarray[t]+"' name='trillion-"+trillionid2+"[]'/>"; 
            t++;
           }
           
            
            
        } 
      
        trillionid2++;
        
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
 


?>
                            <style>
.caratvalue {
    border: 1px solid #cccccc;
    border-radius: 6px;
    font-size: 14px;
    margin: 0 0 3px;
    padding: 4px 11px;
    width: 100px;
}
</style>
