<?php
/**
 * 网络请求
 *
 * Created by Administrator.
 * on 2019/1/11
 */
class NetworkInterface
{
    private static $KEY = "4d9d9383c876415a92bb9e2fddba0b15";
    private static $BASE_URL = "https://free-api.heweather.net/s6/weather?";
    private static $HEADERS = array("Accept: application/json", "Content-Type: application/json;charset=utf-8");

    public static function requestWeather($city)
    {
        //准备请求参数
        $curlPost = "key=" . self::$KEY . "&location=" . urlencode($city);
        //初始化请求链接
        $req = curl_init();
        //设置请求链接
        curl_setopt($req, CURLOPT_URL, self::$BASE_URL . $curlPost);
        //设置超时时长(秒)
        curl_setopt($req, CURLOPT_TIMEOUT, 3);
        //设置链接时长
        curl_setopt($req, CURLOPT_CONNECTTIMEOUT, 10);
        //设置头信息
        curl_setopt($req, CURLOPT_HTTPHEADER, self::$HEADERS);

        curl_setopt($req, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($req, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($req, CURLOPT_RETURNTRANSFER, true);
        $data = curl_exec($req);
        curl_close($req);
        return $data;
    }
}