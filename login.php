<?php
    session_start();

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    if ($email == '' || $email == null){
        echo "<script>alert('Oie, acho que você errou kk'); window.location.href='index.php';</script>";
        exit;
    }else{
        $_SESSION['email'] = $email;
    }

    if ($senha != '' && $senha != null){
        header("Location: home.php");
        exit;
    }else { 
        echo "<script>alert('Oie, acho que você errou kk'); window.location.href='index.php';</script>";
    }
?>