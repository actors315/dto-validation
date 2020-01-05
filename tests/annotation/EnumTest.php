<?php

namespace twinkle\dto\validation\annotation;

use PHPUnit\Framework\TestCase;
use twinkle\dto\validation\Validate;

/**
 * vendor/bin/phpunit --bootstrap vendor/autoload.php tests/annotation/EnumTest.php
 * Class RequiredTest
 * @package twinkle\dto\validation\annotation
 */
class EnumTest extends TestCase
{
    use Validate;

    /**
     * @Validate
     * @Enum(1,2,3)
     */
    public $property;

    public function setUp() {
    }

    public function testValidate()
    {
        $this->property = 1;
        $this->assertTrue($this->validate());
        $this->property = 0;
        $this->assertFalse($this->validate());
    }
}