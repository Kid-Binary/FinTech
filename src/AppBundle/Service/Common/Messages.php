<?php
// AppBundle/Service/Common/Messages.php
namespace AppBundle\Service\Common;

use Symfony\Component\HttpFoundation\Session\Session,
    Symfony\Component\Translation\TranslatorInterface;

use AppBundle\Service\Common\Utility\Interfaces\MessagesInterface;

class Messages implements MessagesInterface
{
    private $_session;
    private $_translator;

    public function setSession(Session $session)
    {
        $this->_session = $session;
    }

    public function setTranslator(TranslatorInterface $translator)
    {
        $this->_translator = $translator;
    }

    static public function getMessagesTypes()
    {
        return [
            self::MESSAGES_INFO,
            self::MESSAGES_WARNING,
            self::MESSAGES_SUCCESS,
            self::MESSAGES_ERRORS
        ];
    }

    public function getMessages()
    {
        $messages = [];

        if( $this->_session->getFlashBag()->has(self::MESSAGES_ROOT) )
        {
            foreach( $this->_session->getFlashBag()->get(self::MESSAGES_ROOT) as $messageArray )
            {
                foreach($messageArray as $type => $message)
                {
                    if( in_array($type, self::getMessagesTypes(), TRUE) ) {
                        $messages[$type] = $message;
                    }
                }
            }
        }

        return $messages;
    }

    // CRUD

    public function markFormInvalid()
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_ERRORS => [[$this->_translator->trans('common.error.form_invalid', [], 'responses')]]
        ]);
    }

    public function markCreateSuccess()
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_SUCCESS => [$this->_translator->trans('common.success.create', [], 'responses')]
        ]);
    }

    public function markUpdateSuccess()
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_SUCCESS => [$this->_translator->trans('common.success.update', [], 'responses')]
        ]);
    }

    public function markDeleteSuccess()
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_SUCCESS => [$this->_translator->trans('common.success.delete', [], 'responses')]
        ]);
    }

    public function markUnDeleteSuccess()
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_SUCCESS => [$this->_translator->trans('common.success.un_delete', [], 'responses')]
        ]);
    }

    public function markBindSuccess($message)
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_SUCCESS => [$message]
        ]);
    }

    public function markUnbindSuccess($message)
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_SUCCESS => [$message]
        ]);
    }

    // Payment

    public function markPaymentManualReplenishSuccess()
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_SUCCESS => [$this->_translator->trans('payment.manual.replenish.success', [], 'responses')]
        ]);
    }

    public function markPaymentManualReplenishErrors(array $errors)
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_ERRORS => $errors
        ]);
    }

    public function markPaymentReceiptCheckSuccess()
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_SUCCESS => [$this->_translator->trans('payment.receipt.check.success', [], 'responses')]
        ]);
    }

    public function markPaymentReceiptCheckErrors(array $errors)
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_ERRORS => $errors
        ]);
    }

    public function markPaymentReceiptReplenishSuccess()
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_SUCCESS => [$this->_translator->trans('payment.receipt.replenish.success', [], 'responses')]
        ]);
    }

    public function markPaymentReceiptReplenishErrors(array $errors)
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_ERRORS => $errors
        ]);
    }

    // Activation

    public function markActivationNfcTagSuccess()
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_SUCCESS => [$this->_translator->trans('activation.nfc_tag.success', [], 'responses')]
        ]);
    }

    public function markActivationNfcTagWarning()
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_WARNING => [$this->_translator->trans('activation.nfc_tag.warning', [], 'responses')]
        ]);
    }

    public function markActivationNfcTagErrors(array $errors)
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_ERRORS => $errors
        ]);
    }

    // Website

    public function markWebsiteFeedbackSuccess()
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_SUCCESS => [$this->_translator->trans('website.feedback.success', [], 'responses')]
        ]);
    }

    public function markWebsiteFeedbackError()
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_ERRORS => [$this->_translator->trans('website.feedback.error', [], 'responses')]
        ]);
    }

    public function markWebsiteFeedbackErrors(array $errors)
    {
        $this->_session->getFlashBag()->add(self::MESSAGES_ROOT, [
            self::MESSAGES_ERRORS => $errors
        ]);
    }
}
