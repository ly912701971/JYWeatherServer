<?php
require_once("MySQLUtil.php");
/**
 * 发布实景天气
 *
 * User: Yang
 * Date: 2019/5/26
 * Time: 14:59
 */
$openId = $_POST["openId"];
$liveTime = $_POST["liveTime"];
$liveText = $_POST["liveText"];
$location = $_POST["location"];
$image = $_FILES["liveImage"];

if ($image['error'] > 0) {
    $error = "上传失败了，";
    switch ($image['error']) {
        case 1:
            $error .= "大小超过了服务器设置的限制！";
            break;
        case 2:
            $error .= "文件大小超过了表单的限制！";
            break;
        case 3:
            $error .= "文件只有部分被上传！";
            break;
        case 4:
            $error .= "没有文件被上传!";
            break;
        case 6:
            $error .= "上传文件的临时目录不存在！";
            break;
        case 7:
            $error .= "写入失败!";
            break;
        default:
            $error .= "未知的错误！";
            break;
    }
    // 输出错误
    exit($error);
} else {
    // 文件后缀名
    $suffix = strrchr($image['name'], ".");

    // 存储路径
    $path = "./image/" . time() . $suffix;

    // 判断上传的文件是否为图片格式
    if (strtolower($suffix) == '.png' || strtolower($suffix) == '.jpg' || strtolower($suffix) == '.bmp' || strtolower($suffix) == '.gif') {
        // 将图片文件移到该目录下
        move_uploaded_file($image['tmp_name'], $path);
    }
}

$liveUrl = substr($path, 1);

// 存入数据库
$link = MySQLUtil::getInstance()->connect();
mysqli_query(
    $link,
    "insert into `live`(`user_id`,`live_time`,`live_text`,`location`,`live_url`)" .
    " values('$openId','$liveTime','$liveText','$location','$liveUrl')"
);
echo "Success";