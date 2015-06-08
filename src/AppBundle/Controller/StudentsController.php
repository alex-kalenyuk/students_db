<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use AppBundle\Entity\Student;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Cache;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

/**
 * Class StudentsController
 * @Route("/students")
 */
class StudentsController extends Controller
{
    /**
     * @param Student $student
     * @Route("/detail/{path}", name="detail")
     * @Cache(maxage="900", expires="15 minutes", public=true)
     * @Template("AppBundle:Students:detail.html.twig", vars={"student"})
     * @return array
     */
    public function detailAction(Student $student)
    {

    }
}
