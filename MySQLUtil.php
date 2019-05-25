<?php

/**
 * 数据库工具
 *
 * Created by Administrator.
 * on 2019/1/11
 */
class MySQLUtil
{
    private static $instance;
    private static $connect;
    private $MYSQL_CONFIG = array(
        "host" => "127.0.0.1",
        "user" => "root",
        "password" => "youngsun",
        "database" => "jyweather"
    );

    private function __construct(){}

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new MySQLUtil();
        }
        return self::$instance;
    }

    public function connect()
    {
        if (!self::$connect) {
            self::$connect = mysqli_connect($this->MYSQL_CONFIG["host"],
                $this->MYSQL_CONFIG["user"],
                $this->MYSQL_CONFIG["password"],
                $this->MYSQL_CONFIG["database"]);
            if (!self::$connect) {
                die("mysql connect error" . mysqli_error(self::$connect));
            }
            mysqli_query(self::$connect, "set names UTF-8");
        }
        return self::$connect;
    }
}