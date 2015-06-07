<?php


namespace AppBundle\Services;

use AppBundle\Repository\StudentRepository;

class StudentService
{
    private $studentRepository;

    public function __construct(StudentRepository $studentRepository)
    {
        $this->studentRepository = $studentRepository;
    }

    public function generatePaths()
    {
        return $this->studentRepository->generatePaths();
    }
}
