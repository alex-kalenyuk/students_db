<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;

class StudentService
{
    const BATCH_SIZE = 20;

    private $entityManager;
    private $paths = [];

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function generatePaths()
    {
        $i = 0;
        $q = $this->entityManager->createQuery("select s from AppBundle\Entity\Student s");
        foreach ($q->iterate() as $row) {
            $student = $row[0];
            $student->setPath($this->getUniquePath($student->getName()));
            if (($i % self::BATCH_SIZE) === 0) {
                $this->entityManager->flush(); // Executes all updates.
                $this->entityManager->clear(); // Detaches all objects from Doctrine!
            }
            ++$i;
        }
        $this->entityManager->flush();
    }

    public function getUniquePath($name)
    {
        $path = strtolower(str_replace(" ", "_", $name));

        if (!array_key_exists($path, $this->paths)) {
            $this->paths[$path] = 1;
            return $path;
        }

        $this->paths[$path]++;
        return $path . "_" . $this->paths[$path];
    }
}
