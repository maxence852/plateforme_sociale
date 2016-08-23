<?php



namespace Tfe\UserBundle\Form\Type;

use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;


class CommunauteFormType extends AbstractType

{

    public function buildForm(FormBuilderInterface $builder, array $options)

    {

       /* $builder ->add('tris', ChoiceType::class, array(
            'choices' => array(
                'croisssant' => 'croisssant',
                'decroissant' => 'decroissant')))
            ->add('trier',SubmitType::class)

            ;
        /*
        $form = $this->createFormBuilder()
            ->add('tris', ChoiceType::class, array(
                'choices' => array(
                    'croisssant' => 'croisssant',
                    'decroissant' => 'decroissant')))
            ->add('trier',SubmitType::class)

            ->getForm();*/


    }

    public function getName()

    {

        return 'tfeuserbundle_communaute';

    }

}