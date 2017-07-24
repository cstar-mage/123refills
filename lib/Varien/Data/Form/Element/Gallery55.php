<?php

/**
 * Magento
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@magentocommerce.com so we can send you a copy immediately.
 *
 * DISCLAIMER
 *
 * Do not edit or add to this file if you wish to upgrade Magento to newer
 * versions in the future. If you wish to customize Magento for your
 * needs please refer to http://www.magentocommerce.com for more information.
 *
 * @category   Varien
 * @package    Varien_Data
 * @copyright  Copyright (c) 2008 Irubin Consulting Inc. DBA Varien (http://www.varien.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 * Category form input image element
 *
 * @category   Varien
 * @package    Varien_Data
 * @author      Magento Core Team <core@magentocommerce.com>
 */
class Varien_Data_Form_Element_Gallery55 extends Varien_Data_Form_Element_Abstract
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
  	   $table_name = Mage::getSingleton('core/resource')->getTableName('eternity_applied_rule');
   	   $query = "SELECT * FROM ".$table_name;
   	   $results = $readConnection->fetchAll($query);
       $data_count = count($results);	
	
		for($a=0;$a<$data_count;$a++)
		{
			$price_from[] = $results[$a]['price_from'];
			$price_to[] = $results[$a]['price_to'];
			$price_increase[] = $results[$a]['price_increase'];
			$id[] = $results[$a]['id'];
		}

		$count = count($price_increase);

		$html = "
		<input type='hidden' value='".$count."' id='rulescount' name='rulescount' /><table width='100%' id='rulestable'>
		<tr><td>Price From</td><td>Price To</td><td>Price Increase in %</td></tr>
		";
	
		for($i=0; $i<$count; $i++)
		{
		
		$html .= "<tr><td><input type='text' name='applied_rule[".$i."][price_from]' value=".$price_from[$i]." /></td>
		<td><input type='text' name='applied_rule[".$i."][price_to]' value=".$price_to[$i]." /></td>
		<td><input type='text' name='applied_rule[".$i."][price_increase]' value=".$price_increase[$i]." /><input type='hidden' name='applied_rule[".$i."][id]' value=".$id[$i]." /></td></tr>";
		}
		
		$html .= "</table>";


        $html .= '<table id="gallery" class="gallery" border="0" cellspacing="3" cellpadding="0">';
        $html .= '<thead id="gallery_thead" class="gallery"><tr class="gallery"><td class="gallery" valign="middle" align="center">Price From</td><td class="gallery" valign="middle" align="center">Price To</td><td class="gallery" valign="middle" align="center">Price Increse ( % )</td><td class="gallery" valign="middle" align="center">Sort Order</td><td class="gallery" valign="middle" align="center">Delete</td></tr></thead>';
        $widgetButton = $this->getForm()->getParent()->getLayout();
        $buttonHtml = $widgetButton->createBlock('adminhtml/widget_button')
                ->setData(
                    array(
					    'label'     => 'Add New Rule',
                        'onclick'   => 'addNewImg()',
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
            $html .= '<script type="text/javascript">document.getElementById("gallery_thead").style.visibility="hidden";</script>';
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
      	 id2 = $count;     

        function addNewImg(){
                	   
			id2++;			
      	 	
			document.getElementById("rulescount").value = id2;
          	var table = document.getElementById("rulestable");
			var row = table.insertRow(id2);
			row.id = 'rules-row-'+id2; 
      	 		
			var cell1 = row.insertCell(0);
			var cell2 = row.insertCell(0);
			var cell3 = row.insertCell(0);	
      	 		
			cell3.innerHTML = "<input name='applied_rule["+id2+"][price_from]'/>";
			cell2.innerHTML = "<input name='applied_rule["+id2+"][price_to]'/>";
			cell1.innerHTML = "<input name='applied_rule["+id2+"][price_increase]'/>";			
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
