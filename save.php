<?php
    require_once('funcs.php');
    require_once('function.php');
    
    $name = $_POST['name'];
    $email = $_POST['email'];
    $sex = $_POST['sex'];
    $age = $_POST['age'];
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

    //実行は以下
    $status = $stmt->execute();

    $view="";
    if($status==false){
        $error = $stmt->errorInfo();
        echo ("登録エラー:".$error[2]."が既に登録されているため別の登録情報に変更してください");
        echo '<br><button><a href="save.html">登録画面へ戻る</a></button>';
        exit;
    }else{
        $view .= '<tr>'.'<th>'.'名前'.'</th>'.'<td>'.$name.'</td>'.'</tr>';
        $view .= '<tr>'.'<th>'.'メール'.'</th>'.'<td>'.$email.'</td>'.'</tr>';
        $view .= '<tr>'.'<th>'.'性別'.'</th>'.'<td>'.$sex.'</td>'.'</tr>';
        $view .= '<tr>'.'<th>'.'年齢'.'</th>'.'<td>'.$age.'</td>'.'</tr>';
    }

    //データ登録語の処理
    // if($status==false){
    //     $error = $stmt->errorInfo();
    //     exit("ErrorMessage:".$error[2]);
    // }else{
    //     header('Location:save.php');
    //     exit;
    // }
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>結果</title>
        <link href="css/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="formMain">
            <fieldset>
            <legend>登録内容</legend>
                <div class="check">
                    <table>
                        <?=$view?>
                    </table>
                </div>
            </fieldset>
            <p>登録内容をご確認ください。</p>
            <br>
        </div>
        <div class="formSab2">
            <div class="formSab">
                <p>登録内容に問題がない場合</p>
                <p>↓</p>
                <?php
                    echo '<a href="password.php?email='.$email.'">'.'パスワード設定へ進む'.'</a>';
                ?>
            </div>
            <div class="formSab">
                <p>登録内容に問題がある場合</p>
                <p>↓</p>
                <?php
                    echo '<a href="resave.php?email='.$email.'">'.'登録内容変更へ'.'</a>';
                ?>
            </div>
        </div>
    </body>
</html>