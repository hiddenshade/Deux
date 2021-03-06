<?php
/**
 * Created by PhpStorm.
 * User: alephzero
 * Date: 30/05/16
 * Time: 08:19
 */

namespace AppBundle\Form\Type;

use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use FOS\UserBundle\Form\Type\ProfileFormType as BaseType;

class ProfileFormType extends BaseType
{
    private $class;

    /**
     * Builds the embedded form representing the user.
     *
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    protected function buildUserForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('email', null, ['label'=>'Email: '])
            ->add('pregunta', TextType::class, ['label'=>'Pregunta secreta: '])
            ->add('respuesta', TextType::class, ['label'=>'Respuesta: '])
            ->add('fechaDeNacimiento', DateType::class, ['label'=>'Fecha de Nacimiento: '])
            ->add('pais', CountryType::class, ['label'=>'Pais: '])
            ->add('provincia', TextType::class, ['label'=>'Provincia: '])
            ->add('localidad', TextType::class, ['label'=>'Localidad: '])
            ->add('calle', TextType::class, ['label'=>'Domicilio: '])
        ;
    }

    public function __construct($class)
    {
        parent::__construct($class);
    }

    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Usuario'
        ));
    }

    public function getBlockPrefix()
    {
        return 'app_user_profile';
    }

    public function getName()
    {
        return $this->getBlockPrefix();
    }
}
