<?php

namespace AppBundle\Tests\Services;

use AppBundle\Services\StudentService;

class StudentServiceTest extends \PHPUnit_Framework_TestCase
{
    const UNIQUE_PATH = 'unique_path';
    const STUDENTS_AMOUNT = 2;

    public function testGeneratePaths()
    {
        $student = $this
            ->getMockBuilder('\AppBundle\Entity\Student')
            ->disableOriginalConstructor()
            ->getMock();
        $student->expects($this->exactly(self::STUDENTS_AMOUNT))
            ->method('setPath')
            ->with($this->equalTo(self::UNIQUE_PATH));
        $student->expects($this->exactly(self::STUDENTS_AMOUNT))
            ->method('getName');

        $iterator = $this
            ->getMockBuilder('\stdClass')
            ->setMethods(['iterate'])
            ->getMock();
        $iterator->expects($this->once())
            ->method('iterate')
            ->will($this->returnValue([[$student], [$student]]));

        $studentRep = $this
            ->getMockBuilder('\AppBundle\Repository\StudentRepository')
            ->disableOriginalConstructor()
            ->getMock();
        $studentRep->expects($this->once())
            ->method('queryAll')
            ->will($this->returnValue($iterator));

        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $entityManager->expects($this->once())
            ->method('getRepository')
            ->with($this->equalTo('AppBundle:Student'))
            ->will($this->returnValue($studentRep));
        $entityManager->expects($this->any())
            ->method('flush');

        $service = $this->getMockBuilder('\AppBundle\Services\StudentService')
            ->setConstructorArgs([$entityManager])
            ->setMethods(['getUniquePath'])
            ->getMock();
        $service->expects($this->exactly(self::STUDENTS_AMOUNT))
            ->method('getUniquePath')
            ->will($this->returnValue(self::UNIQUE_PATH));
        $service->generatePaths();
    }

    public function testGetUniquePath()
    {
        $entityManager = $this
            ->getMockBuilder('\Doctrine\ORM\EntityManager')
            ->disableOriginalConstructor()
            ->getMock();
        $service = new StudentService($entityManager);

        $this->assertEquals(
            'firstname_lastname',
            $service->getUniquePath('FirstName LastName')
        );
        $this->assertEquals(
            'firstname_lastname_1',
            $service->getUniquePath('FirstName LastName')
        );
    }
}
