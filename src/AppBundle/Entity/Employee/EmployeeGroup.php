<?php
// AppBundle/Entity/Employee/EmployeeGroup.php
namespace AppBundle\Entity\Employee;

use Serializable;

use Symfony\Component\Security\Core\Role\RoleInterface,
    Symfony\Component\Validator\Constraints as Assert,
    Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Doctrine\ORM\Mapping as ORM,
    Doctrine\Common\Collections\ArrayCollection;

use AppBundle\Entity\Utility\Traits\DoctrineMapping\IdMapperTrait;

/**
 * @ORM\Table(name="employees_groups")
 * @ORM\Entity(repositoryClass="AppBundle\Entity\Employee\Repository\EmployeeGroupRepository")
 *
 * @UniqueEntity(fields="name", message="employee_group.name.unique")
 * @UniqueEntity(fields="role", message="employee_group.role.unique")
 */
class EmployeeGroup implements RoleInterface, Serializable
{
    use IdMapperTrait;

    const ROLE_SUPERADMIN = 'ROLE_SUPERADMIN';
    const ROLE_ADMIN      = 'ROLE_ADMIN';
    const ROLE_MANAGER    = 'ROLE_MANAGER';

    /**
     * @ORM\OneToMany(targetEntity="Employee", mappedBy="employeeGroup")
     */
    private $employees;

    /**
     * @ORM\Column(name="name", type="string", length=20, unique=true)
     *
     * @Assert\NotBlank(message="employee_group.name.not_blank")
     * @Assert\Length(
     *      min=3,
     *      max=20,
     *      minMessage="employee_group.name.length.min",
     *      maxMessage="employee_group.name.length.max"
     * )
     */
    private $name;

    /**
     * @ORM\Column(name="role", type="string", length=25, unique=true)
     *
     * @Assert\NotBlank(message="employee_group.role.not_blank")
     * @Assert\Regex(
     *     pattern="#[ROLE_][A-Z]{3,20}#",
     *     message="employee_group.role.regex"
     * )
     */
    private $role;

    public function __construct()
    {
        $this->employees = new ArrayCollection;
    }

    public function __toString()
    {
        return ( $this->name ) ? $this->name : "";
    }

    /** @see \Serializable::serialize() */
    public function serialize()
    {
        /* ! Don't serialize $users field ! */
        return serialize([
            $this->id,
            $this->role
        ]);
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {
        list(
            $this->id,
            $this->role
        ) = unserialize($serialized);
    }

    /**
     * Set name
     *
     * @param string $name
     * @return EmployeeGroup
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
     * Set role
     *
     * @param string $role
     * @return EmployeeGroup
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @see RoleInterface
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Add employee
     *
     * @param \AppBundle\Entity\Employee\Employee $employee
     * @return EmployeeGroup
     */
    public function addEmployee(\AppBundle\Entity\Employee\Employee $employee)
    {
        $employee->setEmployeeGroup($this);
        $this->employees[] = $employee;

        return $this;
    }

    /**
     * Remove employees
     *
     * @param \AppBundle\Entity\Employee\Employee $employees
     */
    public function removeEmployee(\AppBundle\Entity\Employee\Employee $employees)
    {
        $this->employees->removeElement($employees);
    }

    /**
     * Get employees
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployees()
    {
        return $this->employees;
    }
}
