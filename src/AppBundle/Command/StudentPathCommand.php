<?php


namespace AppBundle\Command;

use AppBundle\Services\StudentService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StudentPathCommand extends ContainerAwareCommand
{
    protected $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;

        parent::__construct();
    }

    protected function configure()
    {
        $this
            ->setName('generate:student:path')
            ->setDescription('Fills path column in Student table')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startTime = microtime(true);
        $this->studentService->generatePaths();
        $endTime = microtime(true);

        $output->writeln("Time elapsed: " . round($endTime - $startTime, 3) . " s");
        $output->writeln("Memory usage: " . round(memory_get_usage()/1048576, 3) . " Mb");
    }
}
