<?php
// src/AppBundle/Serializer/BankingMachineSerializer.php
namespace AppBundle\Serializer;

use AppBundle\Serializer\Utility\Abstracts\AbstractSyncSerializer,
    AppBundle\Entity\Utility\Interfaces\PropertiesInterface,
    AppBundle\Entity\BankingMachine\BankingMachine,
    AppBundle\Serializer\OrganizationSerializer;

class BankingMachineSerializer extends AbstractSyncSerializer
{
    private $_serializers = [];

    public function setOrganizationSerializer(OrganizationSerializer $organizationSerializer)
    {
        $this->_serializers[OrganizationSerializer::class] = $organizationSerializer;
    }

    static public function getObjectName()
    {
        return 'banking-machine';
    }

    static public function getArrayName()
    {
        return 'banking-machines';
    }

    protected function serialize(PropertiesInterface $bankingMachine = NULL)
    {
        return ( $bankingMachine instanceof BankingMachine ) ? [
            $bankingMachine::PROPERTY_ID       => $bankingMachine->getId(),
            $bankingMachine::PROPERTY_SERIAL   => $bankingMachine->getSerial(),
            $bankingMachine::PROPERTY_NAME     => $bankingMachine->getName(),
            $bankingMachine::PROPERTY_ADDRESS  => $bankingMachine->getAddress(),
            $bankingMachine::PROPERTY_LOCATION => $bankingMachine->getLocation(),
        ] : NULL;
    }

    protected function syncSerialize(PropertiesInterface $bankingMachine = NULL)
    {
        if( !($bankingMachine instanceof BankingMachine) )
            return NULL;

        $serialized = $this->serialize($bankingMachine);

        $serialized = array_merge(
            $serialized,
            $this->_serializers[OrganizationSerializer::class]->serializeObject($bankingMachine->getOrganization())
        );

        return $serialized;
    }
}
