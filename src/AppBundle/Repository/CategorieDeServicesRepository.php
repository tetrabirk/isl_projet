<?php

namespace AppBundle\Repository;

/**
 * CategorieDeServicesRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CategorieDeServicesRepository extends \Doctrine\ORM\EntityRepository
{
    public function findCategoriesDeServices($slug=null)
    {
        $qb = $this->createWithJoin();

        if($slug != null) {
            $qb->where('c.slug =:slug');
            $qb->setParameter('slug', $slug);

            return $this->returnSingleResult($qb);

        }else{
            return $this->returnResult($qb);
        }


    }

    public function isValide($qb)
    {
        $qb->where('c.valide = 1');
    }
    public function findEnAvant()
    {
        $qb = $this->createWithJoin();

        $qb->where('c.enAvant = 1');

        return $this->returnSingleResult($qb);
    }

    protected function createWithJoin()
    {
        $qb = $this->createQueryBuilder('c');
        $this->addJoins($qb);
        $this->isValide($qb);
        return $qb;
    }

    protected function addJoins($qb)
    {
        $qb->leftJoin('c.image','image')->addSelect('image');
    }

    protected function returnResult($qb)
    {
        $qb->orderBy('c.nom','ASC');
        $query= $qb->getQuery();
        $result=$query->getResult();
        return $result;
    }

    protected function returnSingleResult($qb)
    {
        $query= $qb->getQuery();
        $result=$query->getSingleResult();
        return $result;
    }
}
