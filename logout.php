<?php
session_start();
$_SESSION["chk_ssid"] = "";

if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
    header('Location: index.html');
    exit();
}else{
    echo 'ログアウト失敗したよ';
    echo '<button><a href="tweet.php">もどる</a></button>';
}
?>