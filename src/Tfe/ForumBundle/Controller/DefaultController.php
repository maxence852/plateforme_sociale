<?php

namespace Tfe\ForumBundle\Controller;

use JMS\Serializer\Annotation\Groups;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Tfe\ForumBundle\Entity\Category;
use Tfe\ForumBundle\Entity\Groupe;

class DefaultController extends Controller
{
    public function indexAction(Request $request)
    {
        /********** Enregistrement d'un nouveau Groupe ds le forum ********************/
        $group = new Groupe();

        $form = $this->get('form.factory')->createBuilder(FormType::class, $group)
            ->add('title', TextType::class, array(
                'required'    => false))
            ->add('save',      SubmitType::class)
            ->getForm()
        ;
            $category = new Category();
        $form1 = $this->get('form.factory')->createBuilder(FormType::class, $category)
            ->add('title', TextType::class, array(
                'required'    => true))
            ->add('save',      SubmitType::class)
            ->getForm()
        ;
        $form2 = $this->get('form.factory')->createBuilder(FormType::class, $group)
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

        /*********récupère groupe *********/

        $groups = $this->getDoctrine()
            ->getManager()
            ->getRepository('TfeForumBundle:Groupe')
            ->myFindAll();

        $AllCats = array();
        $i=0;
        foreach ($groups as $group){
                //$index = $group['id'];
                $cats = $this->getDoctrine()
                    ->getManager()
                    ->getRepository('TfeForumBundle:Category')
                    ->myFindAllByGroup($group);
                $AllCats[$i]=$cats;
                $i++;
        }


        return $this->render('TfeForumBundle:Default:index.html.twig', array(
            'form' => $form->createView(),
            'groups'=> $groups,
            'form1' => $form1->createView(),
            'form2' => $form2->createView()
        ));



    }


    public function addCategoryAction(Request $request)
    {

        /********** Enregistrement d'une nouvelle Categorie ds le forum ********************/
        $groupId = $_POST["groupId"];
        $group = new Groupe();
        $form = $this->get('form.factory')->createBuilder(FormType::class, $group)
            ->add('title', TextType::class, array(
                'required'    => false))
           /* ->add('groupe', TextType::class, array(
                'required'    => false))*/
            ->add('save',      SubmitType::class)
            ->getForm()
        ;

        $category = new Category();
        $form1 = $this->get('form.factory')->createBuilder(FormType::class, $category)
            ->add('title', TextType::class, array(
                'required'    => true))
            ->add('save',      SubmitType::class)
            ->getForm()
        ;
        $formOk=false;
        if ($request->isMethod('POST')) {
            $form1->handleRequest($request);
            if ($form1->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $repo = $em->getRepository('TfeForumBundle:Groupe');
                $group = $repo->find($groupId);
                $group->addCategory($category);
                //$em->persist($group);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'title bien enregistrée.');
                // Puis on redirige vers la page de visualisation de cettte annonce
                $formOk=true;
            }
        }

        $groups = $this->getDoctrine()
            ->getManager()
            ->getRepository('TfeForumBundle:Groupe')
            ->myFindAll();
        if($formOk == true){
            return $this->redirectToRoute('tfe_forum_homepage', array(
                'form' => $form->createView(),
                'groups'=> $groups,
                'form1' => $form1->createView(),
                'id' => $category->getId()));
        }
        return $this->render('TfeForumBundle:Default:index.html.twig', array(
            'formC' => $form->createView(),
            'form' => $form->createView(),
            'groups'=> $groups,
            'form1' => $form1->createView(),
        ));
    }

    public function deleteGroupAction()
    {
        $groupId = $_POST["groupIdToDel"];
        $em = $this->getDoctrine()->getManager();
        $rep = $em ->getRepository('TfeForumBundle:Groupe');
        $groupe = $rep->find($groupId);

        $em->remove($groupe);
        $em->flush();
        return $this->redirectToRoute('tfe_forum_homepage');


    }

}
