<?php
    session_start();
    require_once('funcs.php');
    require_once('function.php');

    if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
        echo "LOGINしてからきてちょ<br>";
        echo '<button><a href="index.html">もどる</a></button>';
        exit();
    }

    $followid = $_SESSION["selectname"];
    $userid = $_SESSION['id'];
    $page = $_SESSION["page"];
    $db = connectDB();

    //選択したユーザーの処理
    $sql = "SELECT * FROM gs_bm_table WHERE name=:name";
    $stmt = $db->prepare($sql);
    $stmt->bindValue(':name', h($followid), PDO::PARAM_STR);
    $status = $stmt->execute();

    $view="";
    if($status==false){
        $error = $stmt->errorInfo();
        echo '何か問題があったので最初からお願いします';
        exit('<br><button><a href="index.html">登録画面へ戻る</a></button>');
    }else{
        $row = $stmt->fetch();
    }

    //ログインしているユーザーの処理
    $sql2 = "SELECT * FROM gs_bm_table WHERE id=:id";
    $stmt2 = $db->prepare($sql2);
    $stmt2->bindValue(':id', h($userid), PDO::PARAM_STR);
    $status2 = $stmt2->execute();

    $view2="";
    if($status2==false){
        $error = $stmt2->errorInfo();
        echo '何か問題があったので最初からお願いします';
        exit('<br><button><a href="index.html">登録画面へ戻る</a></button>');
    }else{
        $row2 = $stmt2->fetch();
    }

    $serch = $db->prepare('SELECT * FROM gs_follow_table');
    $status3 = $serch->execute();

    if($status3==false){
        $error = $serch->errorInfo();
        echo '何か問題があったので最初からお願いします';
        exit('<br><button><a href="index.html">登録画面へ戻る</a></button>');
    }else{
        // $row3 = $serch->fetch();
        // $count=0;
        while($view = $serch->fetch(PDO::FETCH_ASSOC)){
            if($view["userid"] == $row2["id"]){
                if($view["followid"]==$row["id"]){
                    $row3userid = $view["userid"];
                    $row3followid = $view["followid"];
                    // echo $view["userid"]."　";
                    // echo $view["followid"]."<br>";
                }
            }
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
                // $view = $result3["name"].$view;
                // $view = $result3["tweet"].$view;

                $view = '</div>'.$view;
                $view = '</form>'.$view;
                $view = '<a href="javascript:delete'.$count.'.submit()">'.''.'</a>'.$view;
                $view = '</div>' . $view;
                $view = '<p>'.h($result3["tweet"]).'</p>'.$view;
                $view = '<h4>'.h($result3["name"]).'<span>'.h($result3["date"]).'</span></h4>'.$view;
                $view = '<div class="mytweet">' . $view;
                $view = '<img src="'.h($result3["image"]).'" width="50px" height="50px">'.$view;
                $view = '<div class="comment">'.$view;
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
    <form action="follow.php" method="post" name="follow">
        <label class="filelabel">
            <img src="<?=$row['image']?>" width="100px" height="100px">
            <!-- <input type="file" name="image" accept="image/*" class="filehidden"> -->
        </label><br>
        <label>
            <p><?=$row['name']?></p>
        </label>
        <input type="hidden" name="userid" value="<?=$row2['id']?>">
        <input type="hidden" name="followid" value="<?=$row['id']?>">
    </form>
    <form action="followdelete.php" method="post" name="delete1">
        <input type="hidden" name="userid" value="<?=$row2['id']?>">
        <input type="hidden" name="followid" value="<?=$row['id']?>">
    </form>
        <?php
            if($row3userid==$row2["id"]){
                if($row3followid==$row["id"]){
                    echo '<button><a href="javascript:delete1.submit()">ふぉろー介助</a></button><br>';
                }
            }else{
                echo '<button><a href="javascript:follow.submit()">ふぉろー</a></button><br>';
            }
        ?>
    <p class="followCount"><a href="javascript:followAll.submit()"><?=$followcount?></a>人フォロー中　　<a href="javascript:followAll1.submit()"><?=$followercount?></a>人のフォロワー</p>
    <form action="followAll.php" method="post" name="followAll">
        <?=$follow?>
        <?php
            $_SESSION["backpage"] = 'otherprofile.php';
        ?>
    </form>
    <form action="followAll.php" method="post" name="followAll1">
        <?=$follower?>
        <?php
            $_SESSION["backpage"] = 'otherprofile.php';
        ?>
    </form>
    <div class="otherContent">
        <?=nl2br($view)?>
    </div>
    <div class="back">
        <?='<a href="'.$page.'">戻る</a>'?>
    </div>
</body>
</html>