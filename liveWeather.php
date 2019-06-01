<?php
require_once('MySQLUtil.php');
require_once('Response.php');
/**
 * 返回实景天气列表
 *
 * User: Yang
 * Date: 2019/5/26
 * Time: 20:08
 */
$pageIndex = isset($_GET['pageIndex']) ? $_GET['pageIndex'] : 0;
$pageSize = isset($_GET['pageSize']) ? $_GET['pageSize'] : 20;
$fromId = isset($_GET['fromId']) ? $_GET['fromId'] : 0;
$offset = $pageIndex * $pageSize;

$link = MySQLUtil::getInstance()->connect();
$sql = "select `live_id`,`user_name`,`user_portrait`,`live_time`,`live_text`,`location`,`live_url`" .
    " from `live`,`user`" .
    " where `live`.user_id=`user`.user_id";
if ($fromId > 0) {
    $sql .= " and `live_id`>'$fromId'";
}
$sql .= " order by live_id desc limit $offset,$pageSize";

$result = mysqli_query($link, $sql);

$array = array();
while ($row = mysqli_fetch_array($result)) {
    $item = array(
        "liveId" => $row['live_id'],
        "userName" => $row['user_name'],
        "userPortrait" => $row['user_portrait'],
        "liveTime" => $row['live_time'],
        "liveText" => $row['live_text'],
        "location" => $row['location'],
        "liveUrl" => 'http://' . $_SERVER['HTTP_HOST'] . $row['live_url']
    );
    array_push($array, $item);
}

Response::show(0, "json", $array);