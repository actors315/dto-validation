<?php

namespace twinkle\dto\validation\annotation;

use PHPUnit\Framework\TestCase;
use twinkle\dto\validation\Validate;

/**
 * vendor/bin/phpunit --bootstrap tests/bootstrap.php tests/annotation/RequiredTest.php
 * Class RequiredTest
 * @package twinkle\dto\validation\annotation
 */
class RequiredTest extends TestCase
{
    use Validate;

    /**
     * @Validate
     * @var integer
     * @Required()
     */
    public $property;

    public function setUp() {
    }

    public function testValidate()
    {
        $this->assertFalse($this->validate());
        $this->property = 1;
        $this->assertTrue($this->validate());
    }
}