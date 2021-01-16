<?php
    require_once('funcs.php');
    require_once('function.php');

    $userid = $_POST["userid"];
    $name = $_POST["name"];
    $email = $_POST["email"];
    $tweet = $_POST["tweet"];
    $image = $_POST["image"];

    $db = connectDB();

    $sql = tweetsave();
    $stmt = $db->prepare($sql);

    $stmt->bindValue(':userid', h($userid), PDO::PARAM_STR);
    $stmt->bindValue(':name', h($name), PDO::PARAM_STR);
    $stmt->bindValue(':email', h($email), PDO::PARAM_STR);
    $stmt->bindValue(':tweet', h($tweet), PDO::PARAM_STR);
    $stmt->bindValue(':image', h($image), PDO::PARAM_STR);

    $status = $stmt->execute();

    if($status==false){
        echo '登録できませんでした';
        echo 'またお願いします';
        echo '<button><a href="tweet.php">戻る</a></button>';
        exit;
    }else{
        header('Location: tweet.php');
        exit;
    }
?>