<?php                
class Oeditor_Ordereditor_Block_Permission extends Mage_Adminhtml_Block_System_Config_Form_Field_Array_Abstract
{
    protected $magentoOptions;

    public function __construct()
    {
        $this->addColumn('admin_id', array(
            'label' => Mage::helper('ordereditor')->__('Admin Login Id'),
            'size'  => 28,
        ));
		 $this->addColumn('feature', array(
            'label' => Mage::helper('ordereditor')->__('Edit Functionality'),
            'size'  => 28,
        ));
		
        $this->_addAfter = false;
        $this->_addButtonLabel = Mage::helper('ordereditor')->__('Add permission to sub admin');
        
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
