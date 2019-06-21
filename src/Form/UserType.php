<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use App\Form\DataTransformer\StringToArrayTransformer;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

class UserType extends AbstractType
{
    private $checker;
    private $translator;

    public function __construct(AuthorizationCheckerInterface $checker, TranslatorInterface $translator)
    {
        $this->checker = $checker;
        $this->translator = $translator;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->add('email', EmailType::class)
            ->add('firstname')
            ->add('lastname')
            ->add(
                'password',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'first_options'  => array('label' => $this->translator->trans('Password')),
                    'second_options' => array('label' => $this->translator->trans('Repeat Password'))
                ]
            )
            ->add('role', ChoiceType::class, [
                'mapped' => false,
                'choices' => array(
                    'User' => 'ROLE_USER',
                    'Admin' => 'ROLE_ADMIN',
                ),
            ])
            ->add('audit')
            ->add('isActive', CheckboxType::class, array(
                'required' => false,
                'label' => $this->translator->trans('Account activated'),
            ));
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'form_type' => 'register',
        ]);
    }
}
