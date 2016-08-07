<?php
namespace Tfe\RestBundle\Controller;
/***********Problème avec la création de groupe via le serializer voir favoris tuto rest symfony**********/
use FOS\RestBundle\View\View;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;
use Tfe\RestBundle\Entity\Utilisateur;
use Tfe\RestBundle\Form\Type\UserType;

class UtilisateurController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Get("/users")
     * @param Request $request
     * @return JsonResponse
     */
    public function getUsersAction(Request $request)
    {
        $users = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfeRestBundle:Utilisateur')
            ->findAll();
        /* @var $users utilisateur[] */

        if (empty($users)) {
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return $users;
    }


    /**
     * @Rest\View()
     * @Rest\Get("/users/{user_id}")
     * @param Request $request
     * @return JsonResponse|\Tfe\RestBundle\Entity\Utilisateur[]
     */
    public function getUserAction(Request $request)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfeRestBundle:Utilisateur')
            ->find($request->get('user_id'));
        /* @var $user utilisateur[] */

        if (empty($user)) {
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return $user;
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_CREATED)
     * @Rest\Post("/users")
     * @param Request $request
     * @return \Symfony\Component\Form\Form|Utilisateur
     */
    public function postUsersAction(Request $request)
    {
        $user = new Utilisateur();
        $form = $this->createForm(UserType::class, $user);

        $form->submit($request->request->all());

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View(statusCode=Response::HTTP_NO_CONTENT)
     * @Rest\Delete("/users/{id}")
     * @param Request $request
     */
    public function removeUserAction(Request $request)
    {
        $em = $this->get('doctrine.orm.entity_manager');
        $user = $em->getRepository('TfeRestBundle:Utilisateur')
            ->find($request->get('id'));
        /* @var $user Utilisateur */

        if ($user) {
            $em->remove($user);
            $em->flush();
        }
    }


    private function updateUser(Request $request, $clearMissing)
    {
        $user = $this->get('doctrine.orm.entity_manager')
            ->getRepository('TfeRestBundle:Utilisateur')
            ->find($request->get('id')); // L'identifiant en tant que paramètre n'est plus nécessaire
        /* @var $user Utilisateur */

        if (empty($user)) {
            return View::create(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        $form = $this->createForm(UserType::class, $user);

        $form->submit($request->request->all(), $clearMissing);

        if ($form->isValid()) {
            $em = $this->get('doctrine.orm.entity_manager');
            $em->persist($user);
            $em->flush();
            return $user;
        } else {
            return $form;
        }
    }

    /**
     * @Rest\View()
     * @Rest\Patch("/users/{id}")
     * @param Request $request
     * @return \Symfony\Component\Form\Form|JsonResponse|Utilisateur
     */
    public function patchUserAction(Request $request)
    {
        return $this->updateUser($request, false);
    }

    /**
     * @Rest\View()
     * @Rest\Put("/users/{id}")
     * @param Request $request
     * @return \Symfony\Component\Form\Form|JsonResponse|Utilisateur
     */
    public function updateUserAction(Request $request)
    {
        return $this->updateUser($request, true);
    }
}