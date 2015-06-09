<?php


namespace AppBundle\Command;

use AppBundle\Services\StudentService;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StudentPathCommand extends ContainerAwareCommand
{
    const PRECISION = 3;

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

        // todo: it's better to use constants here
        $output->writeln("Time elapsed: " . round($endTime - $startTime, self::PRECISION) . " s");
        $output->writeln(
            "Memory usage: " .
            round(memory_get_usage() / self::ONE_MB_IN_BYTES, self::PRECISION) . " Mb"
        );
    }
}
