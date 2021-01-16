<?php
    session_start();
    require_once('funcs.php');
    require_once('function.php');

    $db = connectDB();
    $userid = $_POST["follow"];
    $followid = $_POST["follower"];
    $page = $_SESSION["backpage"];

    //フォロー一覧か、フォロワー一覧のどちらを選択したかの処理
    if($userid != ""){
        $stmt = $db->prepare('SELECT * FROM gs_bm_table WHERE id=:id ;');
        $stmt->bindValue(':id', h($userid), PDO::PARAM_INT);
        $status = $stmt->execute();

        if($status==false){
            sql_error($stmt);
        }else{
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }else{
        $stmt = $db->prepare('SELECT * FROM gs_bm_table WHERE id=:id ;');
        $stmt->bindValue(':id', h($followid), PDO::PARAM_INT);
        $status = $stmt->execute();

        if($status==false){
            sql_error($stmt);
        }else{
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }
    }

    //フォロー、フォロワー一覧を表示する処理
    $stmt1 = $db->prepare('SELECT * FROM gs_follow_table ;');
    $status1 = $stmt1->execute();

    if($status1==false){
        sql_error($stmt1);
    }

    $view="";
    $count=0;
    while($result1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
        if($userid != ""){
            if($result1["userid"]==$row["id"]){
                $stmt2 = $db->prepare('SELECT * FROM gs_bm_table WHERE id=:id ;');
                $stmt2->bindValue(':id', $result1["followid"], PDO::PARAM_INT);

                $status2 = $stmt2->execute();

                if($status2==false){
                    sql_error($stmt2);
                }else{
                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                }

                $view = '</div>'.$view;
                $view = '</form>'.$view;
                $view = '<p>'.$row2["name"].'</p>'.$view;
                $view = '<input type="hidden" name="name" value="'.$row2["name"].'">'.$view;
                $view = '<img src="'.h($row2["image"]).'" width="50px" height="50px">'.$view;
                $view = '<form action="profile.php" method="post">'.$view;
                $view = '<div class="follow">'.$view;
            }
        }else{
            if($result1["followid"]==$row["id"]){
                $stmt2 = $db->prepare('SELECT * FROM gs_bm_table WHERE id=:id ;');
                $stmt2->bindValue(':id', $result1["userid"], PDO::PARAM_INT);

                $status2 = $stmt2->execute();

                if($status2==false){
                    sql_error($stmt2);
                }else{
                    $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
                }

                $view = '</div>'.$view;
                $view = '</form>'.$view;
                $view = '<p>'.$row2["name"].'</p>'.$view;
                $view = '<input type="hidden" name="name" value="'.$row2["name"].'">'.$view;
                $view = '<img src="'.h($row2["image"]).'" width="50px" height="50px">'.$view;
                $view = '<form action="profile.php" method="post">'.$view;
                $view = '<div class="follow">'.$view;
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/profileStyle.css" rel="stylesheet">
</head>
<body>
    <?php
        if($userid != ""){
            echo '<h1>フォロー一覧</h1>';
        }else{
            echo '<h1>フォロワー一覧</h1>';
        }
    ?>
    
    <div class="followContent">
        <?=nl2br($view)?>
    </div>
    <div class="backContent">
        <?='<a href="'.$page.'">戻る</a>'?>
    </div>
</body>
</html>