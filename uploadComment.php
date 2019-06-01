<?php
require_once("MySQLUtil.php");
/**
 * 上传评论
 *
 * User: Yang
 * Date: 2019/6/1
 * Time: 16:09
 */
$postBody = file_get_contents("php://input");
$jsonObj = json_decode($postBody);

$link = MySQLUtil::getInstance()->connect();
mysqli_query(
    $link,
    "insert into `comment`(`user_id`,`live_id`,`comment_text`)" .
    " values('$jsonObj->openId','$jsonObj->liveId','$jsonObj->commentText')"
);