<?php
require_once("MySQLUtil.php");
/**
 * 上传用户信息
 *
 * User: Yang
 * Date: 2019/5/26
 * Time: 0:02
 */
$postBody = file_get_contents("php://input");
$jsonObj = json_decode($postBody);

$link = MySQLUtil::getInstance()->connect();
$row = mysqli_query($link, "select * from `user` where `user_id`='$jsonObj->openId'");
if (mysqli_num_rows($row) < 1) {
    $sql = "insert into `user` values('$jsonObj->openId','$jsonObj->userName','$jsonObj->portraitUrl')";
} else {
    $sql = "update `user` set `user_name`='$jsonObj->userName',`user_portrait`='$jsonObj->portraitUrl' where `user_id`='$jsonObj->openId'";
}

mysqli_query($link, $sql);