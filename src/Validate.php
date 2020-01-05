<?php


namespace twinkle\dto\validation;

use ReflectionClass;
use ReflectionException;
use Twinkle\DI\Exception\ContainerException;
use Twinkle\DI\Tools;
use twinkle\dto\validation\annotation\Enum;
use twinkle\dto\validation\annotation\Required;
use twinkle\dto\validation\annotation\Type;
use twinkle\dto\validation\rule\Rule;

/**
 * Trait Validate
 * @package twinkle\dto\validation
 */
trait Validate
{

    protected $isParser = false;

    public $validateRules = [];

    /**
     * 规则解析
     * @throws ReflectionException
     * @throws ContainerException
     */
    public function parser()
    {
        if ($this->isParser) {
            return true;
        }

        Tools::getContainer()->injection('Validate:Required', Required::class);
        Tools::getContainer()->injection('Validate:Type', Type::class);
        Tools::getContainer()->injection('Validate:Enum', Enum::class);

        $class = new ReflectionClass(__CLASS__);
        $properties = $class->getProperties();
        foreach ($properties as $property) {
            $propertyComment = $property->getDocComment();
            if (false === strpos($propertyComment, '@Validate')) {
                continue;
            }

            $name = $property->getName();
            if (false !== strpos($propertyComment, '@Required')) {
                preg_match('/@Required[(]default=([^,]+)[)]\s+([^\s]+)/', $propertyComment, $matches);
                $this->validateRules[$name]['Required'] = isset($matches[1]) ? $matches[1] : null;
            }

            if (false !== strpos($propertyComment, '@var') && preg_match('/@var\s+([^\s]+)/', $propertyComment, $matches)) {
                $typeList = explode('|', $matches[1]);
                $this->validateRules[$name]['Type'] = $typeList;
            }

            if (false !== strpos($propertyComment, '@Enum') && preg_match('/@Enum[(](.+)[)]/', $propertyComment, $matches)) {
                $this->validateRules[$name]['Enum'] = explode(',', $matches[1]);
            }
        }

        $this->isParser = true;
    }

    public function validate()
    {
        $this->parser();

        $ruleContainer = Tools::getContainer();
        foreach ($this->validateRules as $key => $ruleList) {
            foreach ($ruleList as $name => $rule) {
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