<?php

class ProxiBlue_DynCatProd_Helper_Email extends Mage_Core_Helper_Abstract
{

    /**
     * Email notifications
     *
     * @return boolean
     */
    public function sendEmail($subject, $message, $sender, $to)
    {
        try {
            // this is preferred over using Zend_Mail directly, as it will not bypass 3rd party mailer hooks
            // (like mandrill or various smtp senders)
            $template = Mage::getModel('core/email_template');
            // populate the template with data
            $template->setTemplateSubject($subject);
            $template->setTemplateText($message);
            $template->setSenderName(Mage::getStoreConfig('trans_email/ident_' . $sender . '/name'));
            $template->setSenderEmail(Mage::getStoreConfig('trans_email/ident_' . $sender . '/email'));
            $template->isPlain(true);
            if (!$template->send(
                Mage::getStoreConfig('trans_email/ident_' . $to . '/email'),
                Mage::getStoreConfig('trans_email/ident_' . $to . '/name'), array()
            )
            ) {
                Mage::log("could not send email with subject {$subject}");
                return false;
            }
        } catch (Exception $e) {
            mage::logException($e);
        }
        return true;
    }
}