<?php
require_once("MySQLUtil.php");
/**
 * 上传点赞
 *
 * User: Yang
 * Date: 2019/6/1
 * Time: 18:30
 */
$postBody = file_get_contents("php://input");
$jsonObj = json_decode($postBody);

$openId = $jsonObj->openId;
$liveId = $jsonObj->liveId;

$link = MySQLUtil::getInstance()->connect();
$row = mysqli_query($link, "select * from `like` where `user_id`='$openId' and `live_id`='$liveId'");
if (mysqli_num_rows($row) < 1) {
    $sql = "insert into `like` values('$openId','$liveId')";
} else {
    $sql = "delete from `like` where `user_id`='$openId' and `live_id`='$liveId'";
}

mysqli_query($link, $sql);