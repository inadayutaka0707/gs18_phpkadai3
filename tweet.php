<!-- ログイン処理 -->
<?php
session_start();
if(!isset($_SESSION["chk_ssid"]) || $_SESSION["chk_ssid"]!=session_id()){
    echo "LOGINしてからきてちょ<br>";
    echo '<button><a href="index.html">もどる</a></button>';
    exit();
}

    require_once('funcs.php');
    require_once('function.php');

    $id = $_SESSION["id"];

    $user = connectDB();

    $sql = "SELECT * FROM gs_bm_table WHERE id=:id";
    $stmt = $user->prepare($sql);
    $stmt->bindValue(':id', h($id), PDO::PARAM_STR);
    $login = $stmt->execute();

    $view="";
    if($login==false){
        $error = $stmt->errorInfo();
        echo '何か問題があったので最初からお願いします';
        exit('<br><button><a href="index.html">登録画面へ戻る</a></button>');
    }else{
        $row = $stmt->fetch();
        $_SESSION["name"] = $row["name"];
    }
?>

<!-- tweet処理 -->
<?php
    $comment = $user->prepare("SELECT * FROM gs_tweet_table");
    $allComment = $comment->execute();

    $view="";
    $count=0;
    if($allComment==false){
        echo "<p>コメントを表示できません</p>";
        echo '<p><a href="index.html">最初からやり直してください</a></p>';
        exit;
    }else{
        while($result = $comment->fetch(PDO::FETCH_ASSOC)){
            $view = '</div>'.$view;
            $view = '</form>'.$view;
            $view = '<p><span>'.h($result["date"]).'</span></p>'.$view;
            $view = '<p>'.h($result["tweet"]).'</p>'.$view;
            $view = '<input type="hidden" name="userid" value="'.h($result["userid"]).'">'.$view;
            $view = '<input type="hidden" name="name" value="'.h($result["name"]).'">'.$view;
            $view = '<a href="javascript:profile'.$count.'.submit()" class="othername">'.h($result["name"]).'</a>'.$view;
            $view = '<a href="javascript:profile'.$count.'.submit()"><img src="'.h($result["image"]).'" width="50px" height="50px"></a>'.$view;
            $view = '<form name="profile'.$count.'" action="profile.php" method="post">'.$view;
            $view = '<div class="comment">'.$view;
            $count++;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <link href="css/style.css" rel="stylesheet">
</head>
<body onload="init();">
    <section class="sectionleft">
        <div class="leftside">
            <form name="profilesetting" action="profile.php" method="post">
                <a href="javascript:profilesetting.submit()">
                    <i class="bi bi-person-circle"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                    <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"/>
                    <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8zm8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1z"/>
                    </svg></i>
                    <?php
                        $_SESSION["page"] = 'tweet.php';
                    ?>
                </a>
                <input type="hidden" name="name" value="<?=$row["name"]?>">
            </form>
        </div>
    </section>
    <section class="sectioncenter">
        <dev class="tweetbody">
            <div class="tweet">
                <div class="tweettitle">
                    <h1>HOME</h1>
                </div>
                <form name="profile" action="profile.php" method="post">
                    <div class="formleft">
                        <a href="javascript:profile.submit()"><img src="<?=$row['image']?>"></a>
                        <input type="hidden" name="name" value="<?=$row["name"]?>">
                    </div>
                </form>
                <form action="tweetsave.php" method="post">
                    <div class="formcenter">
                        <textarea name="tweet" cols="44" rows="1" wrap="hard" id="text" maxlength="200" placeholder="あなたの気持ちをどうぞ"></textarea>
                    </div>
                    <input type="hidden" name="userid" value="<?=$row["id"]?>">
                    <input type="hidden" name="name" value="<?=$row["name"]?>">
                    <input type="hidden" name="image" value="<?=$row["image"]?>">
                    <input type="hidden" name="email" value="<?=$row["email"]?>">
                    <div class="formright">
                        <input type="submit" value="投稿">
                    </div>
                </form>
            </div>
            <div class="mainContent">
                <?=nl2br($view)?>
            </div>
        </dev>
    </section>
    <section class="sectionright">
        <div class="rightside">
            <a href="logout.php">
                <i class="bi bi-door-closed"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-door-closed" viewBox="0 0 16 16">
                <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2zm1 13h8V2H4v13z"/>
                <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0z"/>
                </svg></i>
            </a>
        </div>
    </section>
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</body>
</html>