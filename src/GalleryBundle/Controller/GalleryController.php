<?php

namespace GalleryBundle\Controller;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class GalleryController extends Controller
{
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction()
    {
        return $this->render('GalleryBundle:Main:page.html.twig', array('images' => false));
    }

    /**
     * @return JsonResponse
     */
    public function getAlbumListAction()
    {
        $almubMass = $this->getDoctrine()->getRepository('GalleryBundle:Album')->getAlbumForMainPage(10);
        return new JsonResponse($almubMass);
    }

    /**
     * @param $id
     * @param int $page 
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getAlbumDetailsAction($id, $page=1)
    {
        $album = $this->getDoctrine()->getRepository('GalleryBundle:Album')->findOneById($id);
        if (!$album) {
            throw new NotFoundHttpException("Album not found");
        }
        $emptyImages = count($album->getImages()) > 0 ? false : true;

        $paginator  = $this->get('knp_paginator');
        $pagination = $paginator->paginate($album->getImages(), $this->get('request')->query->get('page', $page), 10);

        return $this->render('GalleryBundle:Main:page.html.twig', array(
            'title' => $album->getName(),
            'images' => $pagination,
            'emptyImages' => $emptyImages
        ));
    }
}
