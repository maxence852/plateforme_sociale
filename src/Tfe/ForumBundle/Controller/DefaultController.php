<?php

namespace Tfe\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Tfe\ForumBundle\Entity\Category;
use Tfe\ForumBundle\Entity\Group;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        /********** Enregistrement d'un nouveau Groupe ds le forum ********************/
        $group = new Group();

        $form = $this->get('form.factory')->createBuilder(FormType::class, $group)
            ->add('title', TextType::class, array(
                'required'    => false))
            ->add('save',      SubmitType::class)
            ->getForm()
        ;
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($group);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'title bien enregistrée.');
                // Puis on redirige vers la page de visualisation de cettte annonce
                return $this->redirectToRoute('tfe_forum_homepage', array('id' => $group->getId()));
            }
        }
        $groups = $this->getDoctrine()
            ->getManager()
            ->getRepository('TfeForumBundle:Group')
            ->myFindAll();




        $cats = $this->getDoctrine()
            ->getManager()
            ->getRepository('TfeForumBundle:Category')
            ->myFindAll();

        return $this->render('TfeForumBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
            'groups'=> $groups,
           'myCats'=> $cats,
        ));



    }


    public function addCategoryAction(Request $request)
    {

        /********** Enregistrement d'une nouvelle Categorie ds le forum ********************/

        $category = new Category();
        $form = $this->get('form.factory')->createBuilder(FormType::class, $category)
            ->add('title', TextType::class, array(
                'required'    => false))
            ->add('save',      SubmitType::class)
            ->getForm()
        ;
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'title bien enregistrée.');
                // Puis on redirige vers la page de visualisation de cettte annonce
                return $this->redirectToRoute('tfe_forum_homepage', array('id' => $category->getId()));
            }
        }
        return $this->render('TfeForumBundle:Default:index.html.twig', array(
            'formC' => $form->createView(),
        ));
    }


}
