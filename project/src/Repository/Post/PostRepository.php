<?php

namespace App\Repository\Post;

use App\Entity\Post\Tag;
use App\Entity\Post\Post;
use App\Entity\Post\Category;
use App\Model\SearchData;
use Doctrine\Migrations\Version\State;
use Doctrine\Persistence\ManagerRegistry;
use Knp\Component\Pager\PaginatorInterface;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;


/**
 * @extends ServiceEntityRepository<Post>
 *
 * @method Post|null find($id, $lockMode = null, $lockVersion = null)
 * @method Post|null findOneBy(array $criteria, array $orderBy = null)
 * @method Post[]    findAll()
 * @method Post[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PostRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, private PaginatorInterface $paginator)
    {
        parent::__construct($registry, Post::class);
    }

    // public function save(Post $entity, bool $flush = false): void
    // {
    //     $this->getEntityManager()->persist($entity);

    //     if ($flush) {
    //         $this->getEntityManager()->flush();
    //     }
    // }

    // public function remove(Post $entity, bool $flush = false): void
    // {
    //     $this->getEntityManager()->remove($entity);

    //     if ($flush) {
    //         $this->getEntityManager()->flush();
    //     }
    // }

        /**
      * Get published posts
      *
      * @param integer $page
      * @param Category|null $category
      * @param Tag|null $tag
      * @return PaginationInterface
      */
    public function findpublished(int $page, ?Category $category = null, ?Tag $tag = null): PaginationInterface
    {
        // 'p' is an alias of post
        $data =  $this->createQueryBuilder('p')
            // ->select('c', 'p')  // On selectionne les catégorie et les posts
            ->join('p.categories', 'c') // p.categories, qui prend l'alias 'c' avec la jointure
            ->where('p.state LIKE :state')
            ->setParameter('state', '%STATE_PUBLISHED%')
            ->orderBy('p.createdAt', 'DESC');

        if(isset($category)) {
            $data = $data
            // ->andWhere('c.id LIKE :category')
            // ->setParameter('category', $category->getId());
            ->andWhere(':category IN (c)')
            ->setParameter('category', $category);

        }

        if(isset($tag)) {
            $data = $data
            ->join('p.tags', 't') // t.tags, qui prend l'alias 'c' avec la jointure
            ->andWhere(':tag IN (t)')
            ->setParameter('tag', $tag);

        }

        $data->getQuery()
            ->getResult();
        
        // pagination system with KnpPaginatorBundle
        $posts = $this->paginator->paginate($data, $page, 9);

        return $posts;
    }


//    /**
//     * @return Post[] Returns an array of Post objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Post
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }

    /**
     * Get published posts with the search data
     *
     * @param SearchData $searchData
     * @return PaginatorInterface
     */
    public function findBySearch(SearchData $searchData): PaginationInterface {

        $data = $this->createQueryBuilder('p')
                    ->where('p.state LIKE :state')    
                    ->setParameter('state', '%STATE_PUBLISHED%')
                    ->orderBy('p.createdAt', 'DESC');

                    if(!empty($searchData->q)){
                        // Search on post's title and tag's name
                        $data = $data
                                    ->join('p.tags', 't')
                                    ->andWhere('p.title LIKE :q')
                                    ->orWhere('t.name LIKE :q')
                                    ->setParameter('q', "%{$searchData->q}%");


                    }

                    $data = $data
                    ->getQuery()
                    ->getResult();


        $posts = $this->paginator->paginate($data, $searchData->page, 9);

        return $posts;
                    
    }
}
