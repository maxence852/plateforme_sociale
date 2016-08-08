<?php
namespace Tfe\PlatformSocialeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Tfe\PlatformSocialeBundle\Entity\Publication;
use Tfe\PlatformSocialeBundle\Form\Type\PublicationType;
use Nelmio\ApiDocBundle\Annotation\ApiDoc;

class PublicationApiController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Get("/api/publications")
     * @return \Tfe\PlatformSocialeBundle\Entity\Publication[]|static
     * @internal param Request $request
     *
     * @ApiDoc(
     *  resource=true,
     *  description="Récupère toutes les publications",
     *  filters={
     *      {"name"="page", "dataType"="integer", "default"="1"},
     *      {"name"="another-filter", "dataType"="string", "pattern"="(foo|bar) ASC|DESC"}
     *     }
     * )
     *
     */
    public function getPublicationsAction()
    {
        $publication = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfePlatformSocialeBundle:Publication')
            ->findAll();
        /* @var $publication Publication[] */

        if (empty($publication)) {
            return View::create(['message' => 'Publication not found'], Response::HTTP_NOT_FOUND);
        }
        return $publication;


    }

    /**
     * @Rest\View()
     * @Rest\Get("/api/publication/{id}")
     * @param Request $request
     * @return \Tfe\PlatformSocialeBundle\Entity\Publication[]|static
     *
     * @ApiDoc(
     * resource=true,
     * description="Récupère une publication",
     * requirements={
     *      {
     *          "name"="id",
     *          "dataType"="integer",
     *          "requirement"="\d+",
     *          "description"="récupère la publication selon l'id"
     *      }
     *  },
     * )
     */
    public function getPublicationAction(Request $request)
    {
        $publication = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfePlatformSocialeBundle:Publication')
            ->find($request->get('id'));
        /* @var $publication Publication[] */

        if (empty($publication)) {
            return View::create(['message' => 'Publication not found'], Response::HTTP_NOT_FOUND);
        }
        return $publication;


    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/api/publications")
     * @param Request $request
     * @return Publication
     */
    public function postPublicationsAction(Request $request)
    {
        $publication = new Publication();
        $form = $this->createForm(PublicationType::class, $publication);
        $form->submit($request->request->all()); // Validation des données

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($publication);
            $em->flush();
            return $publication;
        }else{
            return $form;
        }

    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/api/publication/{id}")
     * @param Request $request
     */
    public function removePublicationAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $publication = $em->getRepository('TfePlatformSocialeBundle:Publication')
            ->find($request->get('id'));
        /* @var $publication Publication */

        $em->remove($publication);
        $em->flush();
    }




    private function updatePublication(Request $request, $clearMissing)
    {
        $publication = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfePlatformSocialeBundle:Publication')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $publication Publication */

        if (empty($publication)) {
            return View::create(['message' => 'Publication not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(PublicationType::class, $publication);

        // Le paramètre false dit à Symfony de garder les valeurs dans notre
        // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($publication);
            $em->flush();
            return $publication;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View()
     * @Rest\Put("/api/publication/{id}")
     * @param Request $request
     * @return \Symfony\Component\Form\Form|JsonResponse|Publication
     */
    public function updatePublicationAction(Request $request)
    {
        return $this->updatePublication($request, true);
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/api/publication/{id}")
     * @param Request $request
     * @return \Symfony\Component\Form\Form|JsonResponse|Publication
     */
    public function patchPublicationAction(Request $request)
    {
        return $this->updatePublication($request, false);
    }

}
