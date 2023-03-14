<?php

session_start();
require('../database/connect.php');
global $database;

$_SESSION['errors'] = [];

if(isset($_POST)) {
    $login = $_POST['login'];
    $password = $_POST['password'];
    $password = md5($password);

    if(empty($login)
    || empty($password)) $_SESSION['errors'][] = "Вы не заполнили пустые строки";

    $user = $database->query("SELECT * FROM `users` WHERE `login`='$login'")->fetch(PDO::FETCH_ASSOC);

    if($user === 0) {
        $user = [];
    }

    if(empty($user)) {
        $_SESSION['errors'][] = "Пользователя с таким логином не существует";
    } else {
        if($password !== $user['password']) $_SESSION['errors'][] = "Введён неверный пароль";
    }

    if(strlen($password) < 5) $_SESSION['errors'][] = "Пароль не должен быть меньше 6 символов"; 
    
    if(count($_SESSION['errors']) === 0) {
        $userID = $user['id'];

        $_SESSION['USER'] = $userID;

        header('Location: ../?p=home');
    } else {
        foreach($_SESSION[errors] as $err) {
            echo $err;
            echo "<br>";
        }
    }
}
