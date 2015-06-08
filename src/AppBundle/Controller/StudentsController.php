<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;


class StudentsController extends Controller
{
    /**
     * @param Student $student
     * @Route("/students/detail/{path}", name="detail")
     * @Template
     * @return array
     */
    public function detailAction(Student $student)
    {
        return ['student' => $student];
    }
}
