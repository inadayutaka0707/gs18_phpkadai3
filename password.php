<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <?php
        require_once('funcs.php');
        require_once('function.php');
        
        $pdo = connectDB();

        $name = $_POST['name'];
        $email = $_POST['email'];
        $sex = $_POST['sex'];
        $age = $_POST['age'];
        $image = './img/php.jpg';
        //DB接続
        $db = connectDB();
        
        //SQL文を用意
        $sql = usersave();
        $stmt = $db->prepare($sql);
        
        //バインド変数仕様
        $stmt->bindValue(':name', h($name), PDO::PARAM_STR);
        $stmt->bindValue(':email', h($email), PDO::PARAM_STR);
        $stmt->bindValue(':sex', h($sex), PDO::PARAM_STR);
        $stmt->bindValue(':age', h($age), PDO::PARAM_STR);
        $stmt->bindValue(':image', h($image), PDO::PARAM_STR);

        //実行は以下
        $status = $stmt->execute();

        //重複確認
        if($status==false){
            $error = $stmt->errorInfo();
            echo ("登録エラー:名前かメールが既に登録されているため別の登録情報に変更してください");
            echo '<br><button><a href="resave.php">登録変更画面へ</a></button>';
            exit;
        }

        $sql = "SELECT * FROM gs_bm_table WHERE email = :email";
        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':email', h($email), PDO::PARAM_STR);
        $status = $stmt->execute();

        $view="";
        if($status==false){
            $error = $stmt->errorInfo();
            echo '何か問題があったので最初からお願いします';
            exit('<br><button><a href="index.html">登録画面へ戻る</a></button>');
        }else{
            $row = $stmt->fetch();
        }
    ?>

    <div class="setPassword">
        <fieldset class="setPassword2">
            <legend>パスワード設定</legend>
            <p>ようこそ「<?=$row["name"]?>」様。</p>
            <p>登録ありがとうございます。</p>
            <p>パスワード設定をお願いします。</p>
            <br>
            <form action="update.php" method="post">
                <label>password：<input type="password" name="password" id="password" required=""></label><br>
                <label>確認入力：<input type="password" name="password" id="passwordCheck"required=""></label><br>
                <input type="checkbox" id="passCheck">パスワード表示
                <input type="hidden" name="email" value="<?=$row["email"]?>"><br>
                <input type="submit" value="送信" onclick="return CheckPassword()">
            </form>
        </fieldset>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="js/index.js"></script>
</body>
</html>