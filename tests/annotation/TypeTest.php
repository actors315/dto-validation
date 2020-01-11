<?php


namespace twinkle\dto\validation\annotation;


use PHPUnit\Framework\TestCase;
use twinkle\dto\validation\DtoInterface;
use twinkle\dto\validation\Validate;

/**
 * vendor/bin/phpunit --bootstrap vendor/autoload.php tests/annotation/TypeTest.php
 * Class TypeTest
 * @package twinkle\dto\validation\annotation
 */
class TypeTest extends TestCase
{
    use Validate;

    /**
     * @Validate
     * @var TestImpl
     */
    public $property;

    public function setUp() {
    }

    public function testValidate()
    {
        $this->property = new TestImpl();
        $this->assertFalse($this->validate());
        $this->property->property = 1;
        $this->assertTrue($this->validate());
    }

}

class TestImpl implements DtoInterface
{
    use Validate;

    /**
     * @Validate
     * @Required()
     */
    public $property;
}