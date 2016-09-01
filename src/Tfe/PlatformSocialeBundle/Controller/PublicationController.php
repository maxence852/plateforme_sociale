<?php
namespace Tfe\PlatformSocialeBundle\Controller;

use Proxies\__CG__\Tfe\UserBundle\Entity\Users;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Tfe\PlatformSocialeBundle\Entity\Publication;


class PublicationController extends Controller
{

    public function PublicationsAction(Request $request)
    {
        /******************get Publications****************/

        $publicationGet = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfePlatformSocialeBundle:Publication')
            ->findAll();
        /******************get Publications fin****************/


        /**********post publication************************/

        $publicationPost = new Publication();
        $form = $this->get('form.factory')->createBuilder(FormType::class, $publicationPost)
            ->add('titrePublication', TextType::class, array(
                'required'    => true))
            ->add('contentPublication', TextareaType::class, array(
                'required'    => true))
            ->add('save',      SubmitType::class)
            ->getForm()
        ;

        if ($request->isMethod('POST')) {
            $form->handleRequest($request);
            if ($form->isValid()) {

                $em = $this->getDoctrine()->getManager();
                $em->persist($publicationPost);
                $em->flush();
                $request->getSession()->getFlashBag()->add('notice', 'title bien enregistrée.');
                return $this->redirectToRoute('tfe_platform_sociale_publication');
            }
        }
        /********************post publication fin******************************/





            return $this->render('TfePlatformSocialeBundle:Publications:publications.html.twig', array(
                'publication' => $publicationGet,
                'form' => $form->createView(),

            ));

        }



}
