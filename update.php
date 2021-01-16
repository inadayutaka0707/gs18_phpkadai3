<?php
    require_once('funcs.php');
    require_once('function.php');

    $email = $_POST["email"];
    $password = $_POST["password"];

    $db = connectDB();

    $stmt = $db->prepare('UPDATE gs_bm_table SET password=:password WHERE email=:email');
    $stmt->bindValue(':email', h($email), PDO::PARAM_STR);
    $stmt->bindValue(':password', h($password), PDO::PARAM_STR);

    $status = $stmt->execute(array(':email'=>$email,':password'=>password_hash($password, PASSWORD_DEFAULT)));

    if($status==false){
        $error = $stmt->errorInfo();
        exit("ErrorMessage:".$error[2]);
    }else{
        if($password==""){
            header('Location: form.php');
        }else{
            header('Location: index.html');
            exit;
        }
    }