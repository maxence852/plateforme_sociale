<?php

namespace Tfe\UserBundle\Controller;


use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\DependencyInjection\ContainerInterface as Container;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use FOS\UserBundle\Doctrine\UserManager;
use Tfe\UserBundle\Entity\AbonnementUser;
use Tfe\UserBundle\Entity\Users as User;
use Tfe\UserBundle\Entity\Users;
use Tfe\UserBundle\Form\Type\CommunauteFormType;
use Tfe\UserBundle\Repository\AbonnementUserRepository;

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
        /* $userManager     = $this->getDoctrine()->getManager();
          $sql = "SELECT  * FROM tfe_users ORDER BY username ASC";
        $users = $userManager->getConnection()->prepare($sql);$users->execute();*/



        $userManager = $this->get('fos_user.user_manager');
        /*************Formulaire Recherche utilisateur ************/
        $searchUser = new SearchUser();
        $form2 = $this->createFormBuilder($searchUser)
            ->add('searchUser', TextType::class, array(
                'required'    => true,
                'attr'  => array(
                    'placeholder'=> 'Nom utilisateur',
                )))
            ->add('rechercherUser',SubmitType::class, array(
                'label'=> 'rechercher'
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form2->handleRequest($request);
            if ($form2->isValid()) {
                $data = $form2->getData();
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TfeUserBundle:Users')
                ;
                $_SESSION['searchedUsername'] = $data->getSearchUser();
                $_SESSION['orderby'] = 0;
            }
        }


        /*************Formulaire pour trier par odre croissant et décroissabt ************/
        $choiceOrder = new ChoiceOrder();
        $form = $this->createFormBuilder($choiceOrder)
            ->add('orderby', ChoiceType::class, array(
                'choices' => array(
                    'croisssant' => 'asc',
                    'décroissant' => 'desc')))
            ->add('trier',SubmitType::class)
            ->getForm();

        if ($request->isMethod('POST')) {
            // $form->bindRequest($request);
            $value = $form->getData();
            $form->handleRequest($request);
            if ($form->isValid()) {
                if($value->getOrderBy()=='asc'){
                    $_SESSION['orderby'] = 0;
                }
                else if($value->getOrderBy()=='desc'){
                    $_SESSION['orderby'] = 1;
                }
                /*return $this->redirectToRoute('tfe_user_communaute', array(
                    'users'=> $users
                ));*/
            }
        }

        if(!isset( $_SESSION['searchedUsername']))  $searchUser = '';
        else $searchUser = $_SESSION['searchedUsername'];
        if(!isset( $_SESSION['orderby'])) $orderBy = 0;
        else $orderBy = $_SESSION['orderby'];

        if($searchUser=='' && $orderBy==0)
        {
            $repository = $this ->getDoctrine()->getManager()->getRepository('TfeUserBundle:Users');
            $users= $repository->FindUsersAscAll();
        }
        else if($searchUser!='' && $orderBy==0)
        {
            $repository = $this ->getDoctrine()->getManager()->getRepository('TfeUserBundle:Users');
            $users= $repository->FindUsersAsc($searchUser);
        }
        else if($searchUser!='' && $orderBy==1)
        {
            $repository = $this ->getDoctrine()->getManager()->getRepository('TfeUserBundle:Users');
            $users= $repository->FindUsersDesc($searchUser);
        }
        else
        {
            $repository = $this ->getDoctrine()->getManager()->getRepository('TfeUserBundle:Users');
            $users= $repository->FindUsersDescAll();
        }


        //$abonnementsRepo = new AbonnementUser();

        $abonnementsRepo = $this->getDoctrine()
            ->getManager()
            ->getRepository('TfeUserBundle:AbonnementUser')
            ->getAbonnements($this->getUser());

        $paginator  = $this->get('knp_paginator');
        $users = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1),
            5 /*limit per page*/
        );

        return $this->render('TfeUserBundle:Communaute:listUser.html.twig', array(
            'users' =>   $users,
            'paginator'=> $paginator,
            'form'=> $form->createView(),
            'form2'=> $form2->createView(),
            'abonnementsRepo' => $abonnementsRepo
        ));
    }

    public function communauteProfilAction($id)
    {
        $em     = $this->getDoctrine()->getManager();
        $user = $em->find('Tfe\UserBundle\Entity\Users', $id);

        //$userManager = $this->get('fos_user.user_manager');
        //$user = $userManager->find($id);
        return $this->render('TfeUserBundle:Communaute:profilUser.html.twig', array(
            'user'=> $user

        ));
    }

    public function communauteAbonnementAction($suiveurId, $suiviId)
    {
        $abonnement = new AbonnementUser();
        $abonnement->setSuiveurId($suiveurId);
        $abonnement->setSuiviId($suiviId);
        $em     = $this->getDoctrine()->getManager();
        $em->persist($abonnement);
        $em->flush();
        return $this->redirectToRoute('tfe_user_communaute');



    }

    public function communauteDesabonnementAction($suiveurId, $suiviId)
    {
        /*        $em = $this->getDoctrine()->getManager();
                $abonnements = $em->getRepository('TfeUserBundle:AbonnementUser')
                    ->getAbonnements($suiveud, $suiviId);
        /*
                foreach  ($abonnements as $abo) {
                    $abonnement = new AbonnementUser();
                    $abonnement->setSuiveurId($abo[0]);
                    $abonnement->setSuiviId($abo->getSuiviId());
                    $em->remove($abonnement);
                    $em->flush();
                }

        delete from abonnement_user where suiveurid = 13 and suiviid=17;

        .
        */
        $abonnement = new AbonnementUser();
        $abonnement->setSuiveurId($suiveurId);
        $abonnement->setSuiviId($suiviId);

        $em     = $this->getDoctrine()->getManager();
        $sql = "delete from abonnement_user where suiveurid =" . $suiveurId . " and suiviid=" . $suiviId;
        $stmt = $em->getConnection()->prepare($sql);$stmt->execute();
        return $this->redirectToRoute('tfe_user_communaute');
    }



}
