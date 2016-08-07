<?php
namespace Tfe\RestBundle\Controller;
/***********Problème avec la création de groupe via le serializer voir favoris tuto rest symfony**********/
use FOS\RestBundle\View\View;
use FOS\RestBundle\View\ViewHandler;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Tfe\RestBundle\Entity\Place;
use Tfe\RestBundle\Form\Type\PlaceType;

class PlaceController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Get("/places")
     * @param Request $request
     * @return static
     */
    public function getPlacesAction(Request $request)
    {
        $places = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfeRestBundle:Place')
            ->findAll();
        /* @var $places Place[] */

        if (empty($places)) {
            return View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }
        return $places;

    }

    /**
     * @Rest\View()
     * @Rest\Get("/place/{id}")
     * @param Request $request
     * @return bool|JsonResponse|Place
     */
    public function getPlaceAction(Request $request)
    {

        $place = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfeRestBundle:Place')
            ->find($request->get('id')); // L'identifiant en tant que paramétre n'est plus nécessaire
        /* @var $place Place */

        if (empty($place)) {
            return View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        return $place;
    }


    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/places")
     * @param Request $request
     * @return Place
     */
    public function postPlacesAction(Request $request)
    {
        $place = new Place();
        $form = $this->createForm(PlaceType::class, $place);
        $form->submit($request->request->all()); // Validation des données

        if($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($place);
            $em->flush();
            return $place;
        }else{
            return $form;
        }

    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/places/{id}")
     * @param Request $request
     */
    public function removePlaceAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $place = $em->getRepository('TfeRestBundle:Place')
            ->find($request->get('id'));
        /* @var $place Place */

        if (!$place) {
            return;
        }

        foreach ($place->getPrices() as $price) {
            $em->remove($price);
        }
        $em->remove($place);
        $em->flush();
    }


    private function updatePlace(Request $request, $clearMissing)
    {
        $place = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfeRestBundle:Place')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $place Place */

        if (empty($place)) {
            return View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(PlaceType::class, $place);

        // Le paramètre false dit à Symfony de garder les valeurs dans notre
        // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($place);
            $em->flush();
            return $place;
        } else {
            return $form;
        }
    }
    /**
     * @Rest\View()
     * @Rest\Put("/places/{id}")
     * @param Request $request
     * @return \Symfony\Component\Form\Form|JsonResponse|Place
     */
    public function updatePlaceAction(Request $request)
    {
        return $this->updatePlace($request, true);
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/places/{id}")
     * @param Request $request
     * @return \Symfony\Component\Form\Form|JsonResponse|Place
     */
    public function patchPlaceAction(Request $request)
    {
        return $this->updatePlace($request, false);
    }






}