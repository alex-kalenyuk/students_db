<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class StudentsController
 */
class StudentsController extends Controller
{
    /**
     * @param Student $student
     * @return array
     *
     * @Route("/students/detail/{path}", name="detail")
     * @Cache(maxage="900", expires="15 minutes", public=true)
     * @Template()
     */
    public function detailAction(Student $student)
    {
        return ['student' => $student];
    }
}
