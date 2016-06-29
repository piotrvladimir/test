<?php
namespace GalleryBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GalleryBundle\Entity\Album;
use GalleryBundle\Entity\Image;

class LoadUserData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $albumList = array('Hello album' => array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg'),
            'Work album' => array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg', '1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg', '1.jpg', '2.jpg', '3.jpg', '4.jpg', '6.jpg'),
            'Rest album' => array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg', '1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg', '1.jpg', '2.jpg', '3.jpg', '4.jpg', '7.jpg'),
            'Cover album' => array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg', '1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg', '1.jpg', '2.jpg', '3.jpg', '4.jpg', '8.jpg'),
            'Image album' => array('1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg', '1.jpg', '2.jpg', '3.jpg', '4.jpg', '5.jpg', '6.jpg', '7.jpg', '8.jpg', '9.jpg', '10.jpg', '1.jpg', '2.jpg', '3.jpg', '4.jpg', '9.jpg'));
        foreach($albumList as $name => $imageList)
        {
            $album = new Album();
            $album->setName($name);
            foreach($imageList as $key => $image)
            {
                $img = new Image();
                $img->setName($key);
                $img->setUrl($image);
                $manager->persist($img);
                $manager->flush();
                $album->addImage($img);
            }
            $album->setCover($img->getId());
            $manager->persist($album);
            $manager->flush();
        }
    }
}