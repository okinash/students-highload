<?php
namespace Kinash\StudentsDatabaseBundle\Tests\Service;
use Kinash\StudentsDatabaseBundle\Service\PathGenerator;
class StudentServiceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @return StudentService
     */
    public function getPathGeneratorService()
    {
        return new PathGenerator();
    }


    public function encodePathProvider()
    {
        return [
            [ 'Ivan Petrov', 'ivan_petrov' ],
            [ 'Ivan         Petrov', 'ivan_petrov' ],
            [ 'Ivan@#*__&^Petrov^:..,?', 'ivan_petrov' ],
            [ 'Ivan     Petrov    @#&^111', 'ivan_petrov_111' ],
        ];
    }

    /**
     * @param string $str
     * @param string $expected
     * @dataProvider encodePathProvider
     */
    public function testEncodeString($str, $expected)
    {
        $generator = new PathGenerator();
        $actual = $generator->encodePath($str);
        $this->assertEquals($expected, $actual);
    }


    /**
     * Test for right adding __i if path exist
     */
    public function testGenerateUniquePath()
    {
        $generator = new PathGenerator();
        foreach ($this->generateUniquePathProvider() as $data) {
            $input = $data[0];
            $expected = $data[1];
            $this->assertEquals($expected, $generator->generateUniquePath($input));
        }
    }

    public function generateUniquePathProvider()
    {
        return [
            [ 'John Newman', 'john_newman' ],
            [ 'John Newman', 'john_newman_1' ],
            [ 'Carlo Pazolini', 'carlo_pazolini' ],
            [ 'Ivan Petrov', 'ivan_petrov' ],
            [ 'Carlo Pazolini', 'carlo_pazolini_1' ],
            [ 'John Newman', 'john_newman_2' ],
            [ 'John Newman', 'john_newman_3' ],
            [ 'Carlo Pazolini', 'carlo_pazolini_2' ],
            [ 'Someone', 'someone' ],
            [ 'Someone', 'someone_1' ],
            [ 'Someone', 'someone_2' ],
            [ 'Someone', 'someone_3' ],
        ];
    }
}