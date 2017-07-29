<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class SiteController extends Controller
{
    /**
     * @Route("/about/{name}")
     */
    public function aboutAction($name)
    {
        return $this->render('site/about.html.twig', [
            'name' => $name,
        ]);
    }
}
