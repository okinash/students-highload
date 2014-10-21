<?php
namespace Kinash\StudentsDatabaseBundle\DataFixtures\ORM;

use Hautelook\AliceBundle\Alice\DataFixtureLoader;
use Nelmio\Alice\Fixtures;

class FixturesLoader extends DataFixtureLoader
{
    /**
    * {@inheritDoc}
    */
    protected function getFixtures()
    {
        return  array(
            __DIR__ . '/data.yml',

        );
    }
}