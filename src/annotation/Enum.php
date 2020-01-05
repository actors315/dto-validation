<?php


namespace twinkle\dto\validation\annotation;

/**
 * Class Enum
 * @package twinkle\dto\validation\annotation
 * @Annotation
 */
final class Enum
{
    public function check($value, $enumList)
    {
        return in_array($value,$enumList);
    }
}