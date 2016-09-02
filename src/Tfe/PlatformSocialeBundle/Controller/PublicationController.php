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

        $sql = "select titrePublication,contentPublication, user_id, u.id, u.username, 'A' as suiveur from publication as p
	              INNER JOIN tfe_users as u ON u.id = user_id where p.user_id IN (select suiviId from abonnement_user
	                where suiveurId = ". $this->getUser()->getId() .")
                UNION
                select titrePublication,contentPublication, user_id, u.id, u.username, 'B' as suiveur from publication as p
	             INNER JOIN tfe_users as u ON u.id = user_id where p.user_id NOT IN (select suiviId from abonnement_user
	                where suiveurId = ". $this->getUser()->getId() .")
                ORDER BY suiveur ASC";
        $publicationGet = $userManager->getConnection()->prepare($sql);
        $publicationGet->execute();

        //Obliger de faire la boucle sinon la reqûete fct pas et l'affichage est vide.
        $publications = array();
        $i = 0;
        foreach($publicationGet as $pub){
            $publication = new Publication();
            $user = new Users();
            $user->setUsername($pub['username']);
            $publication->setUser($user);
            $publication->setTitrePublication($pub['titrepublication']);
            $publication->setContentPublication($pub['contentpublication']);
            $publications[$i]=$publication;
            $i++;
        }
        //if(sizeof($publicationGet)<1) return $this->redirectToRoute('tfe_platform_sociale_homepage');
        /******************get Publications fin****************/
        $genresGet = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfePlatformSocialeBundle:Genre')
            ->findAll();

        $allGenres = array();
        foreach ($genresGet as $genre){
            $allGenres[$genre->getNameGenre()]=$genre;
        }
        /*******Formulaire titre + publication ***********/
        $publicationPost = new Publication();

        //todo rajouter base de données
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
            ->setAction($this->generateUrl('tfe_platform_sociale_publication_keywords'))
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






            return $this->render('TfePlatformSocialeBundle:Publications:publications.html.twig', array(
                //'publication' => $publicationGet,
                'publication' => $publications,
                'form' => $form->createView(),
                'form2' => $form2->createView(),

            ));

        }
    public function publicationsKeywordsAction(Request $request)
    {
        $keywords = new KeywordSearch();
        $form2 = $this->createFormBuilder($keywords)
            ->setAction($this->generateUrl('tfe_platform_sociale_publication_keywords'))
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
        $publicationGet = array(new Publication());
        if ($request->isMethod('POST')) {
            $form2->handleRequest($request);
            if ($form2->isValid()) {
                $kw = $form2->getData();

                if($kw->getNbKeywords()>0){
                    /******************get Publications****************/
                   // $kwTmp = $kw->getKeywordsArray();
                    //if(sizeof($kwTmp)>1) return $this->redirectToRoute('tfe_forum_homepage', array('id' => 1));
                    $publicationGet = $this->get('doctrine.orm.entity_manager')
                        ->getRepository('TfePlatformSocialeBundle:Publication')
                        ->ResearchKeywords($kw->getKeywordsArray());
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
        return $this->render('TfePlatformSocialeBundle:Publications:publicationKeyword.html.twig', array(
            'publication' => $publicationGet,
            'form2' => $form2->createView(),

        ));
    }



}
