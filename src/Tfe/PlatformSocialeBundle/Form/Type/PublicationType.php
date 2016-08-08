<?php
namespace Tfe\PlatformSocialeBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PublicationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titrePublication');
        $builder->add('contentPublication');
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Tfe\PlatformSocialeBundle\Entity\Publication',
            'csrf_protection' => false // Dans une API, il faut obligatoirement désactiver la protection CSRF (Cross-Site Request Forgery).
            // Nous n'utilisons pas de session et l'utilisateur de l'API peut appeler cette méthode sans se soucier de l'état de l'application : l'API doit rester sans état : stateless.
        ]);
    }
}