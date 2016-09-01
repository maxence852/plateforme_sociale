<?php

namespace Tfe\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\DateTime;
use Tfe\ForumBundle\Entity\Category;
use Tfe\ForumBundle\Entity\Thread;

class CategoryController extends Controller
{
    public function indexAction($id)
    {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('TfeForumBundle:Category');
        $category = $repo->find($id);

        $thread = new Thread();

        $form = $this->get('form.factory')->createBuilder(FormType::class, $thread)
            ->setAction($this->generateUrl('tfe_add_thread'))
            ->setMethod('POST')
            ->add('title', TextType::class, array(
                'required'    => false))
            ->add('body', TextareaType::class, array(
                'required' => true))
            ->add('save',      SubmitType::class)
            ->getForm()
        ;
        $threads = $this->getDoctrine()
            ->getManager()
            ->getRepository('TfeForumBundle:Thread')
            ->myFindAllThread($category);
        return $this->render('TfeForumBundle:Default:category.html.twig',array(
            'category'=> $category,
            'form'=> $form->createView(),
            'threads'=> $threads
        ));

    }

    public function addThreadAction(Request $request)
    {

        /********** Enregistrement d'une nouvelle Categorie ds le forum ********************/
        $categoryId = $_POST["categoryId"];


        $thread = new Thread();
        $form = $this->get('form.factory')->createBuilder(FormType::class, $thread)
            ->add('title', TextType::class, array(
                'required'    => true))
            ->add('body', TextareaType::class, array(
                'required' => true))
            ->add('save',      SubmitType::class)
            ->getForm()
        ;
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $thread->setCreatedAt(new \DateTime());
                $thread->setAuthor($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $repo = $em->getRepository('TfeForumBundle:Category');
                $cat = $repo->find($categoryId);
                $cat->addThread($thread);

                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'thread bien enregistrée.');

            }
        }
        return $this->indexAction($categoryId);
    }

    public function deleteCategoryAction($categoryId, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rep = $em ->getRepository('TfeForumBundle:Category');
        $category = $rep->find($categoryId);
        $idGroup = $category->getGroupe()->getId();
        $em->remove($category);
        $em->flush();
        return $this->redirectToRoute('tfe_forum_homepage',array(
            'id'=> $idGroup
        ));


    }


}
