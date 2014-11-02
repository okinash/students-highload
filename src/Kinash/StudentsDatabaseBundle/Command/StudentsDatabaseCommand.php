<?php

namespace Kinash\StudentsDatabaseBundle\Command;

use Kinash\StudentsDatabaseBundle\Service\PathGenerator;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StudentsDatabaseCommand extends ContainerAwareCommand
{
    const BATCH_SIZE = 2500;

    protected function configure()
    {
        $this
            ->setName('studentsdatabase:path:generate')
            ->setDescription('Update path of each student by his name')
        ;
    }

    /**
     * Generate unique path for all students
     */
    protected function generatePath()
    {
        $pathGenerator = $this->getContainer()->get('students_database.path_generator');
        $em =$this->getContainer()->get('doctrine.orm.entity_manager');
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        $repo = $em->getRepository('Kinash\StudentsDatabaseBundle\Entity\Student');
        $offset = 0;
        while ($students = $repo->getStudents(self::BATCH_SIZE, $offset)) {
            $offset += self::BATCH_SIZE;
            $success = 0;
            foreach ($students as $student) {
                $path = $pathGenerator->generateUniquePath($student->getName());
                $student->setPath($path);
                $success++;
            }
            $em->flush();
            $em->clear();
            gc_collect_cycles();
        }
        $em->flush();
    }


    /**
     * Alternative way - Generate unique path for all students using Iterator
     */
    protected function generatePathUsingIterator()
    {
        $pathGenerator = $this->getContainer()->get('students_database.path_generator');
        $em =$this->getContainer()->get('doctrine.orm.entity_manager');
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        $repo = $em->getRepository('Kinash\StudentsDatabaseBundle\Entity\Student');
        $studentsIterator = $repo->getIterator();
        $i = 0;
        foreach ($studentsIterator as $row) {
            $student = $row[0];
            $path = $pathGenerator->generateUniquePath($student->getName());
            $student->setPath($path);
            if (($i % self::BATCH_SIZE) === 0) {
                $em->flush();
                $em->clear();
                gc_collect_cycles();
            }
            ++$i;
        }
        $em->flush();
        $em->flush();
    }



    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $startTime = microtime(true);

        #first way - using limits - more expencive
        #$this->generatePath();

        //second way
        $this->generatePathUsingIterator();

        $timeElapsed = microtime(true) - $startTime;
        $output->writeln(
            sprintf('Time elapsed: %.3f s', $timeElapsed)
        );
        $output->writeln(
            sprintf('Memory usage: %.3f Mb', memory_get_peak_usage() /1048576)
        );
    }
}
