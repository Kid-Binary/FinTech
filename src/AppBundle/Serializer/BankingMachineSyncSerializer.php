<?php
// src/AppBundle/Serializer/BankingMachineSyncSerializer.php
namespace AppBundle\Serializer;

use DateTime;

use AppBundle\Serializer\Utility\Abstracts\AbstractSyncSerializer,
    AppBundle\Entity\Utility\Interfaces\PropertiesInterface,
    AppBundle\Entity\BankingMachine\BankingMachineSync;

class BankingMachineSyncSerializer extends AbstractSyncSerializer
{
    static public function getObjectName()
    {
        return 'sync';
    }

    static public function getArrayName()
    {
        return 'syncs';
    }

    static public function getSyncIdPropertyName()
    {
        return BankingMachineSync::PROPERTY_SYNC_ID;
    }

    static public function getSyncTypePropertyName()
    {
        return BankingMachineSync::PROPERTY_SYNC_TYPE;
    }

    static public function getSyncAtPropertyName()
    {
        return BankingMachineSync::PROPERTY_SYNC_AT;
    }

    static public function getChecksumPropertyName()
    {
        return BankingMachineSync::PROPERTY_CHECKSUM;
    }

    static public function getDataPropertyName()
    {
        return BankingMachineSync::PROPERTY_DATA;
    }

    protected function serialize(PropertiesInterface $bankingMachineSync = NULL)
    {
        return ( $bankingMachineSync instanceof BankingMachineSync ) ? [
            $bankingMachineSync::PROPERTY_SYNC_ID => $bankingMachineSync->getSyncId(),
            $bankingMachineSync::PROPERTY_SYNC_AT => $bankingMachineSync->getSyncAt()->format('Y-m-d H:i:s'),
        ] : FALSE;
    }

    protected function unserialize(array $serializedBankingMachineSync = NULL)
    {
        $bankingMachineSync = new BankingMachineSync();

        $bankingMachineSync
            ->setSyncId(
                !empty($serializedBankingMachineSync[$bankingMachineSync::PROPERTY_SYNC_ID])
                    ? $serializedBankingMachineSync[$bankingMachineSync::PROPERTY_SYNC_ID]
                    : NULL
            )
            ->setSyncAt(
                !empty($serializedBankingMachineSync[$bankingMachineSync::PROPERTY_SYNC_AT])
                    ? new DateTime($serializedBankingMachineSync[$bankingMachineSync::PROPERTY_SYNC_AT])
                    : NULL
            )
            ->setChecksum(
                !empty($serializedBankingMachineSync[$bankingMachineSync::PROPERTY_CHECKSUM])
                    ? $serializedBankingMachineSync[$bankingMachineSync::PROPERTY_CHECKSUM]
                    : NULL
            )
            ->setData(
                !empty($serializedBankingMachineSync[$bankingMachineSync::PROPERTY_DATA])
                    ? json_encode($serializedBankingMachineSync[$bankingMachineSync::PROPERTY_DATA])
                    : NULL
            )
        ;

        return $bankingMachineSync;
    }

    protected function syncSerialize(PropertiesInterface $bankingMachineSync = NULL)
    {
        if( !($bankingMachineSync instanceof BankingMachineSync) )
            return NULL;

        $serialized = $this->serialize($bankingMachineSync);

        return $serialized;
    }

    public function syncUnserialize(array $serializedBankingMachineSync = NULL)
    {
        $bankingMachineSync = $this->unserializeObject($serializedBankingMachineSync);

        return $bankingMachineSync;
    }
}
