<?php
    session_start();
    require_once('funcs.php');
    require_once('function.php');

    if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
        echo "LOGINしてからきてちょ<br>";
        echo '<button><a href="index.html">もどる</a></button>';
        exit();
    }

    $id = $_SESSION["id"];
    $name = $_POST["name"];
    $page = $_SESSION["page"];

    $db = connectDB();

    $sql = "SELECT * FROM gs_bm_table WHERE id=:id";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':id', h($id), PDO::PARAM_STR);
    $status = $stmt->execute();

    if($status==false){
        $error = $stmt->errorInfo();
        echo '何か問題があったので最初からお願いします';
        exit('<br><button><a href="index.html">登録画面へ戻る</a></button>');
    }else{
        $row = $stmt->fetch();
    }

    if($name != ""){
        if($row["name"] != $name){
            $_SESSION["selectname"] = $name;
            header('Location: otherprofile.php');
        }
    }
?>

<!-- フォロー数を出す処理 -->
<?php
    $sql2 = 'SELECT * FROM gs_follow_table';
    $stmt2 = $db->prepare($sql2);
    $status2 = $stmt2->execute();

    
    $followcount = 0;
    $followercount = 0;
    $follow="";
    $follower="";
    if($status2==false){
        $error = $stmt->errorInfo();
        echo '何か問題があったので最初からお願いします';
        exit('<br><button><a href="index.html">登録画面へ戻る</a></button>');
    }else{
        while($result = $stmt2->fetch(PDO::FETCH_ASSOC)){
            if($result["userid"] == $row["id"]){
                $follow = '<input type="hidden" name="follow" value="'.$result["userid"].'">'.$follow;
                $followcount++;
            }
            if($result["followid"] == $row["id"]){
                $follower = '<input type="hidden" name="follower" value="'.$result["followid"].'">'.$follower;
                $followercount++;
            }
        }
    }
    
?>

<!-- 投稿一覧表示の処理 -->
<?php
    $stmt3 = $db->prepare('SELECT * FROM gs_tweet_table');
    $status3 = $stmt3->execute();

    $view="";
    $count=0;
    if($status3==false){
        echo '何か問題があったので最初からお願いします';
        exit('<br><button><a href="index.html">登録画面へ戻る</a></button>');
    }else{
        while($result3 = $stmt3->fetch(PDO::FETCH_ASSOC)){
            if($result3["name"] == $row["name"]){
                $view = '</div>'.$view;
                $view = '</form>'.$view;
                $view = '<a href="javascript:delete'.$count.'.submit()">'.'投稿削除'.'</a>'.$view;
                $view = '<input type="hidden" name="id" value="'.$result3["id"].'">'.$view;
                $view = '</div>' . $view;
                $view = '<p>'.h($result3["tweet"]).'</p>'.$view;
                $view = '<h4>'.h($result3["name"]).'<span>'.h($result3["date"]).'</span></h4>'.$view;
                $view = '<div class="mytweet">' . $view;
                $view = '<img src="'.h($result3["image"]).'" width="50px" height="50px">'.$view;
                $view = '<form name="delete'.$count.'" action="tweetdelete.php" method="post">'.$view;
                $view = '<div class="comment">'.$view;
                $count++;
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
    <link rel="stylesheet" href="css/profileStyle.css">
    <style>
        .followCount a{
            font-size: 25px;
        }
    </style>
</head>
<body class="profilebody">
    <form action="profileupdate.php" method="post" enctype="multipart/form-data">
        <label class="filelabel">
            <input type="file" id="image" name="image" accept="image/*" class="filehidden">
            <img id="preview" width="100px" height="100px">
            <img src="<?=$row['image']?>" id="mainimage" width="100px" height="100px">
        </label><br>
        <label><span>名前</span>
            <input type="text" name="name" value="<?=$row['name']?>"><br>
        </label>
        <input type="hidden" name="id" value="<?=$row['id']?>"><br>
        <input type="hidden" name="email" value="<?=$row['email']?>"><br>
        <input type="submit" value="保存">
    </form>
    <p class="followCount"><a href="javascript:followAll.submit()"><?=$followcount?></a>人フォロー中　　<a href="javascript:followAll1.submit()"><?=$followercount?></a>人のフォロワー</p>
    <form action="followAll.php" method="post" name="followAll">
        <?=$follow?>
        <?php
            $_SESSION["backpage"] = 'profile.php';
        ?>
    </form>
    <form action="followAll.php" method="post" name="followAll1">
        <?=$follower?>
        <?php
            $_SESSION["backpage"] = 'profile.php';
        ?>
    </form>
    <div class="mainContent">
        <?=nl2br($view)?>
    </div>
    <?='<a href="'.$page.'">戻る</a>'?>
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</body>
</html>
