<?php

class ProxiBlue_DynCatProd_Model_Convert_Parser_Csv extends Mage_Dataflow_Model_Convert_Parser_Csv
{

    /**
     * Read data collection and write to temporary file
     *
     * @return Mage_Dataflow_Model_Convert_Parser_Csv
     */
    public function unparse()
    {
        $batchExport = $this->getBatchExportModel()
            ->setBatchId($this->getBatchModel()->getId());
        $batchExportIds = $batchExport->getIdCollection();

        $io = $this->getBatchModel()->getIoAdapter();
        $io->open();

        if (!$batchExportIds) {
            $io->write("");
            $io->close();
            return $this;
        }

        $csvData = $this->getCsvString(
            array('store', 'category_id', 'dynamic_attributes', 'parent_dynamic_attributes',
                  'ignore_parent_dynamic')
        );
        $io->write($csvData);

        foreach ($batchExportIds as $batchExportId) {
            $batchExport->load($batchExportId);
            $row = $batchExport->getBatchData();
            $csvData = $this->getCsvString($row);
            $io->write($csvData);
        }

        $io->close();

        return $this;
    }
}
