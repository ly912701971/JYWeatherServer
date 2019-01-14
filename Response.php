<?php
/**
 * Created by Administrator.
 * on 2019/1/14
 */

class Response
{
    private static $STATUS_ARRAY = array(
        0 => "ok",
        1 => "invalid key",
        2 => "invalid key type",
        3 => "invalid param",
        4 => "bad bind",
        5 => "no data for this location",
        6 => "no more requests",
        7 => "no balance",
        8 => "too fast",
        9 => "dead",
        10 => "permission denied",
        11 => "sign error",
        12 => "unknown location"
    );

    public static function show($status, $format, $value = '')
    {
        $code = array_search($status, self::$STATUS_ARRAY);
        $result = array(
            'code' => $code,
            'message' => $status,
            'data' => $value);
        if ($format === "json") {
            self::jsonEncode($result);
        } else if ($format === "xml") {
            self::xmlEncode($result);
        }

    }

    private static function jsonEncode($array)
    {
        echo json_encode($array, JSON_UNESCAPED_UNICODE);
    }

    private static function xmlEncode($array)
    {
        header("Content-Type:text/xml");
        $xml = "<?xml version='1.0' encoding='UTF-8'?>\n";
        $xml .= "<root>\n";
        $xml .= self::arrayToXml($array);
        $xml .= "</root>";
        echo $xml;
    }

    private static function arrayToXml($array)
    {
        $xml = $attr = "";
        foreach ($array as $key => $value) {
            // 健值为数字，转换成<item id="{$key}"></item>
            if (is_numeric($key)) {
                $attr = " id='{$key}'";
                $key = "item";
            }
            $xml .= "<{$key}{$attr}>";
            $xml .= is_array($value) ? self::arrayToXml($value) : $value;
            $xml .= "</{$key}>\n";
        }
        return $xml;
    }
}