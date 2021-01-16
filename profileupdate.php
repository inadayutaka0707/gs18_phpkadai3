<?php
    require_once('funcs.php');
    require_once('function.php');
    $db = connectDB();

    if(!isset($_FILES['image']['name']) || $_FILES['image']['name']==""){

        $name = $_POST['name'];
        $id = $_POST['id'];
        $email = $_POST['email'];

        $stmt1 = $db->prepare('UPDATE gs_tweet_table SET name=:name WHERE email=:email');
        $stmt1->bindValue(':name', h($name), PDO::PARAM_STR);
        $stmt1->bindValue(':email', h($email), PDO::PARAM_STR);

        $status1 = $stmt1->execute();

        if($status1==false){
            $error = $stmt1->errorInfo();
            exit("ErrorMessage:".$error[2]);
        }

        $stmt = $db->prepare('UPDATE gs_bm_table SET name=:name WHERE id=:id');
        $stmt->bindValue(':id', h($id), PDO::PARAM_INT);
        $stmt->bindValue(':name', h($name), PDO::PARAM_STR);

        $status = $stmt->execute();

        if($status==false){
            $error = $stmt->errorInfo();
            exit("ErrorMessage:".$error[2]);
        }else{
            header('Location: profile.php');
            exit;
        }
    }

    $img_name = $_FILES['image']['name'];
    $name = $_POST['name'];
    $id = $_POST['id'];
    $email = $_POST['email'];

    move_uploaded_file($_FILES['image']['tmp_name'], './img/'.$id.$img_name);

    $image = './img/'.$id.$img_name;

    if(file_exists('./img/'.$id.$id.$img_name)){
        unlink("test.png");
    }

    //登録ユーザーテーブルの更新処理
    $stmt = $db->prepare('UPDATE gs_bm_table SET image=:image, name=:name WHERE id=:id');
    $stmt->bindValue(':image', h($image), PDO::PARAM_STR);
    $stmt->bindValue(':name', h($name), PDO::PARAM_STR);
    $stmt->bindValue(':id', h($id), PDO::PARAM_INT);

    $status = $stmt->execute();

    if($status==false){
        $error = $stmt->errorInfo();
        exit("ErrorMessage:".$error[2]);
    }

    //tweetテーブルの更新処理
    $stmt1 = $db->prepare('UPDATE gs_tweet_table SET name=:name,image=:image WHERE email=:email');
    $stmt1->bindValue(':name', h($name), PDO::PARAM_STR);
    $stmt1->bindValue(':image', h($image), PDO::PARAM_STR);
    $stmt1->bindValue(':email', h($email), PDO::PARAM_STR);

    $status1 = $stmt1->execute();

    if($status1==false){
        $error = $stmt1->errorInfo();
        exit("ErrorMessage:".$error[2]);
    }
    
    //followテーブルの更新処理
    $stmt2 = $db->prepare('UPDATE gs_follow_table SET userid=:userid');
    $stmt2->bindValue(':userid', h($id), );

    $status2 = $stmt2->execute();
    
    if($status2==false){
        $error = $stmt->errorInfo();
        exit("ErrorMessage:".$error[2]);
    }else{
        header('Location: profile.php');
        exit;
    }