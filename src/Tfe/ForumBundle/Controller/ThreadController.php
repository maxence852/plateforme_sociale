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
        return $this->render('TfeForumBundle:Default:thread.html.twig',array(
            'form' =>  $form->createView(),
            'comments'=> $comments,
            'thread' => $thread
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
            if($comment->getId()==$idComment && $comment->getAuthor()==$this->getUser()) {
                $thread->removeComment($comment);

                $em->flush();
            }
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



}
