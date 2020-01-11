<?php


namespace twinkle\dto\validation\annotation;

/**
 * Class Enum
 * @package twinkle\dto\validation\annotation
 * @Annotation
 */
final class Enum
{
    public function check($value, $params = [],$ruleList = null)
    {
        return in_array($value, $params['enumList']);
    }
}