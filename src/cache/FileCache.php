<?php


namespace twinkle\dto\validation\cache;


use RuntimeException;

class FileCache extends AbstractCache
{

    /**
     * 缓存目录
     * @var bool|string
     */
    protected $cacheDir;

    public function __construct($cacheDir, $lifetime = null)
    {
        parent::__construct($lifetime);

        if (!is_dir($cacheDir)) {
            mkdir($cacheDir, 0777, true);
        }

        $this->cacheDir = realpath($cacheDir);

        if (!is_writable($this->cacheDir)) {
            throw new RuntimeException(
                'Unable to write the cache directory: ' . $this->cacheDir
            );
        }
    }

    public function getCacheKey($identify)
    {
        return $this->cacheDir . DIRECTORY_SEPARATOR . md5($identify) . '.cache';
    }

    /**
     * @param string $identify dto维一标识，一般是类名
     * @param array $rules
     */
    public function set($identify, $rules = [])
    {
        file_put_contents($this->getCacheKey($identify), serialize([
            'parse_time' => time(),
            'rules' => $rules,
        ]), LOCK_EX | LOCK_NB);
    }

    /**
     * @param string $identify
     * @param int $modifyTime
     * @return false | array
     */
    public function get($identify, $modifyTime = 0)
    {
        $file = $this->getCacheKey($identify);
        if (!file_exists($file)) {
            return false;
        }

        $data = unserialize(file_get_contents($file));
        if (empty($data) || $modifyTime > $data['parse_time'] || time() > $data['parse_time'] + $this->lifetime) {
            unlink($file);
            return false;
        }

        return $data['rules'];
    }
}