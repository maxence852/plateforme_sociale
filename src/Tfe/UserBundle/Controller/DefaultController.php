<?php

namespace Tfe\UserBundle\Controller;


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
        $userManager = $this->get('fos_user.user_manager');
        $users = $userManager->findUsers();

        $paginator  = $this->get('knp_paginator');
        $users = $paginator->paginate(
            $users,
            $request->query->getInt('page', 1)/*page number*/,
            5/*limit per page*/
        );
        /*************Formulaire pour trier par odre croissant et décroissabt ************/
        $form = $this->createFormBuilder()
            ->add('tris', ChoiceType::class, array(
                'label'=> 'trier par',
                'choices' => array(
                    'croisssant' => 'croisssant',
                    'decroissant' => 'decroissant')))
            ->add('trier',SubmitType::class)
        ->getForm();

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                return $this->redirectToRoute('tfe_forum_homepage');
            }
        }

        /*************Formulaire Recherche utilisateur ************/
        $form2 = $this->createFormBuilder()
            ->add('rechercher', TextType::class, array(
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
                return $this->redirectToRoute('tfe_platform_sociale_homepage');
            }
        }

        //$abonnementsRepo = new AbonnementUser();

        $abonnementsRepo = $this->getDoctrine()
            ->getManager()
            ->getRepository('TfeUserBundle:AbonnementUser')
            ->getAbonnements($this->getUser());

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
