<?php
// src/AppBundle/Entity/Operator/Operator.php
namespace AppBundle\Entity\Operator;

use Symfony\Component\Validator\Constraints as Assert,
    Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\ORM\Mapping as ORM;

use AppBundle\Entity\Utility\Traits\DoctrineMapping\IdMapperTrait,
    AppBundle\Entity\Utility\Traits\DoctrineMapping\PseudoDeleteMapperTrait,
    AppBundle\Validator\Constraints as CustomAssert;

/**
 * @ORM\Table(name="operators")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Operator\Repository\OperatorRepository")
 * @ORM\InheritanceType("SINGLE_TABLE")
 * @ORM\DiscriminatorColumn(name="discriminator", type="string")
 * @ORM\DiscriminatorMap({"operator" = "Operator", "collector" = "Collector", "cashier" = "Cashier"})
 */
class Operator
{
    use IdMapperTrait, PseudoDeleteMapperTrait;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Organization\Organization", inversedBy="operators")
     * @ORM\JoinColumn(name="organization_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $organization;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\BankingMachine\BankingMachine", inversedBy="operators")
     * @ORM\JoinColumn(name="banking_machine_id", referencedColumnName="id", nullable=true, onDelete="SET NULL")
     */
    protected $bankingMachine;

    /**
     * @ORM\OneToOne(targetEntity="AppBundle\Entity\NfcTag\NfcTag", mappedBy="operator")
     */
    protected $nfcTag;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank(message="operator.name.not_blank")
     * @Assert\Length(
     *      min=2,
     *      max=100,
     *      minMessage="common.human_name.length.min",
     *      maxMessage="common.human_name.length.max"
     * )
     * @CustomAssert\IsHumanName
     */
    protected $name;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank(message="operator.surname.not_blank")
     * @Assert\Length(
     *      min=2,
     *      max=100,
     *      minMessage="common.human_name.length.min",
     *      maxMessage="common.human_name.length.max"
     * )
     * @CustomAssert\IsHumanName
     */
    protected $surname;

    /**
     * @ORM\Column(type="string", length=100)
     *
     * @Assert\NotBlank(message="operator.patronymic.not_blank")
     * @Assert\Length(
     *      min=2,
     *      max=100,
     *      minMessage="common.human_name.length.min",
     *      maxMessage="common.human_name.length.max"
     * )
     * @CustomAssert\IsHumanName
     */
    protected $patronymic;

    public function __toString()
    {
        return ( $this->id ) ? $this->id : "";
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Operator
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Operator
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set patronymic
     *
     * @param string $patronymic
     *
     * @return Operator
     */
    public function setPatronymic($patronymic)
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    /**
     * Get patronymic
     *
     * @return string
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }

    /**
     * Get pseudoDeleteAt
     *
     * @return \DateTime
     */
    public function getPseudoDeleteAt()
    {
        return $this->pseudoDeleteAt;
    }

    /**
     * Set organization
     *
     * @param \AppBundle\Entity\Organization\Organization $organization
     *
     * @return Operator
     */
    public function setOrganization(\AppBundle\Entity\Organization\Organization $organization = null)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Get organization
     *
     * @return \AppBundle\Entity\Organization\Organization
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Set bankingMachine
     *
     * @param \AppBundle\Entity\BankingMachine\BankingMachine $bankingMachine
     *
     * @return Operator
     */
    public function setBankingMachine(\AppBundle\Entity\BankingMachine\BankingMachine $bankingMachine = null)
    {
        $this->bankingMachine = $bankingMachine;

        return $this;
    }

    /**
     * Get bankingMachine
     *
     * @return \AppBundle\Entity\BankingMachine\BankingMachine
     */
    public function getBankingMachine()
    {
        return $this->bankingMachine;
    }

    /**
     * Set nfcTag
     *
     * @param \AppBundle\Entity\NfcTag\NfcTag $nfcTag
     *
     * @return Operator
     */
    public function setNfcTag(\AppBundle\Entity\NfcTag\NfcTag $nfcTag = null)
    {
        $this->nfcTag = $nfcTag;

        return $this;
    }

    /**
     * Get nfcTag
     *
     * @return \AppBundle\Entity\NfcTag\NfcTag
     */
    public function getNfcTag()
    {
        return $this->nfcTag;
    }

    /*-------------------------------------------------------------------------
    | CUSTOM GETTERS
    |------------------------------------------------------------------------*/

    public function getFullName()
    {
        if( !$this->name || !$this->surname )
            return NULL;

        $fullName = [$this->name, $this->surname];

        if( $this->patronymic )
            $fullName[] = $this->patronymic;

        return implode(' ', $fullName);
    }
}