<?php
// src/AppBundle/Entity/Transaction/Replenishment.php
namespace AppBundle\Entity\Transaction;

use Symfony\Component\Validator\Constraints as Assert,
    Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\Transaction\Transaction;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Transaction\Repository\TransactionRepository")
 */
class Replenishment extends Transaction
{
    static public function getTypeIdString()
    {
        return 'replenishment_read';
    }
}
