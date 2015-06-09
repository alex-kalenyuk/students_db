<?php

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StudentRepository extends EntityRepository
{
    public function queryAll()
    {
        return $this
            ->getEntityManager()
            ->createQuery("select s from AppBundle\Entity\Student s");
    }
}
