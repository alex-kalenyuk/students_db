<?php

namespace AppBundle\Services;

use AppBundle\Entity\Student;
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
        $q = $this->entityManager->getRepository('AppBundle:Student')->queryAll();
        foreach ($q->iterate() as $row) {
            /** @var Student */
            $student = $row[0];
            $student->setPath($this->getUniquePath($student->getName()));
            if (($i % self::BATCH_SIZE) === 0) {
                $this->entityManager->flush(); // Executes all updates.
                $this->entityManager->clear(); // Detaches all objects from Doctrine!
                gc_collect_cycles();
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
        $path = $this->slugify($name);

        if (!array_key_exists($path, $this->paths)) {
            $this->paths[$path] = 1;
            return $path;
        }

        $uniquePath = $path . self::PATH_SEPARATOR . $this->paths[$path];
        $this->paths[$path]++;
        return $uniquePath;
    }

    /**
     * Transform (e.g. "Hello World") into a slug (e.g. "hello-world")
     * @param string $string
     * @return string
     */
    public function slugify($string)
    {
        return preg_replace(
            '/[^a-z0-9]/',
            self::PATH_SEPARATOR,
            strtolower(trim(strip_tags($string)))
        );
    }
}
