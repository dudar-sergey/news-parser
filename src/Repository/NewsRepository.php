<?php

namespace App\Repository;

use App\Entity\Image;
use App\Entity\News;
use DateTime;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method News|null find($id, $lockMode = null, $lockVersion = null)
 * @method News|null findOneBy(array $criteria, array $orderBy = null)
 * @method News[]    findAll()
 * @method News[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class NewsRepository extends ServiceEntityRepository
{
    protected $em;

    public function __construct(EntityManagerInterface $em, ManagerRegistry $registry)
    {
        parent::__construct($registry, News::class);
        $this->em = $em;
    }

    public function createNews($data)
    {
        foreach ($data['channel']['item'] as $news) {
            $clone = $this->findBy(['url' => $news['link']]);
            if($clone) {
                continue;
            }
            $newNews = new News();
            $newNews
                ->setUrl($news['link'])
                ->setTitle($news['title'])
                ->setDescription($news['description'])
                ->setAuthor($news['author'] ?? null)
                ->setCreateAt(new DateTime($news['pubDate']));
            $this->em->persist($newNews);
            if(isset($news['enclosure'])) {
                foreach ($news['enclosure'] as $key => $enclosure) {
                    $image = new Image();
                    if($key === '@url') {
                        $image->setUrl($enclosure);
                        $image->setNews($newNews);
                        $this->em->persist($image);
                        break;
                    } else if($enclosure['@type'] == 'image/jpeg') {
                        $image->setUrl($enclosure['@url']);
                        $image->setNews($newNews);
                        $this->em->persist($image);
                    }
                }
            }
        }
        $this->em->flush();
        return $newNews;
    }

    // /**
    //  * @return News[] Returns an array of News objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('n.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?News
    {
        return $this->createQueryBuilder('n')
            ->andWhere('n.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
