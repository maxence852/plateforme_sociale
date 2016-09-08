<?php

namespace Tfe\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Tfe\ForumBundle\Entity\Category;
use Tfe\ForumBundle\Entity\Comment;
use Tfe\ForumBundle\Entity\Thread;

class ThreadController extends Controller
{
    public function indexAction($id, Request $request)
    {
        $commentPost = new Comment();
        $form = $this->get('form.factory')->createBuilder(FormType::class, $commentPost)
            ->add('body', TextareaType::class, array(
                'required'    => true))
            ->add('save',      SubmitType::class)
            ->getForm()
        ;
        $thread = new Thread();
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('TfeForumBundle:Thread');
        $thread = $repo->find($id);
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $commentPost->setAuthor($this->getUser());
                $commentPost->setCreatedAt(new \DateTime());
                $commentPost->setThread($thread);
                $em = $this->getDoctrine()->getManager();
                $em->persist($commentPost);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'commentaire bien enregistrée.');
            }
        }


        $comments = $this->getDoctrine()
            ->getManager()
            ->getRepository('TfeForumBundle:Comment')
            ->myFindAllComments($thread);

        $paginator  = $this->get('knp_paginator');
        $comments = $paginator->paginate(
            $comments,
            $request->query->getInt('page', 1),
            3 /*limit per page*/
        );
        return $this->render('TfeForumBundle:Default:thread.html.twig',array(
            'form' =>  $form->createView(),
            'comments'=> $comments,
            'thread' => $thread,
            'paginator' => $paginator
        ));

    }

    public function deleteCommentAction($idComment, $idThread, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        //$rep = $em->getRepository('TfeForumBundle:Comment');
        //$comment = $rep->find($idComment);
        $rep = $em ->getRepository('TfeForumBundle:Thread');
        $thread = $rep->find($idThread);
        foreach ($thread->getComment() as $comment) {
            if(($comment->getId()==$idComment && $comment->getAuthor()==$this->getUser()) || ($this->getUser() == $this->isGranted('ROLE_SUPER_ADMIN')))
                {
                $thread->removeComment($comment);

                $em->flush();
            }
            return $this->indexAction($idThread,$request);
        }
        return $this->indexAction($idThread,$request);

    }
    public function deleteThreadAction($idThread, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $rep = $em ->getRepository('TfeForumBundle:Thread');
        $thread = $rep->find($idThread);
        $idCat = $thread->getCategory()->getId();
        $em->remove($thread);
        $em->flush();
        return $this->redirectToRoute('tfe_forum_category',array(
            'id'=> $idCat
        ));


    }

    public function updateCommentAction($id,$idThread, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
       // $rep = $em ->getRepository('TfeForumBundle:Thread');
        //$thread = $rep->find($idThread);
        $repo = $em->getRepository('TfeForumBundle:Comment');
        $comment = $repo->find($id);
        $form = $this->get('form.factory')->createBuilder(FormType::class, $comment)
            ->setAction($this->generateUrl('tfe_update_comment',array('id' => $id, 'idThread' => $idThread)))
            ->setMethod('POST')
            ->add('body', TextareaType::class, array(
                'required'    => true))
            ->add('save',      SubmitType::class)
            ->getForm()
        ;
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'commentaire bien enregistrée.');
                return $this->redirectToRoute('tfe_forum_thread',array(
                    'id' => $idThread
                ));
            }
        }
        return $this->render('TfeForumBundle:Default:ThreadEditComment.html.twig', array(
            'form' => $form->createView(),
            'idThread' => $idThread

        ));

    }

    public function addPointUserAction($id,$idThread)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('TfeUserBundle:Users');
        $user = $repo->find($id);
        $user->setUserPoint($user->getUserPoint()+1);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('tfe_forum_thread',array(
            'id' => $idThread
        ));

    }

}
