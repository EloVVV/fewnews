<?php
    session_start();
    require('database/connect.php');
    global $database;

    if(isset($_SESSION['USER'])) {
        $user = $database->query("SELECT * FROM `users` WHERE `id`={$_SESSION['USER']}")->fetch(PDO::FETCH_ASSOC);
        $userID = $user['id'];
        // global $userID;
    }

    if($_REQUEST['do'] === 'exit') {
        session_unset();
        header('Location: ?p=home');
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>FewNews</title>
</head>
<body>
    <?php require('components/header.php') ?>
    <main>
        <?php
            if(isset($_GET['p'])) {
                if($_GET['p'] === 'home') require('pages/homePage.php');
                if($_GET['p'] === 'profile') require('pages/profilePage.php');
                if($_GET['p'] === 'single') require('pages/singlePage.php');
                if($_GET['p'] === 'admin') require('pages/adminPage.php');

                if($_GET['p'] === 'reg') require('pages/regPage.php');
                if($_GET['p'] === 'auth') require('pages/authPage.php');

                if($_GET['p'] === 'createNews') require('pages/createPage.php');

                if($_GET['p'] === 'error') require('pages/errorPage.php');
            } else {
                require('pages/homePage.php');
            }
        ?>
    </main>
    <?php require('components/footer.php') ?>
</body>
</html>