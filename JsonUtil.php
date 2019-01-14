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
        return ceil(strtotime(date("Y-m-d H:i:s")) - strtotime($updateTime)) > 60 * 60;
    }

    public static function getUpdateTime($jsonData)
    {
        return json_decode($jsonData)->HeWeather6[0]->update->loc;
    }

    public static function getStatus($jsonData)
    {
        return json_decode($jsonData)->HeWeather6[0]->status;
    }
}