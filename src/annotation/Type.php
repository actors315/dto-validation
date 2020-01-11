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
    private $error = '';

    public function check(&$value, $params = [], $ruleList = null)
    {
        $this->error = '';

        foreach ($params['typeList'] as $type) {
            switch ($type) {
                case '*':
                case 'mixed':
                case 'void':
                    return true;
                    break;
                case 'int':
                case 'integer':
                    if (is_int($value)) {
                        return true;
                    }
                    break;
                case 'bool':
                case 'boolean':
                    if (is_bool($value)) {
                        return true;
                    }
                    break;
                case 'float':
                case 'double':
                    if (is_float($value)) {
                        return true;
                    }
                    break;
                case 'string':
                    if (is_string($value)) {
                        return true;
                    } elseif (is_null($value) || is_int($value)) {
                        $value = strval($value);
                    }
                    break;
                case 'array':
                    if (is_array($value)) {
                        return true;
                    }
                    break;
                default:
                    if (is_object($value)) {
                        var_dump($type);
                        if ($value instanceof DtoInterface) {
                            return $value->validate();
                        } elseif ($value instanceof $type) {
                            return true;
                        }
                    }
            }
        }

        /**
         * 尝试转换
         */
        if ($params['autoConvert']) {
            $fixType = $params['autoConvert'];
            if (('integer' == $fixType || 'int' == $fixType) && is_numeric($value)) {
                $value = intval($value);
                return true;
            } elseif (('boolean' == $fixType || 'bool' == $fixType) && ('0' === $value || 0 === $value || 1 == $value)) {
                $value = boolval($value);
                return true;
            } elseif (('float' == $fixType || 'double' == $fixType) && is_numeric($value)) {
                $value = floatval($value);
                return true;
            } elseif ('string' == $fixType && $tempValue = strval($value)) {
                $value = $tempValue;
                return true;
            }
        }

        $this->error = sprintf("Type Error[expect %s,actual %s]", implode('|', $params['typeList']), gettype($value));

        return false;
    }

    public function getError()
    {
        return $this->error;
    }
}