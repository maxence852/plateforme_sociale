<?php
namespace Tfe\RestBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('address');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Tfe\RestBundle\Entity\Place',
            'csrf_protection' => false // Dans une API, il faut obligatoirement désactiver la protection CSRF (Cross-Site Request Forgery).
                                        // Nous n'utilisons pas de session et l'utilisateur de l'API peut appeler cette méthode sans se soucier de l'état de l'application : l'API doit rester sans état : stateless.
        ]);
    }
}