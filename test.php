<?php

// function convertNewline($string, $to="%改行%") {
//     return str_replace("/\r\n|\r|\n/", $to, $string);
// }
// $text = '{"ops":[{"attributes":{"color":"white"},"insert":" くれなゐの二尺伸びたるふる "},{"insert":"\n"}]}';
// echo nl2br($text);
// echo str_replace('"\n"', '"\\\n"',$text);
// echo convertNewline($text, "\n");

//require
require_once 'vendor/autoload.php';
//for .env
// use Dotenv\Dotenv;
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load(); //.envが無いとエラーになる

$name = $_ENV['DB_DATABASE'];
echo $name;
// echo __DIR__;
?>

