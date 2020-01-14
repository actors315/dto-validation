<?php

namespace twinkle\dto\validation\annotation;

use PHPUnit\Framework\TestCase;
use twinkle\dto\validation\Validate;

/**
 * vendor/bin/phpunit --bootstrap tests/bootstrap.php tests/annotation/RequiredDefaultTest.php
 * Class RequiredTest
 * @package twinkle\dto\validation\annotation
 */
class RequiredDefaultTest extends TestCase
{
    use Validate;

    /**
     * @Validate
     * @var integer autoConvert=integer
     * @Required(default=1)
     */
    public $property;

    public function setUp() {
    }

    public function testValidate()
    {
        $this->assertTrue($this->validate());
        $this->assertEquals($this->property,1);
    }
}