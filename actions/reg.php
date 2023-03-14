<?php

session_start();
require('../database/connect.php');
global $database;

$_SESSION['errors'] = [];

if(isset($_POST)) {
    $name = $_POST['name'];
    $login = $_POST['login'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $re_password = $_POST['re_password'];

    if(empty($name)
    || empty($login)
    || empty($email)
    || empty($password)
    || empty($re_password)) $_SESSION['errors'][] = "Вы не заполнили пустые строки";

    $user = $database->query("SELECT * FROM `users` WHERE `email`='$email' OR `login`='$login'")->fetch(PDO::FETCH_ASSOC);

    if($user === 0) {
        $user = [];
    }

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) $_SESSION['errors'][] = "Неккоректный формат почты";

    if(!empty($user)) $_SESSION['errors'][] = "Пользователь с таким логином или почтой уже существует";

    if($password !== $re_password) $_SESSION['errors'][] = "Пароли не совпадают";

    if(strlen($password) < 5) $_SESSION['errors'][] = "Пароль не должен быть меньше 6 символов"; 
    
    if(count($_SESSION['errors']) === 0) {
        $password = md5($password);

        $user = [
            "name"=>$name,
            "login"=>$login,
            "email"=>$email,
            "password"=>$password
        ];

        $userInsert = $database->prepare("INSERT INTO `users`
        (`name`, `login`, `email`, `password`)
        VALUES (:name,:login, :email, :password)");
        $userInsert->execute($user);
        $userInsert->fetch(PDO::FETCH_ASSOC);

        $userID = $database->lastInsertId();

        $_SESSION['USER'] = $userID;

        header('Location: ../?p=home');
    } else {
        foreach($_SESSION[errors] as $err) {
            echo $err;
            echo "<br>";
        }
    }
}
