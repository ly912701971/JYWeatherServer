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
$postBody = file_get_contents("php://input");
$jsonObj = json_decode($postBody);

$pageIndex = $jsonObj->pageIndex;
$pageSize = $jsonObj->pageSize;
$fromId = $jsonObj->fromId;
$openId = $jsonObj->openId;
//$pageIndex = 0;
//$pageSize = 20;
//$fromId = 0;
//$openId = "AABEEFECC36C8252A2488598EA6F5826";
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
$liveArray = array();
while ($liveRow = mysqli_fetch_array($result)) {
    $liveId = $liveRow['live_id'];
    $likeNum = mysqli_num_rows(mysqli_query($link, "select * from `like` where `live_id`='$liveId'"));
    $hasLiked = mysqli_num_rows(mysqli_query($link, "select * from `like` where `user_id`='$openId' and `live_id`='$liveId'"));
    $liveItem = array(
        "liveId" => $liveId,
        "userName" => $liveRow['user_name'],
        "userPortrait" => $liveRow['user_portrait'],
        "liveTime" => $liveRow['live_time'],
        "liveText" => $liveRow['live_text'],
        "location" => $liveRow['location'],
        "liveUrl" => 'http://' . $_SERVER['HTTP_HOST'] . $liveRow['live_url'],
        "likeNum" => $likeNum,
        "hasLiked" => $hasLiked
    );

    $comment = mysqli_query(
        $link,
        "select `user_name`,`comment_text` from `comment`,`user`" .
        " where `comment`.`live_id`='$liveId' and `comment`.`user_id`=`user`.`user_id`");
    $commentArray = array();
    while ($commentRow = mysqli_fetch_array($comment)) {
        $commentItem = array(
            "userName" => $commentRow['user_name'],
            "commentText" => $commentRow['comment_text']
        );
        array_push($commentArray, $commentItem);
    }
    $liveItem['commentArray'] = $commentArray;
    array_push($liveArray, $liveItem);
}

Response::show(0, "json", $liveArray);