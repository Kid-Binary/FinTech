<?php
// src/SyncBundle/Service/Security/Authentication.php
namespace SyncBundle\Service\Security;

use Symfony\Component\HttpFoundation\Request;

use AppBundle\Entity\BankingMachine\BankingMachine;

use UtilityBundle\Service\Security\PasswordEncoder;

class Authentication
{
    private $_passwordEncoder;

    public function setPasswordEncoder(PasswordEncoder $passwordEncoder)
    {
        $this->_passwordEncoder = $passwordEncoder;
    }

    public function isAuthenticated(Request $request, BankingMachine $bankingMachine)
    {
        $requestContent = json_decode($request->getContent(), TRUE);

        if( empty($requestContent['authentication']) )
            return FALSE;

        $authentication = $requestContent['authentication'];

        if( empty($authentication['login']) || empty($authentication['password']) )
            return FALSE;

        if( $authentication['login'] !== $bankingMachine->getLogin() )
            return FALSE;

        if( !$this->_passwordEncoder->isPasswordValid($authentication['password'], $bankingMachine->getPassword()) )
            return FALSE;

        return TRUE;
    }
}
