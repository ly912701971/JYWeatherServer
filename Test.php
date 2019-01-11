<?php
require_once("NetworkInterface.php");
require_once("MySQLUtil.php");

$json = NetworkInterface::requestWeather("广州");
$jsonDec = json_decode($json);
print_r($jsonDec->HeWeather6[0]->update->loc);