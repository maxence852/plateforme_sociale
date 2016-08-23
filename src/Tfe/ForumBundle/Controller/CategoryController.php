<?php

namespace Tfe\ForumBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class CategoryController extends Controller
{
    public function indexAction($id)
    {

        return $this->render('TfeForumBundle:Default:category.html.twig');

    }


}
