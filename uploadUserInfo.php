<?php
require_once("MySQLUtil.php");
/**
 * Created by PhpStorm.
 * User: Yang
 * Date: 2019/5/26
 * Time: 0:02
 */
$postBody = file_get_contents("php://input");
$jsonObj = json_decode($postBody);

$link = MySQLUtil::getInstance()->connect();
mysqli_query(
    $link,
    "insert into `user` values('$jsonObj->openId','$jsonObj->userName','$jsonObj->portraitUrl')"
);