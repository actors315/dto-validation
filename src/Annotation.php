<?php


namespace twinkle\dto\validation;

use Exception;

/**
 * Class Annotation
 * @package twinkle\dto\validation
 */
class Annotation
{
    public final function __construct(array $data)
    {
        foreach ($data as $key => $value) {
            $this->{$key} = $value;
        }
    }

    public function __get($name)
    {
        throw new Exception(sprintf("Unknown property '%s' on annotation '%s'.", $name, get_class($this)));
    }

    public function __set($name, $value)
    {
        throw new Exception(sprintf("Unknown property '%s' on annotation '%s'.", $name, get_class($this)));
    }
}