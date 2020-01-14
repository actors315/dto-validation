<?php


namespace twinkle\dto\validation\cache;


interface CacheInterface
{

    /**
     * @param string $identify 缓存标识
     * @param array $rules 较验规则
     */
    public function set($identify, $rules = []);

    /**
     * @param string $identify
     * @param int $modifyTime dto文件更新时间
     * @return false | array
     */
    public function get($identify,$modifyTime = 0);
}