<?php


namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;

class StudentRepository extends EntityRepository
{
    public function generatePaths()
    {
        return false;
    }
}
