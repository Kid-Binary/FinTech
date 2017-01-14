<?php
// src/AppBundle/Service/Security/NfcTagBoundlessAccess.php
namespace AppBundle\Service\Security;

use AppBundle\Service\Security\Utility\Abstracted\AbstractBoundlessAccess,
    AppBundle\Service\Security\Utility\Interfaces\UserRoleListInterface;

class NfcTagBoundlessAccess extends AbstractBoundlessAccess implements UserRoleListInterface
{
    const NFC_TAG_READ   = 'nfc_tag_read';
    const NFC_TAG_CREATE = 'nfc_tag_create';

    const NFC_TAG_BIND   = 'nfc_tag_bind';

    public function isGranted($attribute)
    {
        switch($attribute)
        {
            case self::NFC_TAG_READ:
                return $this->_authorizationChecker->isGranted(self::ROLE_MANAGER);
            break;

            case self::NFC_TAG_CREATE:
                return $this->_authorizationChecker->isGranted(self::ROLE_MANAGER);
            break;

            case self::NFC_TAG_BIND:
                return $this->_authorizationChecker->isGranted(self::ROLE_MANAGER);
            break;

            default:
                return FALSE;
            break;
        }
    }
}
