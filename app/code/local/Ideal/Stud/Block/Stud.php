<?php
class Ideal_Stud_Block_Stud extends Mage_Core_Block_Template
{
	public function _prepareLayout()
    {
		return parent::_prepareLayout();
    }
    
     public function getStud()     
     { 
        if (!$this->hasData('stud')) {
            $this->setData('stud', Mage::registry('stud'));
        }
        return $this->getData('stud');
        
    }

    public function getClarity()
     {
        //on initialize la variable
        $retour='';

        /* we made a request: pick up all the elements of the pfay_films table (thanks to our model pfay_films/film and sort by id_pfay_films */

        $collection = Mage::getModel('stud/stud')
                            ->getCollection()
                            ->setOrder('clarity_id','asc');

         /* then browse the result of the request and with the getData() function is stored in the variable return (for display in the template) the necessary data */

        foreach($collection as $data)
        {

             $retour .= $data->getData('lable.').'<br />';

         }

         /* I return a success message to the user (just so you know how to use the function) */

         Mage::getSingleton('adminhtml/session')->addSuccess('done');

         return $retour;
      }
}