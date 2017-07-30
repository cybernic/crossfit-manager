<?php

namespace AppBundle\Controller;

use Doctrine\Bundle\DoctrineCacheBundle\DoctrineCacheBundle;
use Doctrine\Common\Cache\Cache;
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
