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



    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function communauteAction(Request $request)
    {
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        $paginator  = $this->get('knp_paginator');
        $users = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1)/*page number*/,
            2/*limit per page*/
        );

        return $this->render('TfeUserBundle:Communaute:listUser.html.twig', array(
            'users' =>   $users,
            'paginator'=> $paginator
        ));
    }

}
