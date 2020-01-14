<?php


namespace twinkle\dto\validation;

use ReflectionClass;
use ReflectionException;
use Twinkle\DI\Tools;
use twinkle\dto\validation\cache\AbstractCache;

/**
 * Trait Validate
 * @package twinkle\dto\validation
 */
trait Validate
{

    protected $annotationValidateRules = [];

    /**
     * @var AbstractCache
     */
    public $ruleCacheHandler = null;


    /**
     * 规则解析
     * @throws ReflectionException
     */
    public function parser()
    {
        if ($this->annotationValidateRules) {
            return $this->annotationValidateRules;
        }

        $class = new ReflectionClass(__CLASS__);
        if ($this->ruleCacheHandler && $rules = $this->ruleCacheHandler->get(__CLASS__, filemtime($class->getFileName()))) {
            unset($class);
            return $this->annotationValidateRules = $rules;
        }

        $properties = $class->getProperties();
        foreach ($properties as $property) {
            $propertyComment = $property->getDocComment();
            if (false === strpos($propertyComment, '@Validate')) {
                continue;
            }

            $name = $property->getName();
            if (false !== strpos($propertyComment, '@Required')) {
                preg_match('/@Required[(](.*)[)]/', $propertyComment, $matches);
                $this->annotationValidateRules[$name]['Required'] = null;
                if (!empty($matches[1])) {
                    $params = [];
                    $tempList = explode(',', trim($matches[1]));
                    foreach ($tempList as $temp) {
                        list($k, $v) = explode('=', $temp);
                        $params[trim($k)] = $v;
                    }
                    $this->annotationValidateRules[$name]['Required'] = $params;
                }
            }

            if (false !== strpos($propertyComment, '@var') && preg_match('/@var\s+([^\s]+)\s+(autoConvert=([^\s]+))*/', $propertyComment, $matches)) {
                $typeList = explode('|', $matches[1]);
                $this->annotationValidateRules[$name]['Type'] = ['typeList' => $typeList, 'autoConvert' => isset($matches[2]) ? $matches[3] : false];
            }

            if (false !== strpos($propertyComment, '@Enum') && preg_match('/@Enum[(](.+)[)]/', $propertyComment, $matches)) {
                $enumList = explode(',', $matches[1]);
                $this->annotationValidateRules[$name]['Enum'] = ['enumList' => $enumList];
            }
        }

        if ($this->ruleCacheHandler) {
            $this->ruleCacheHandler->set(__CLASS__, $this->annotationValidateRules);
        }

        return $this->annotationValidateRules;
    }

    public function validate()
    {
        $rules = $this->parser();

        $ruleContainer = Tools::getContainer();
        foreach ($rules as $key => $ruleList) {
            foreach ($ruleList as $name => $rule) {
                if (!isset($ruleContainer["Validate:{$name}"])) {
                    throw new \RuntimeException('请先注入规则较验器【Validate:' . $name . '】');
                }

                try {
                    if (!$ruleContainer["Validate:{$name}"]->check($this->{$key}, $rule, $ruleList)) {
                        return false;
                    }
                } catch (\Exception $e) {
                    return false;
                }
            }
        }

        return true;
    }
}