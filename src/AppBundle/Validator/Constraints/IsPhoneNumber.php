<?php
// src/AppBundle/Validator/Constraints/IsPhoneNumber.php
namespace AppBundle\Validator\Constraints;

use Symfony\Component\Validator\Constraint;

/**
 * @Annotation
 */
class IsPhoneNumber extends Constraint
{
   public $message = "custom.phone_number.valid";
}
