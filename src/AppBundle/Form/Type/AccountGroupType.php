<?php
// src/AppBundle/Form/Type/AccountGroupType.php
namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType,
    Symfony\Component\Form\FormBuilderInterface,
    Symfony\Component\Form\FormEvent,
    Symfony\Component\Form\FormEvents,
    Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType,
    Symfony\Component\Form\Extension\Core\Type\SubmitType,
    Symfony\Bridge\Doctrine\Form\Type\EntityType;

use JMS\DiExtraBundle\Annotation as DI;

/**
 * @DI\FormType
 */
class AccountGroupType extends AbstractType
{
    /** @DI\Inject("translator") */
    public $_translator;

    private $boundlessReadAccess;

    private $updateOrganizationAccess;

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->boundlessReadAccess      = $options['boundlessReadAccess'];
        $this->updateOrganizationAccess = $options['updateOrganizationAccess'];

        $builder
            ->add('name', TextType::class, [
                'label' => 'account_group.name.label',
                'attr'  => [
                    'placeholder'         => 'account_group.name.placeholder',
                    'data-rule-required'  => "true",
                    'data-msg-required'   => $this->_translator->trans('account_group.name.not_blank', [], 'validators'),
                    'data-rule-minlength' => 2,
                    'data-msg-minlength'  => $this->_translator->trans('account_group.name.length.min', [], 'validators'),
                    'data-rule-maxlength' => 100,
                    'data-msg-maxlength'  => $this->_translator->trans('account_group.name.length.max', [], 'validators'),
                ]
            ])
            ->add('organization', EntityType::class, [
                'class'           => 'AppBundle\Entity\Organization\Organization',
                'empty_data'      => 0,
                'choice_label'    => 'name',
                'label'           => 'account_group.organization.label',
                'placeholder'     => 'common.choice.placeholder',
                'invalid_message' => $this->_translator->trans('account_group.organization.invalid_massage', [], 'validators'),
            ])
        ;

        $builder
            ->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event)
            {
                $accountGroup       = $event->getData();
                $accountGroupExists = ($accountGroup && $accountGroup->getId() !== NULL);

                $form = $event->getForm();

                if( $accountGroupExists )
                {
                    if( $this->updateOrganizationAccess )
                    {
                        $form
                            ->add('organization', EntityType::class, [
                                'class'           => 'AppBundle\Entity\Organization\Organization',
                                'empty_data'      => 0,
                                'choice_label'    => 'name',
                                'label'           => 'account_group.organization.label',
                                'placeholder'     => 'common.choice.placeholder',
                                'invalid_message' => $this->_translator->trans('account_group.organization.invalid_massage', [], 'validators'),
                            ])
                        ;
                    } else {
                        $form
                            ->add('organization', TextType::class, [
                                'required'   => FALSE,
                                'disabled'   => TRUE,
                                'data_class' => 'AppBundle\Entity\Organization\Organization',
                                'label'      => 'account_group.organization.label',
                                'attr'       => [
                                    'readonly' => TRUE,
                                ],
                            ])
                        ;
                    }

                    $form->add('update', SubmitType::class, ['label' => 'common.update.label']);

                    if( $this->boundlessReadAccess )
                        $form->add('update_and_return', SubmitType::class, ['label' => 'common.update_and_return.label']);
                } else {
                    $form->add('create', SubmitType::class, ['label' => 'common.create.label']);

                    if( $this->boundlessReadAccess )
                        $form->add('create_and_return', SubmitType::class, ['label' => 'common.create_and_return.label']);
                }
            })
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class'               => 'AppBundle\Entity\Account\AccountGroup',
            'validation_groups'        => ['AccountGroup'],
            'translation_domain'       => 'forms',
            'boundlessReadAccess'      => NULL,
            'updateOrganizationAccess' => NULL,
        ]);
    }

    public function getBlockPrefix()
    {
        return 'account_group';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
