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

        $email = $_GET["email"];
        
        $pdo = connectDB();

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
            <legend>登録内容変更</legend>
            <form action="form.php" method="post">
                <input type="text" name="name" id="name" placeholder="ニックネームをかいてね" required>
                <br>
                <input type="email" name="email" id="email" placeholder="メアドをかいてね" required>
                <div class="sextype">
                    <p>性別<br>
                        <input type="radio" name="sex" value="男性" checked>男性
                        <input type="radio" name="sex" value="女性">女性
                    </p>
                </div>
                <select name="age">
                    <script>
                    var i;
                    for(i=10; i<100; i+=1){
                    document.write('<option value="'+i+'">'+i+'歳</option>');
                    }
                    </script>
                </select>
                <br>
                <div class="button">
                    <input type="submit" value="登録">
                </div>
            </form>
        </fieldset>
    </div>
    <script src="https://code.jquery.com/jquery-3.2.1.js" integrity="sha256-DZAnKJ/6XZ9si04Hgrsxu/8s717jcIzLy3oi35EouyE=" crossorigin="anonymous"></script>
    <script src="js/index.js"></script>
</body>
</html>