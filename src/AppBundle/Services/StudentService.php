<?php

namespace AppBundle\Services;

use Doctrine\ORM\EntityManager;

class StudentService
{
    const BATCH_SIZE = 20;
    const PATH_SEPARATOR = '_';

    private $entityManager;
    private $paths = [];

    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Updates column 'path' with unique slug of student's name
     */
    public function generatePaths()
    {
        $i = 0;
        // todo: it's better to move query to repository class
        $q = $this->entityManager->createQuery("select s from AppBundle\Entity\Student s");
        foreach ($q->iterate() as $row) {
            // todo: add /** @var Type */
            $student = $row[0];
            $student->setPath($this->getUniquePath($student->getName()));
            if (($i % self::BATCH_SIZE) === 0) {
                $this->entityManager->flush(); // Executes all updates.
                $this->entityManager->clear(); // Detaches all objects from Doctrine!
                //todo: call garbage collector
            }
            ++$i;
        }
        $this->entityManager->flush();
    }

    /**
     * Creates unique path for each name
     *
     * @param string $name
     * @return string
     */
    public function getUniquePath($name)
    {
        // todo: not safe, sanitize not only spaces but all other incorrect symbols
        $path = strtolower(str_replace(" ", self::PATH_SEPARATOR, $name));

        if (!array_key_exists($path, $this->paths)) {
            $this->paths[$path] = 1;
            return $path;
        }

        $uniquePath = $path . self::PATH_SEPARATOR . $this->paths[$path];
        $this->paths[$path]++;
        return $uniquePath;
    }
}
