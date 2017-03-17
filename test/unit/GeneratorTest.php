<?php

use Rapture\Generator\PhpClass;
use Rapture\Generator\PhpComment;
use Rapture\Generator\PhpMethod;
use Rapture\Generator\PhpProperty;

class GeneratorTest extends \PHPUnit_Framework_TestCase
{
    public function testUser()
    {
        $class = new PhpClass('Test');
        $class->setNamespace('Demo')
            ->setIsAbstract(true)
            ->setIsFinal(true)
            ->setExtends('\Rapture\Component\Definition\ClassAbstract')
            ->addImplements('\Rapture\Component\Definition\ClassInterface')
            ->addTrait('\Rapture\Component\Definition\ClassTrait')
            ->addConstant('status_on', 1)
            ->addConstant('status_off', 2)
            ->addProperty(new PhpProperty('status', 'self::STATUS_OFF', PhpMethod::KEYWORD_PROTECTED))
            ->addMethod(
                new PhpMethod(
                    'setStatus',
                    '$this->status = $status;' . "\n" . "\n" . 'return $this;',
                    PhpMethod::KEYWORD_PUBLIC,
                    [['status', 'int', 'self::STATUS_OFF']]
                )
            )
            ->setComment(new PhpComment(['Class Demo', '', '@see HelloWorld']));

        $this->assertEquals('<?php

namespace Demo;

use Rapture\Component\Definition\ClassAbstract;
use Rapture\Component\Definition\ClassInterface;
use Rapture\Component\Definition\ClassTrait;

/**
 * Class Demo
 * 
 * @see HelloWorld
 */
final abstract class Test extends ClassAbstract implements ClassInterface
{
    use ClassTrait;

    const STATUS_ON = 1;
    const STATUS_OFF = 2;

    protected $status = self::STATUS_OFF;

    public function setStatus(int $status = self::STATUS_OFF)
    {
        $this->status = $status;

        return $this;
    }
}
', \Rapture\Generator\PhpRender::renderClass($class));
    }
}
