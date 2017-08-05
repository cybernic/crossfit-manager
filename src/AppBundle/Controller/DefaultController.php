<?php

namespace AppBundle\Controller;

use Doctrine\Common\Cache\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="welcome")
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function indexAction(Request $request)
    {
        return $this->redirect(
            $this->generateUrl('fos_user_profile_show')
        );
    }

    /**
     * @Route("/about/{name}")
     */
    public function aboutAction($name)
    {
        /** @var Cache $cache */
        $cache = $this->get('doctrine_cache.providers.my_markdown_cache');
        $key = md5($name);

        if ($cache->contains($key)) {
            $name = $cache->fetch($key);
        } else {
            $cache->save($key, $name . '_cached');
        }

        return $this->render('site/about.html.twig', [
            'name' => $name,
        ]);
    }
}
