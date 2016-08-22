<?php

/*
 * This file is part of the FOSUserBundle package.
 *
 * (c) FriendsOfSymfony <http://friendsofsymfony.github.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Tfe\UserBundle\Form\Type;



use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\LanguageType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\Language;
use Vich\UploaderBundle\Form\Type\VichFileType;
use Vich\UploaderBundle\Form\Type\VichImageType;


class ProfileFormType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array(
            'label' => 'profile.show.name',
            'translation_domain' => 'FOSUserBundle',
            'required'    => false));

        $builder->add('firstname', TextType::class, array(
            'label' => 'profile.show.firstname',
            'translation_domain' => 'FOSUserBundle'));

        $builder->add('age', NumberType::class, array(
            'label' => 'profile.show.age',
            'translation_domain' => 'FOSUserBundle',
            'required'    => false));

        $builder->add('gender', ChoiceType::class, array(
            'choices' => array(
                'Homme' => 'Homme',
                'Femme' => 'Femme',
            ),
            'required'    => false,
            'placeholder' => '',
            'empty_data'  => null,
            'label' => 'profile.show.gender', 'translation_domain' => 'FOSUserBundle'));

        $builder->add('country', CountryType::class, array(
            'label' => 'profile.show.country',
            'translation_domain' => 'FOSUserBundle',
            'required'    => false));

        $builder->add('language', LanguageType::class, array(
            'label' => 'profile.show.language',
            'translation_domain' => 'FOSUserBundle',
            'required'    => false));

        $builder->add('web_site', null, array(
            'label' => 'profile.show.web_site',
            'translation_domain' => 'FOSUserBundle',
            'required'    => false,));

        $builder->add('facebook_account', null, array(
            'label' => 'profile.show.facebook_account',
            'translation_domain' => 'FOSUserBundle',
            'required'    => false));

        $builder->add('twitter_account', null, array(
            'label' => 'profile.show.twitter_account',
            'translation_domain' => 'FOSUserBundle',
            'required'    => false));

        $builder->add('description_user', TextareaType::class, array(
            'label' => 'profile.show.description_user',
            'translation_domain' => 'FOSUserBundle',
            'required'    => false));

        $builder->add('signature', TextareaType::class, array(
            'label' => 'profile.show.signature',
            'translation_domain' => 'FOSUserBundle',
            'required'    => false));

        $builder->add('read_level',ChoiceType::class, array(
            'choices' => array(
                'lecteur débutant' => 'lecteur débutant',
                'lecteur amateur' => 'lecteur amateur',
                'lecteur confirmé' => 'lecteur confirmé',
                'lecteur expert' => 'lecteur expert'
            ),
            'required'    => false,
            'placeholder' => '',
            'empty_data'  => null,
            'label' => 'profile.show.read_level', 'translation_domain' => 'FOSUserBundle'));

        $builder->add('imageFile', VichImageType::class, array( //metre FileType fct aussi todo refaire une belle image pour le bouton
            'required'      => false,
            'allow_delete'  => false, // not mandatory, default is true
            'download_link' => false, // not mandatory, default is true
           ));


    }


    public function getParent()
    {
        return 'FOS\UserBundle\Form\Type\ProfileFormType';

        // Or for Symfony < 2.8
        // return 'fos_user_registration';
    }

    // BC for SF < 3.0


    public function getBlockPrefix()
    {
        return 'tfe_user_profile_edit';
    }
    public function getName()
    {
        return $this->getBlockPrefix();
    }


}
