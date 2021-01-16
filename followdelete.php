<?php
    session_start();
    require_once('funcs.php');
    require_once('function.php');

    $userid = $_SESSION["id"]; //ログインしているユーザー
    $followid = $_POST["followid"]; //対象のユーザー

    $db = connectDB();
    $stmt = $db->prepare('SELECT * FROM gs_follow_table');
    $status = $stmt->execute();

    if($status==false){
        sql_error($stmt);
    }else{
        while($row = $stmt->fetch(PDO::PARAM_STR)){
            if($userid == $row["userid"]){
                if($followid == $row["followid"]){
                    $sql = 'DELETE FROM gs_follow_table WHERE id=:id';
                    $stmt2 = $db->prepare($sql);
                    $stmt2->bindValue(':id', h($row["id"]), PDO::PARAM_INT);
                    $status2 = $stmt2->execute();

                    if($status2==false){
                        sql_error($stmt2);
                    }else{
                        redirect('otherprofile.php');
                        exit;
                    }
                }
            }
        }
    }



