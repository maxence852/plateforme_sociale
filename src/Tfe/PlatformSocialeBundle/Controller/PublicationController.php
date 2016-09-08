<?php
namespace Tfe\PlatformSocialeBundle\Controller;

use Proxies\__CG__\Tfe\UserBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Tests\Extension\Core\Type\CheckboxTypeTest;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Constraints\Choice;
use Tfe\ForumBundle\Entity\Comment;
use Tfe\PlatformSocialeBundle\Entity\CommentPublication;
use Tfe\PlatformSocialeBundle\Entity\Genre;
use Tfe\PlatformSocialeBundle\Entity\Publication;


class PublicationController extends Controller
{

    public function PublicationsAction(Request $request)
    {
        /******************get Publications****************/

       // $publicationGet = $this->get('doctrine.orm.entity_manager')
           // ->getRepository('TfePlatformSocialeBundle:Publication')
            //->findAll();
          //  ->getAllOrderedPublications($this->getDoctrine()->getManager());
         $userManager     = $this->getDoctrine()->getManager();

        $sql = "select p.id, titrePublication,contentPublication, user_id, u.id AS user_Id, u.username, 'A' as suiveur from publication as p
	              INNER JOIN tfe_users as u ON u.id = user_id where p.user_id IN (select suiviId from abonnement_user
	                where suiveurId = ". $this->getUser()->getId() .")
                UNION
                select p.id, titrePublication,contentPublication, user_id, u.id AS userId, u.username, 'B' as suiveur from publication as p
	             INNER JOIN tfe_users as u ON u.id = user_id where p.user_id NOT IN (select suiviId from abonnement_user
	                where suiveurId = ". $this->getUser()->getId() .")
                ORDER BY suiveur, username, titrePublication ASC";
        $publicationGet = $userManager->getConnection()->prepare($sql);
        $publicationGet->execute();

        //Obliger de faire la boucle sinon la reqûete fct pas et l'affichage est vide.
        //Obliger de faire la boucle sinon la reqûete fct pas et l'affichage est vide.
        $publications = array();
        $i = 0;
        foreach($publicationGet as $pub){
            $publication = new Publication();
            $comments = $this->get('doctrine.orm.entity_manager')
                ->getRepository('TfePlatformSocialeBundle:CommentPublication')
                ->getCommentsFromPublication($pub['id']);
            foreach($comments as $comment)
            {
                $publication->addComment($comment);
            }
            $user = new Users();
            $user->setUsername($pub['username']);
            $user->setId($pub['user_id']);
            $publication->setId($pub['id']);
            $publication->setUser($user);
            $publication->setTitrePublication($pub['titrepublication']);
            $publication->setContentPublication($pub['contentpublication']);
            $publications[$i]=$publication;
            $i++;
        }
        //if(sizeof($publicationGet)<1) return $this->redirectToRoute('tfe_platform_sociale_homepage');
        /******************get Publications fin****************/

        /**************Genre littéraire ************************/
        $genresGet = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfePlatformSocialeBundle:Genre')
            ->findAll();

        $allGenres = array();
        foreach ($genresGet as $genre){
            $allGenres[$genre->getNameGenre()]=$genre;
        }


        /*******Formulaire titre + publication ***********/
        $publicationPost = new Publication();
        $form = $this->get('form.factory')->createBuilder(FormType::class, $publicationPost)
            ->add('titrePublication', TextType::class, array(
                'required'    => true))
            ->add('motsCles',TextType::class,array(
                'required' =>false))
            ->add('genres', ChoiceType::class, array(
                'choices' => $allGenres
                ,
                /*'group_by' => function($genre) {
                    if ($genre == "Science-fiction") {
                        return 'Roman';
                    } else {
                        return 'Autre';
                    }
                },*/
                'required'    => false,
                'placeholder' => '',
                'expanded'=> true,
                'multiple'=> true,
                'empty_data'  => null,

            ))
            ->add('contentPublication', TextareaType::class, array(
                'required'    => true))
            ->add('save',      SubmitType::class)
            ->getForm()
        ;

        $keywords = new KeywordSearch();
        $form2 = $this->createFormBuilder($keywords)
            ->setAction($this->generateUrl('tfe_platform_sociale_publication_keywords',array('kw' => '99')))
            ->setMethod('POST')
            ->add('keywords', TextType::class, array(
                'required'    => false,
                'attr'  => array(
                    'placeholder'=> 'mots clés',
                )))
            ->add('RechercheKeywors',SubmitType::class, array(
                'label'=> 'Rechercher'
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form2->handleRequest($request);
            if ($form2->isValid()) {
                $kw = $form2->getData();
                if($kw->getNbKeywords()>0){
                    /******************get Publications****************/

                    $publicationGet = $this->get('doctrine.orm.entity_manager')
                        ->getRepository('TfePlatformSocialeBundle:Publication')
                        ->findAll();
                    /******************get Publications fin****************/
                }
                /*
                $repository = $this
                    ->getDoctrine()
                    ->getManager()
                    ->getRepository('TfeUserBundle:Users')
                ;
                */

            }
        }

        /**********post publication************************/
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $publicationPost->setUser($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($publicationPost);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'title bien enregistrée.');
                return $this->redirectToRoute('tfe_platform_sociale_publication');
            }
        }


//        $pubicationId = $_POST["publicationId"];
        $comment = new CommentPublication();
        $form3 = $this->createFormBuilder($comment)
            ->setAction($this->generateUrl('tfe_platform_sociale_publication_addComment'))
            ->setMethod('POST')
            ->add('content', TextType::class, array(
                'required'    => false,))
            ->add('Commenter',SubmitType::class, array(
                'label'=> 'Envoyer'
            ))
            ->getForm();
/*
        if ($request->isMethod('POST')) {
            $form3->handleRequest($request);
            if ($form3->isValid()) {
                $comment->setUser($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $repo = $em->getRepository('TfePlatformSocialeBundle:Publication');
                $pub = $repo->find($pubicationId);
                $pub->addComment($comment);
                $em->persist($comment);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'commentaire bien enregistrée.');
                return $this->redirectToRoute('tfe_platform_sociale_publication');
            }
        }

*/      $publication = new Publication();
        $form4 = $this->createFormBuilder($publication)
            ->setAction($this->generateUrl('tfe_platform_sociale_delete_publication'))
            ->setMethod('POST')
            ->add('Supprimer',SubmitType::class, array(
                'label'=> 'Envoyer'
            ))
            ->getForm();

        $paginator  = $this->get('knp_paginator');
        $publications = $paginator->paginate(
            $publications,
            $request->query->getInt('page', 1),
            10/*limit per page*/
        );

            return $this->render('TfePlatformSocialeBundle:Publications:publications.html.twig', array(
                //'publication' => $publicationGet,
                'publication' => $publications,
                'form' => $form->createView(),
                'form2' => $form2->createView(),
                'form3' => $form3->createView(),
                'form4' => $form4->createView(),
                'paginator' => $paginator

            ));

        }




    public function publicationsKeywordsAction(Request $request, $kw)
    {
        if($kw=='99') $kw='';
        $keywords = new KeywordSearch();
        $form2 = $this->createFormBuilder($keywords)
            ->setAction($this->generateUrl('tfe_platform_sociale_publication_keywords',array('kw' => '99')))
        //{{ path('tfe_delete_comment', {'idComment': comment.id ,'idThread' :  thread.id}) }}
            ->setMethod('POST')
            ->add('keywords', TextType::class, array(
                'required'    => true,
                'attr'  => array(
                    'placeholder'=> 'mots clés',
                    'value'=>$kw,
                )))
            ->add('RechercheKeywors',SubmitType::class, array(
                'label'=> 'Rechercher'
            ))
            ->getForm();



        $kwd = new KeywordSearch();
        $publications = array();
        if($kw!=''){
            $kwd->setKeywords($kw);
            if($kwd->getNbKeywords()>0){
                /******************get Publications****************/
                // $kwTmp = $kw->getKeywordsArray();
                //if(sizeof($kwTmp)>1) return $this->redirectToRoute('tfe_forum_homepage', array('id' => 1));
                $keywords = $kwd->getKeywordsArray();
                $userManager     = $this->getDoctrine()->getManager();
                //todo incorporation de la requête fct pas
                $sql = "select p.id, titrePublication,contentPublication, user_id, u.id as userId, u.username, 'A' as suiveur from publication as p
	              INNER JOIN tfe_users as u ON u.id = user_id where p.user_id IN (select suiviId from abonnement_user
	                where suiveurId = ". $this->getUser()->getId() .") AND motscles LIKE '%".$keywords[0]."%'";
                for($i=1; $i<sizeof($keywords); $i++){
                    $sql.= " OR motscles LIKE '%".$keywords[$i]."%' ";
                }
                $sql .="
                UNION
                select p.id, titrePublication,contentPublication, user_id, u.id, u.username, 'B' as suiveur from publication as p
	             INNER JOIN tfe_users as u ON u.id = user_id where p.user_id NOT IN (select suiviId from abonnement_user
	                where suiveurId = ". $this->getUser()->getId()  .") AND motscles LIKE '%".$keywords[0]."%'";
                for($i=1; $i<sizeof($keywords); $i++){
                    $sql.= " OR motscles LIKE '%".$keywords[$i]."%' ";
                }
                $sql .="
                ORDER BY suiveur, username, titrePublication  ASC";
                $publicationGet = $userManager->getConnection()->prepare($sql);
                $publicationGet->execute();

                //Obliger de faire la boucle sinon la reqûete fct pas et l'affichage est vide.
                $i = 0;
                foreach($publicationGet as $pub){
                    $publication = new Publication();
                    $comments = $this->get('doctrine.orm.entity_manager')
                        ->getRepository('TfePlatformSocialeBundle:CommentPublication')
                        ->getCommentsFromPublication($pub['id']);
                    foreach($comments as $comment)
                    {
                        $publication->addComment($comment);
                    }
                    $user = new Users();
                    $user->setUsername($pub['username']);
                    $publication->setId($pub['id']);
                    $publication->setUser($user);
                    $publication->setTitrePublication($pub['titrepublication']);
                    $publication->setContentPublication($pub['contentpublication']);
                    $publications[$i]=$publication;
                    $i++;
                }

                /******************get Publications fin****************/

            }
        }else {
            if ($request->isMethod('POST')) {
                $form2->handleRequest($request);
                if ($form2->isValid()) {
                    $kwd = $form2->getData();
                    //if($kw!='') $kwd->setKeywords($kw);

                    if ($kwd->getNbKeywords() > 0) {
                        /******************get Publications****************/
                        // $kwTmp = $kw->getKeywordsArray();
                        //if(sizeof($kwTmp)>1) return $this->redirectToRoute('tfe_forum_homepage', array('id' => 1));
                        $keywords = $kwd->getKeywordsArray();
                        $userManager = $this->getDoctrine()->getManager();
                        //todo incorporation de la requête fct pas
                        $sql = "select p.id, titrePublication,contentPublication, user_id, u.id as userId, u.username, 'A' as suiveur from publication as p
	              INNER JOIN tfe_users as u ON u.id = user_id where p.user_id IN (select suiviId from abonnement_user
	                where suiveurId = " . $this->getUser()->getId() . ") AND motscles LIKE '%" . $keywords[0] . "%'";
                        for ($i = 1; $i < sizeof($keywords); $i++) {
                            $sql .= " OR motscles LIKE '%" . $keywords[$i] . "%' ";
                        }
                        $sql .= "
                UNION
                select p.id, titrePublication,contentPublication, user_id, u.id, u.username, 'B' as suiveur from publication as p
	             INNER JOIN tfe_users as u ON u.id = user_id where p.user_id NOT IN (select suiviId from abonnement_user
	                where suiveurId = " . $this->getUser()->getId() . ") AND motscles LIKE '%" . $keywords[0] . "%'";
                        for ($i = 1; $i < sizeof($keywords); $i++) {
                            $sql .= " OR motscles LIKE '%" . $keywords[$i] . "%' ";
                        }
                        $sql .= "
                ORDER BY suiveur, username, titrePublication  ASC";
                        $publicationGet = $userManager->getConnection()->prepare($sql);
                        $publicationGet->execute();

                        //Obliger de faire la boucle sinon la reqûete fct pas et l'affichage est vide.
                        $i = 0;
                        foreach ($publicationGet as $pub) {
                            $publication = new Publication();
                            $comments = $this->get('doctrine.orm.entity_manager')
                                ->getRepository('TfePlatformSocialeBundle:CommentPublication')
                                ->getCommentsFromPublication($pub['id']);
                            foreach ($comments as $comment) {
                                $publication->addComment($comment);
                            }
                            $user = new Users();
                            $user->setUsername($pub['username']);
                            $publication->setId($pub['id']);
                            $publication->setUser($user);
                            $publication->setTitrePublication($pub['titrepublication']);
                            $publication->setContentPublication($pub['contentpublication']);
                            $publications[$i] = $publication;
                            $i++;
                        }

                        /******************get Publications fin****************/

                    }

                }
            }
        }
        $comment = new CommentPublication();
        $form3 = $this->createFormBuilder($comment)
            ->setAction($this->generateUrl('tfe_platform_sociale_publication_addComment'))
            ->setMethod('POST')
            ->add('content', TextType::class, array(
                'required'    => false,))
            ->add('Commenter',SubmitType::class, array(
                'label'=> 'Envoyer'
            ))
            ->getForm();


        //Obliger de faire la boucle sinon la reqûete fct pas et l'affichage est vide.



        return $this->render('TfePlatformSocialeBundle:Publications:publicationKeyword.html.twig', array(
            'publication' => $publications,
            'kwd' => $kwd,
            'form2' => $form2->createView(),
            'form3' => $form3->createView(),


        ));
    }


    public function PublicationAddCommentAction(Request $request)
    {
        $userManager = $this->getDoctrine()->getManager();
        $comment = new CommentPublication();
        $form3 = $this->createFormBuilder($comment)
            ->setAction($this->generateUrl('tfe_platform_sociale_publication_addComment'))
            ->setMethod('POST')
            ->add('content', TextType::class, array(
                'required' => false,))
            ->add('Commenter', SubmitType::class, array(
                'label' => 'Envoyer'
            ))
            ->getForm();

        if ($request->isMethod('POST')) {
            $form3->handleRequest($request);
            if ($form3->isValid()) {
                $pubicationId = $_POST["publicationId"];
                $comment->setUser($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $repo = $em->getRepository('TfePlatformSocialeBundle:Publication');
                $pub = $repo->find($pubicationId);
                $comment->setPublication($pub);
                $pub->addComment($comment);
                $em->persist($comment);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'commentaire bien enregistrée.');
                $route = $_POST["route"];
                if ($route == '1') {//add comment on all publication
                    return $this->PublicationsAction($request);
                }
                return $this->publicationsKeywordsAction($request, $_POST["kw"]);
            }
        }

        return $this->render('TfePlatformSocialeBundle:Publications:publications.html.twig', array(
            //'publication' => $publicationGet,

        ));
    }

    public function updatePublicationAction($id, Request $request)
    {
        /**************Genre littéraire ************************/
        $genresGet = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfePlatformSocialeBundle:Genre')
            ->findAll();

        $allGenres = array();
        foreach ($genresGet as $genre){
            $allGenres[$genre->getNameGenre()]=$genre;
        }

        $publicationPost = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfePlatformSocialeBundle:Publication')
            ->find($id);
        //$publicationPost = new Publication();
        $form = $this->get('form.factory')->createBuilder(FormType::class, $publicationPost)
            ->add('titrePublication', TextType::class, array(
                'required'    => true))
            ->add('motsCles',TextType::class,array(
                'required' =>false))

            ->add('contentPublication', TextareaType::class, array(
                'required'    => true))
            ->add('save',      SubmitType::class)
            ->getForm()
        ;

        /**********post publication************************/
        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {
                $publicationPost->setUser($this->getUser());
                $em = $this->getDoctrine()->getManager();
                $em->persist($publicationPost);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'title bien enregistrée.');
                return $this->redirectToRoute('tfe_platform_sociale_publication');
            }
        }

        return $this->render('TfePlatformSocialeBundle:Publications:publicationEdit.html.twig', array(
            //'publication' => $publicationGet,
            'publication' => $publicationPost,
            'form' => $form->createView(),
        ));
    }

    public function deletePublicationAction(Request $request)
    {
        $publication = new Publication();
        $form4 = $this->createFormBuilder($publication)
        ->setAction($this->generateUrl('tfe_platform_sociale_delete_publication'))
        ->setMethod('POST')
        ->add('Supprimer',SubmitType::class, array(
            'label'=> 'Envoyer'
        ))
        ->getForm();
        if ($request->isMethod('POST')) {
            $form4->handleRequest($request);
            if ($form4->isValid()) {
                $pubicationId = $_POST["idPub"];
                $em = $this->getDoctrine()->getManager();
                $repo = $em->getRepository('TfePlatformSocialeBundle:Publication');
                $pub = $repo->find($pubicationId);
                $em->remove($pub);
                $em->flush();

            }
        }
        return $this->redirectToRoute('tfe_platform_sociale_publication');
    }

    public function PublicationUpdateCommentAction($id, Request $request)
    {

        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('TfePlatformSocialeBundle:CommentPublication');
        $comment = $repo->find($id);
        $form3 = $this->createFormBuilder($comment)
            ->setAction($this->generateUrl('tfe_platform_sociale_publication_updateComment',array('id' => $id)))
            ->setMethod('POST')
            ->add('content', TextType::class, array(
                'required'    => false,))
            ->add('Commenter',SubmitType::class, array(
                'label'=> 'Envoyer'
            ))
            ->getForm();
        if ($request->isMethod('POST')) {
            $form3->handleRequest($request);
            if ($form3->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($comment);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'commentaire bien enregistrée.');
                return $this->redirectToRoute('tfe_platform_sociale_publication');
            }
        }


        return $this->render('TfePlatformSocialeBundle:Publications:commentEdit.html.twig', array(
            'form3' => $form3->createView(),

        ));
    }

    public function PublicationDeleteCommentAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('TfePlatformSocialeBundle:CommentPublication');
        $comment = $repo->find($id);
        $em->remove($comment);
        $em->flush();


        return $this->redirectToRoute('tfe_platform_sociale_publication');
    }
    public function PointAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $repo = $em->getRepository('TfeUserBundle:Users');
        $user = $repo->find($id);
        $user->setUserPoint($user->getUserPoint()+1);
        $em->persist($user);
        $em->flush();
        return $this->redirectToRoute('tfe_platform_sociale_publication');
    }

}
