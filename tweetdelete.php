<?php
    session_start();
    require_once('funcs.php');
    require_once('function.php');

    $db = connectDB();

    $id = $_POST["id"];

    $stmt = $db->prepare('DELETE FROM gs_tweet_table WHERE id=:id ;');
    $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    $status = $stmt->execute();

    if($status==false){
        $error = $stmt->errorInfo();
        echo '何か問題があったので最初からお願いします';
        exit('<br><button><a href="index.html">登録画面へ戻る</a></button>');
    }else{
        header('Location: profile.php');
        exit;
    }