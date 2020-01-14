<?php

namespace twinkle\dto\validation\cache;

/**
 * 规则缓存，可自定义缓存方式，但是必须实现 get和 set 方法
 *
 * Class AbstractCache
 * @package twinkle\dto\validation\cache
 */
abstract class AbstractCache implements CacheInterface
{

    protected $lifetime = 86400;

    public function __construct($lifetime = null)
    {
        $this->setLifeTime($lifetime);
    }

    public function setLifeTime($lifetime)
    {
        $this->lifetime = (int)$lifetime;

        // 不允许缓存永久存在
        if ($this->lifetime <= 0) {
            $this->lifetime = 86400;
        }

        return $this;
    }

    abstract public function getCacheKey($identify);

    abstract public function set($identify, $rules = []);

    abstract public function get($identify, $modifyTime = 0);
}
