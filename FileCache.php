<?php
/**
 * Created by Administrator.
 * on 2019/1/14
 */

class FileCache
{
    private static $DEFAULT_PATH = "/caches/";
    private static $DEFAULT_EXT = ".txt";

    /**
     * 以城市名为文件名创建文件缓存
     *
     * @param $city string
     * @param string $jsonData json数据
     * @return bool|false|int|string
     */
    public static function cacheData($city, $jsonData = '')
    {
        $fileName = dirname(__FILE__) . self::$DEFAULT_PATH . $city . self::$DEFAULT_EXT;
        if ($jsonData !== '') {
            if (is_null($jsonData)) {
                return @unlink($fileName);// 删除缓存
            }

            $dir = dirname($fileName);
            if (!is_dir($dir)) {
                mkdir($dir, 0777);
            }
            return file_put_contents($fileName, $jsonData);// 写入缓存
        }

        if (is_file($fileName)) {
            return file_get_contents($fileName);// 读取缓存
        }
        return false;
    }
}