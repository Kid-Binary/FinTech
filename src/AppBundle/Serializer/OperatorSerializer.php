<?php
// src/AppBundle/Serializer/OperatorSerializer.php
namespace AppBundle\Serializer;

use BadMethodCallException;

use AppBundle\Serializer\Utility\Abstracts\AbstractSyncSerializer,
    AppBundle\Entity\Utility\Interfaces\PropertiesInterface,
    AppBundle\Entity\Operator\Operator,
    AppBundle\Serializer\OperatorGroupSerializer,
    AppBundle\Serializer\OrganizationSerializer,
    AppBundle\Serializer\NfcTagSerializer,
    AppBundle\Serializer\AccountGroupSerializer;

class OperatorSerializer extends AbstractSyncSerializer
{
    private $_serializers = [];

    public function setOperatorGroupSerializer(OperatorGroupSerializer $operatorGroupSerializer)
    {
        $this->_serializers[OperatorGroupSerializer::class] = $operatorGroupSerializer;
    }

    public function setOrganizationSerializer(OrganizationSerializer $organizationSerializer)
    {
        $this->_serializers[OrganizationSerializer::class] = $organizationSerializer;
    }

    public function setNfcTagSerializer(NfcTagSerializer $nfcTagSerializer)
    {
        $this->_serializers[NfcTagSerializer::class] = $nfcTagSerializer;
    }

    public function setAccountGroupSerializer(AccountGroupSerializer $accountGroupSerializer)
    {
        $this->_serializers[AccountGroupSerializer::class] = $accountGroupSerializer;
    }

    static public function getObjectName()
    {
        return 'operator';
    }

    static public function getArrayName()
    {
        return 'operators';
    }

    protected function serialize(PropertiesInterface $operator = NULL)
    {
        return ( $operator instanceof Operator ) ? [
            $operator::PROPERTY_ID        => $operator->getId(),
            $operator::PROPERTY_FULL_NAME => $operator->getFullName(),
        ] : FALSE;
    }

    protected function unserialize(array $serializedOperator = NULL)
    {
        $operator = new Operator();

        $operator
            ->setId(
                !empty($serializedOperator[$operator::PROPERTY_ID])
                    ? $serializedOperator[$operator::PROPERTY_ID]
                    : NULL
            )
        ;

        return $operator;
    }

    protected function syncSerialize(PropertiesInterface $operator = NULL)
    {
        if( !($operator instanceof Operator) )
            return NULL;

        $serialized = $this->serialize($operator);

        $serialized = array_merge(
            $serialized,
            $this->_serializers[OperatorGroupSerializer::class]->serializeObject(
                $operator->getOperatorGroup()
            )
        );

        $serialized = array_merge(
            $serialized,
            $this->_serializers[OrganizationSerializer::class]->serializeObject(
                $operator->getOrganization()
            )
        );

        $serialized = array_merge(
            $serialized,
            $this->_serializers[NfcTagSerializer::class]->serializeObject(
                $operator->getNfcTag()
            )
        );

        $serialized = array_merge(
            $serialized,
            $this->_serializers[AccountGroupSerializer::class]->serializeArray(
                $operator->getAccountGroups()
            )
        );

        return $serialized;
    }

    public function syncUnserialize(array $serializedOperator = NULL)
    {
        throw new BadMethodCallException('Not implemented!');
    }
}
