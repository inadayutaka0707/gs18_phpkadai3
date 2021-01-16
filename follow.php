<?php
    session_start();
    require_once('funcs.php');
    require_once('function.php');

    $userid = $_POST["userid"];
    $followid = $_POST["followid"];

    $db = connectDB();


    $sql = followsave();
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':userid', h($userid), PDO::PARAM_STR);
    $stmt->bindValue(':followid', h($followid), PDO::PARAM_STR);
    $result = $stmt->execute();

    if($result==false){
        sql_error($stmt);
    }else{
        redirect('otherprofile.php');
    }