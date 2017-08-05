<?php

namespace MyThemeBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('MyThemeBundle:Default:index.html.twig');
    }
}
