<?php                
class Oeditor_Ordereditor_Block_Invoicestatus extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    protected $magentoOptions;

    public function __construct()
    {
		 $this->addColumn('feature', array(
            'label' => Mage::helper('ordereditor')->__('Invoice Label'),
            'size'  => 28,
        ));
		
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('ordereditor')->__('Create Invoice Label');
        
        parent::__construct(); 
    }

    protected function _renderCellTemplate($columnName)
    {
        if (empty($this->_columns[$columnName])) {
            throw new Exception('Wrong column name specified.');
        }
        $column     = $this->_columns[$columnName];
        $inputName  = $this->getElement()->getName() . '[#{_id}][' . $columnName . ']';

        return '<input type="text" name="' . $inputName . '" value="#{' . $columnName . '}" ' . ($column['size'] ? 'size="' . $column['size'] . '"' : '') . '/>';
    }
}
