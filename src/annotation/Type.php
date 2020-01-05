<?php

/**
 * PHP 支持 9 种原始数据类型。
 *
 * 四种标量类型：
 *
 * boolean（布尔型）
 * integer（整型）
 * float（浮点型，也称作 double)
 * string（字符串）
 * 三种复合类型：
 *
 * array（数组）
 * object（对象）
 * callable（可调用）
 * 最后是两种特殊类型：
 *
 * resource（资源）
 * NULL（无类型）
 *
 * 伪类型：
 *
 * mixed（混合类型）
 * number（数字类型）
 * callback（回调类型，又称为 callable）
 * array|object（数组 | 对象类型）
 * void （无类型）
 */

namespace twinkle\dto\validation\annotation;

use twinkle\dto\validation\DtoInterface;

/**
 * Class Enum
 * @package twinkle\dto\validation\annotation
 * @Annotation
 */
final class Type
{
    public function check(&$value, $typeList)
    {
        foreach ($typeList as $type) {
            switch ($type) {
                case '*':
                case 'mixed':
                case 'void':
                    return true;
                    break;
                case 'int':
                case 'integer':
                    if ('integer' == gettype($value)) {
                        return true;
                    } elseif (is_numeric($value)) {
                        $value = intval($value);
                        return true;
                    }
                    break;
                case 'bool':
                case 'boolean':
                    if ('boolean' == gettype($value)) {
                        return true;
                    } elseif (0 === $value || 1 === $value) {
                        $value = boolval($value);
                        return true;
                    }
                    break;
                case 'float':
                case 'double':
                    if ('float' == gettype($value)) {
                        return true;
                    } elseif ('integer' == gettype($value)) {
                        $value = floatval($value);
                        return true;
                    }
                    break;
                case 'array':
                    if (is_array($value)) {
                        return true;
                    }
                    break;
                case 'object':
                    if (is_object($value)) {
                        return true;
                    }
                    break;
                case 'callable':
                    if (is_callable($value)) {
                        return true;
                    }
                    break;
                default:
                    if (is_object($value)) {
                        if ($value instanceof DtoInterface && $value->validate()) {
                            return true;
                        }

                        if ($value instanceof $type) {
                            return true;
                        }
                    }
            }
        }

        return false;
    }
}