<?php

session_start();
require('../database/connect.php');
global $database;

$_SESSION['errors'] = [];

if(isset($_POST)) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $category = $_POST['category'];

  

    $image_name = $_FILES['image_path']['name'];
    $tmp_name = $_FILES['image_path']['tmp-name'];
    $time = time();

    $image_load = "../assets/images/news/".'load-'.$time.$image_name;
    $image_path = "assets/images/news/".'load-'.$time.$image_name;

    // var_dump($name, $description, $category, $image_name);

    if(empty($image_name)
    || empty($name)
    || empty($description)
    || empty($category)) $_SESSION['errors'][] = "Вы не заполнили пустые строки";

    if(strlen($name) < 9) $_SESSION['errors'][] = "Заголовок не должен быть меньше 10 символов"; 
    
    if(count($_SESSION['errors']) === 0) {
        move_uploaded_file($image_load, $tmp_name);

        $item = [
            "name"=>$name,
            "description"=>$description,
            "category"=>$category,
            "author"=>$_SESSION['USER'],
            "image_path"=>$image_path
        ];

        var_dump($item);

        $itemInsert = $database->prepare("INSERT INTO `items`
        (`name`, `description`, `category`, `author`, `image_path`)
        VALUES (:name, :description, :category, :author, :image_path)");
        $itemInsert->execute($item);
        $itemInsert->fetch(PDO::FETCH_ASSOC);

        header('Location: ../?p=profile');
    } else {
        foreach($_SESSION[errors] as $err) {
            echo $err;
            echo "<br>";
        }
    }
}
