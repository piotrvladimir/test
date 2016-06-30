<?php

namespace GalleryBundle\Entity;

class AlbumRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get albums data for main page
     * @param $max - maximum images for small album
     * @return array - with two keys 'small' and 'big'
     */
    public function getAlbumForMainPage($max = 10)
    {
        $em = $this->getEntityManager();
        $connection = $em->getConnection();

        /**
         * Select album's ids where count of images less than $max
         */
        $sql = "SELECT album_id
                FROM album_image
                GROUP BY album_id
                HAVING COUNT(image_id) < :max";
        $statement = $connection->prepare($sql);
        $statement->bindParam('max', $max);
        $statement->execute();
        $almubIdsMass = $statement->fetchAll();

        /**
         * Converting album's ids array to string for SQL IN statement
         */
        $albumIdsString = '(';
        foreach($almubIdsMass as $album)
        {
            $albumIdsString .= $album['album_id'].',';
        }
        $albumIdsString = trim($albumIdsString, ',').')';

        /**
         * Select album's data where count of images less than $max
         * @var $smallAlbums array() - of Object[id, name, cover, url, title]
         * Result consist each album's image
         */
        $sql = "SELECT a.*, i.url, i.name as title
                FROM album a 
                INNER JOIN album_image ai ON (a.id = ai.album_id AND a.id IN ".$albumIdsString.")
                INNER JOIN image i ON (i.id = ai.image_id)";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $smallAlbums = $statement->fetchAll();

        /**
         * Select album's data where count of images more than $max
         * @var $bigAlbums array() - of Object[id, name, url, title]
         * Result consist only album's cover image
         */
        $sql = "SELECT a.id, a.name, i.url, i.name as title
                FROM album a 
                INNER JOIN image i ON (i.id = a.cover AND a.id NOT IN ".$albumIdsString.")";
        $statement = $connection->prepare($sql);
        $statement->execute();
        $bigAlbums = $statement->fetchAll();

        return array('small' => $smallAlbums, 'big' => $bigAlbums);
    }
}
