<?php

namespace GalleryBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

class GalleryController extends Controller
{
    public function indexAction()
    {
        return $this->render('GalleryBundle:Main:page.html.twig');
    }

    public function getAlbumListAction()
    {
        $almubMass = $this->getDoctrine()->getRepository('GalleryBundle:Album')->getAlbumForMainPage();
        return new JsonResponse($almubMass);
    }

    public function getAlbumDetailsAction()
    {

    }
}
