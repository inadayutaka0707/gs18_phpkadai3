<?php
    function connectDB(){
        try{
            $db = new PDO('mysql:dbname=gs_kadai;host=localhost;charset=utf8','root','root');
            return $db;
        }catch(PDOException $e){
            exit('DBConnectError:'.$e->getMessage());
        }
    }

    function sql_error($stmt){
        $error = $stmt->errorInfo();
        echo '何か問題があったので最初からお願いします';
        exit('<br><button><a href="index.html">登録画面へ戻る</a></button>');
    }

    function redirect($file_name){
        header('Location:'. $file_name);
        exit();
    }

    function usersave(){
        $sql = 'INSERT INTO gs_bm_table(id, name, email, sex, age, time, password, image, loginflag, checkflag)VALUES(NULL, :name, :email, :sex, :age, sysdate(), password, :image, loginflag, checkflag)';
        return $sql;
    }

    function tweetsave(){
        $sql = 'INSERT INTO gs_tweet_table(id, userid, name, email, tweet, date, image)VALUES(NULL, :userid, :name, :email, :tweet, sysdate(), :image)';
        return $sql;
    }

    function followsave(){
        $sql = 'INSERT INTO gs_follow_table(id, userid, followid)VALUES(NULL, :userid, :followid)';
        return $sql;
    }