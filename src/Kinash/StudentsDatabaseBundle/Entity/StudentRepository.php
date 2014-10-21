<?php

namespace Kinash\StudentsDatabaseBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * StudentRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class StudentRepository extends EntityRepository
{
    public function getStudents($limit,$offset){
        return $this->findBy(array(), null, $limit, $offset);
    }

}