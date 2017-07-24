<?php

class IWD_OrderManager_Model_Notify_Report extends Mage_Core_Model_Abstract
{
    const XML_PATH_EMAIL_FROM_EMAIL = 'iwd_settlementreport/emailing/from_email';
    const XML_PATH_EMAIL_TO_EMAIL = 'iwd_settlementreport/emailing/to_emails';
    const XML_PATH_EMAIL_TEMPLATE = 'iwd_settlementreport/emailing/transaction_email';
    const XML_PATH_EMAIL_FILES = 'iwd_settlementreport/emailing/files';


    public function sendEmail($email = null)
    {
        $template = Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE);

        $sender = array(
            'name' => "Settlement Report",
            'email' => Mage::getStoreConfig(self::XML_PATH_EMAIL_FROM_EMAIL)
        );

        $recipient_email = $this->getEmails($email);
        $recipient_name = " ";

        $store_id = Mage::app()->getStore()->getId();

        $transactional = Mage::getModel('core/email_template');

        $transactional = $this->attachReports($transactional);

        $vars = array(
            'sender' => $sender,
            'date' => date('d-m-Y H:i')
        );

        $transactional->sendTransactional(
            $template,
            $sender,
            $recipient_email,
            $recipient_name,
            $vars,
            $store_id
        );
    }

    protected function attachReports($transactional)
    {
        $file_types = Mage::getStoreConfig(self::XML_PATH_EMAIL_FILES);
        $file_types = explode(',', $file_types);

        if (in_array('csv', $file_types)) {
            $file = $this->exportToCsvFile();
            $transactional = $this->attachFile($transactional, $file);
        }

        if (in_array('xml', $file_types)) {
            $file = $this->exportToExcelFile();
            $transactional = $this->attachFile($transactional, $file);
        }

        return $transactional;
    }

    protected function attachFile($transactional, $attachment)
    {
        if (!empty($attachment) && file_exists($attachment)) {
            $transactional->getMail()
                ->createAttachment(
                    file_get_contents($attachment),
                    Zend_Mime::TYPE_OCTETSTREAM,
                    Zend_Mime::DISPOSITION_ATTACHMENT,
                    Zend_Mime::ENCODING_BASE64,
                    basename($attachment)
                );
        }
        return $transactional;
    }

    protected function getEmails($email)
    {
        if (empty($email)) {
            $email = Mage::getStoreConfig(self::XML_PATH_EMAIL_TO_EMAIL);
        }

        if (!empty($email) && strlen($email) > 5) {
            return explode(',', $email);
        }

        return null;
    }

    public function exportToCsvFile()
    {
        $date = date('d-m-Y_H-i-s');
        $file_name = "transactions_{$date}.csv";

        $content = Mage::app()->getLayout()->createBlock('iwd_ordermanager/adminhtml_transactions_grid')
            ->setData('export_for_email', true)
            ->getCsvFile();

        return $this->saveFile($file_name, $content);
    }

    public function exportToExcelFile()
    {
        $date = date('d-m-Y_H-i-s');
        $file_name = "transactions-{$date}.xml";

        $content = Mage::app()->getLayout()->createBlock('iwd_ordermanager/adminhtml_transactions_grid')
            ->setData('export_for_email', true)
            ->getExcelFile();

        return $this->saveFile($file_name, $content);
    }

    public function saveFile($file_name, $content)
    {
        $io = new Varien_Io_File();

        $path = Mage::getBaseDir('var') . DS . 'export' . DS . 'iwd_settlement_reports' . DS;

        $file = null;
        if (is_array($content)) {
            if ($content['type'] == 'filename') {
                $file = $content['value'];
            }
        }

        if (!$file) {
            return "";
        }

        $io->setAllowCreateFolders(true);
        $io->open(array('path' => $path));
        $io->streamOpen($file_name, 'w+');
        $io->streamClose();

        $io->mv($file, $path . $file_name);

        return $path . $file_name;
    }
}
