<?php

namespace twinkle\dto\validation\annotation;

/**
 * 必须
 * Class Required
 * @package twinkle\dto\validation\annotation
 * @Annotation
 */
final class Required
{
    public function check(&$value, $default = null)
    {
        if (null !== $value) {
            return true;
        } elseif (null !== $default) {
            $value = $default;
            return true;
        }
        return false;
    }
}