<?php

namespace Tfe\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Doctrine\UserManager;
use Tfe\UserBundle\Entity\Users as User;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TfeUserBundle::layout.html.twig');
    }

    public function deleteUserAction(User $user) {
        $userManager = $this->container->get('fos_user.user_manager');
        $userManager->deleteUser($user);
        $this->get('session')->getFlashBag()->add('success', $user->getUsername() . ' effacé');
        return $this->redirectToRoute('tfe_user_homepage');

    }


    public function communauteAction()
    {
        /*$form = $this->get('form.factory')->createBuilder(FormType::class, $order)
            ->add('gender', ChoiceType::class, array(
            'choices' => array(
                'Homme' => 'Homme',
                'Femme' => 'Femme',
            ),
            'required'    => false,
            'placeholder' => '',
            'empty_data'  => null,
            'label' => 'profile.show.gender', 'translation_domain' => 'FOSUserBundle'));*/


        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();
        return $this->render('TfeUserBundle:Communaute:listUser.html.twig', array(
        'users' =>   $users
        ));
    }

    public function profilAction()
    {
        return $this->render('TfeUserBundle:Communaute:profilUser.html.twig');
    }

}
