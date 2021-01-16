<?php
    session_start();
    require_once('funcs.php');
    require_once('function.php');

    $name = $_POST["name"];
    $password = $_POST["password"];
    $logincheck = 1;

    $pdo = connectDB();

    $stmt1 = $pdo->prepare('SELECT * FROM gs_bm_table WHERE loginflag=:logincheck');
    $stmt1->bindValue(':logincheck', $logincheck, PDO::PARAM_INT);
    $status = $stmt1->execute();

    if($status==false){
        sql_error($stmt1);
    }else{
        $row1 = $stmt1->fetch();
    }

    $sql = "SELECT * FROM gs_bm_table WHERE name=:name";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':name', h($name), PDO::PARAM_STR);
    $login = $stmt->execute();

    if($login==false){
        header('Location: error.html');
        exit;
    }else{
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if($row["name"] != $name){
            echo '<p>登録されていません。</p>';
            echo '<a href="save.html">新規登録画面へ</a>';
            exit;
        }else if($row["password"]==""){
            echo '<p>パスワードが設定できていません。</p>';
            echo '<a href="password.php?email='.$row["email"].'">パスワード設定画面へ</a>';
            exit;
        }else if(password_verify($password,$row['password'])){
            $_SESSION["id"] = $row["id"];
            $_SESSION["chk_ssid"] = session_id();

            if($row1["name"] != $row["name"]){
                $loginflag = 0;
                $stmt1 = $pdo->prepare('UPDATE gs_bm_table SET loginflag=:loginflag WHERE name=:name');
                $stmt1->bindValue(':name', $row1["name"], PDO::PARAM_STR);
                $stmt1->bindValue(':loginflag', $loginflag, PDO::PARAM_INT);
                $status = $stmt1->execute();
        
                if($status==false){
                    sql_error($stmt1);
                }
            }

            $loginflag = 1;
            $stmt1 = $pdo->prepare('UPDATE gs_bm_table SET loginflag=:loginflag WHERE name=:name');
            $stmt1->bindValue(':name', $name, PDO::PARAM_STR);
            $stmt1->bindValue(':loginflag', $loginflag, PDO::PARAM_INT);
            $status = $stmt1->execute();

            if($status==false){
                sql_error($stmt1);
            }
            header('Location: tweet.php');
            exit;
        }else{
            echo '<p>パスワードが一致していません。</p>';
            echo '<a href="index.html">ログイン画面へ</a>';
            exit;
        }
    }