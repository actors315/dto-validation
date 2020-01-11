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
    public function check(&$value, $params = [],$ruleList = null)
    {
        if (null !== $value) {
            return true;
        } elseif (!empty($params) && isset($params['default'])) {
            $value = $params['default'];
            return true;
        }
        return false;
    }
}