<?php
// src/AppBundle/Entity/Organization/Repository/OrganizationRepository.php
namespace AppBundle\Entity\Organization\Repository;

use AppBundle\Entity\Utility\Extended\ExtendedEntityRepository;

class OrganizationRepository extends ExtendedEntityRepository
{
    // BEGIN: Extended find methods
    public function findChained()
    {
        $this->chain = $this->createQueryBuilder('org')
            ->select('org')
        ;

        return $this;
    }

    public function chainFindBy(array $findBy)
    {
        $this->baseChainFindBy($findBy, 'org');

        return $this;
    }

    public function chainSearchBy($searchBy)
    {
        $entityFields = [
            'org.name',
        ];

        $this->baseChainSearchBy($searchBy, $entityFields);

        return $this;
    }
    // END: Extended find methods
}
