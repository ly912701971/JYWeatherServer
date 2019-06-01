<?php
/**
 * Created by Administrator.
 * on 2019/1/14
 */

class JsonUtil
{
    public static function timeJudge($updateTime)
    {
        date_default_timezone_set('PRC');// 设置时区为中国
        return ceil(strtotime(date("Y-m-d H:i:s")) - strtotime($updateTime)) > 30 * 60;
    }

    public static function getLocation($jsonData)
    {
        return self::decode($jsonData)->basic->location;
    }

    public static function getUpdateTime($jsonData)
    {
        return self::decode($jsonData)->update->loc;
    }

    public static function getStatus($jsonData)
    {
        return self::decode($jsonData)->status;
    }

    private static function decode($jsonData)
    {
        return json_decode($jsonData)->HeWeather6[0];
    }
}