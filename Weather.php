<?php
require_once("NetworkInterface.php");
require_once("MySQLUtil.php");
require_once("FileCache.php");
require_once("Response.php");
require_once("JsonUtil.php");

$city = isset($_GET["city"]) ? $_GET["city"] : "unknown";
$format = isset($_GET["format"]) ? $_GET["format"] : "json";
$cache = FileCache::cacheData($city);
if ($cache) {
    if (JsonUtil::timeJudge(JsonUtil::getUpdateTime($cache))) {// 缓存过期
        FileCache::cacheData($city, null);
    } else {
        Response::show(JsonUtil::getStatus($cache), $format, $cache);
        exit(0);
    }
}

$link = MySQLUtil::getInstance()->connect();
$row = mysqli_query($link, "select * from `weather` where `city`='$city'");
if (mysqli_num_rows($row) < 1) {// 查无数据，则请求数据并插入数据库
    $jsonData = NetworkInterface::requestWeather($city);
    if ($status = JsonUtil::getStatus($jsonData) !== "ok") {
        Response::show($status, $format);
        exit(0);
    }
    $updateTime = JsonUtil::getUpdateTime($jsonData);
    mysqli_query($link, "insert into `weather` values('$city','$updateTime','$jsonData')");
} else {
    $obj = $row->fetch_object();
    if (JsonUtil::timeJudge($obj->updateTime)) {
        // 时间超过1小时，重新请求数据并更新数据库
        $jsonData = NetworkInterface::requestWeather($city);
        if ($status = JsonUtil::getStatus($jsonData) !== "ok") {
            Response::show($status, $format);
            exit(0);
        }
        $updateTime = JsonUtil::getUpdateTime($jsonData);
        mysqli_query($link, "update `weather` set `updateTime`='$updateTime',`weatherData`='$jsonData' where `city`='$city'");
    } else {
        $jsonData = $obj->weatherData;
    }
}
Response::show($status, $format, $jsonData);
FileCache::cacheData($city, $jsonData);
mysqli_free_result($row);
mysqli_close($link);