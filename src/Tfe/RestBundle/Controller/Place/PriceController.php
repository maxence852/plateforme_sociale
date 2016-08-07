<?php
namespace Tfe\RestBundle\Controller\Place;


/***********Problème avec la création de groupe via le serializer voir favoris tuto rest symfony**********/
use FOS\RestBundle\View\View;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Tfe\RestBundle\Entity\Place;
use Tfe\RestBundle\Entity\Price;
use Tfe\RestBundle\Form\Type\PriceType; // alias pour toutes les annotations

class PriceController extends Controller
{

    /**
     * @Rest\Get("/places/{id}/prices")
     * @Rest\View()
     * @param Request $request
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPricesAction(Request $request)
    {
        $place = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfeRestBundle:Place')
            ->find($request->get('id')); // L'identifiant en tant que paramétre n'est plus nécessaire
        /* @var $place Place */

        if (empty($place)) {
            return $this->placeNotFound();
        }
        return $place->getPrices();
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/places/{id}/prices")
     * @param Request $request
     * @return \Symfony\Component\Form\Form|Price
     */
    public function postPricesAction(Request $request)
    {
        $place = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfeRestBundle:Place')
            ->find($request->get('id'));
        /* @var $place Place */

        if (empty($place)) {
            return $this->placeNotFound();
        }

        $price = new Price();
        $price->setPlace($place); // Ici, le lieu est associé au prix
        $form = $this->createForm(PriceType::class, $price);

        // Le paramétre false dit à Symfony de garder les valeurs dans notre
        // entité si l'utilisateur n'en fournit pas une dans sa requête
        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($price);
            $em->flush();
            return $price;
        } else {
            return $form;
        }
    }
    private function placeNotFound()
    {
        return View::create(['message' => 'Place not found'], Response::HTTP_NOT_FOUND);
    }

}