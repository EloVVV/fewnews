<?php
    session_start();
    require('database/connect.php');
    global $database;

    if(!isset($_SESSION['USER'])) {
        echo '<script>document.location.href="?p=error"</script>';
    }
?>

<?php
    if(isset($_GET['itemStatus'])) {
        if(isset($_GET['publicate'])) {
            $itemID = $_GET['itemID'];
            $database->query("UPDATE `items` SET `status`='published' WHERE `id`='$itemID'")->fetch(PDO::FETCH_ASSOC);
            echo '<script>document.location.href="?p=admin"</script>';
        }
        if(isset($_GET['block'])) {
            $itemID = $_GET['itemID'];
            $database->query("UPDATE `items` SET `status`='blocked' WHERE `id`='$itemID'")->fetch(PDO::FETCH_ASSOC);
            // header('Location: ?p=admin');
            echo '<script>document.location.href="?p=admin"</script>';
        }
        if(isset($_GET['unpublicate'])) {
            $itemID = $_GET['itemID'];
            $database->query("UPDATE `items` SET `status`='inprocess' WHERE `id`='$itemID'")->fetch(PDO::FETCH_ASSOC);
            // header('Location: ?p=admin');
            echo '<script>document.location.href="?p=admin"</script>';
        }
    }
?>

<?php
    if($user['role'] === 'admin') {
        ?>
            <section class="profile">
                <div class="profile_container container">
                    <div class="user-info">
                        <p class="user-name">
                            <?php echo $user['name']?>
                        </p>
                        <p class="user-email">
                            <?php echo $user['email']?>
                        </p>
                    </div>
                    <div class="user-actions">
                        <!-- <a href="?p=createNews" class="button-style">Предложить новость</a> -->
                    </div>
                </div>
                <div class="admin_container container">
                    <div class="news-header">
                        <h1>Предложенные новости</h1>
                        <div class="filter">
                            <a href="?p=admin" class="link-style">Все новости</a>
                            <?php
                                $categories = $database->query("SELECT * FROM `item_categories`")->fetchAll(PDO::FETCH_ASSOC);

                                foreach($categories as $category) {
                                    echo '<a href="?p=admin&category='.$category['id'].'" class="link-style">'.$category['name'].'</a>';
                                }
                            ?>
                            
                            
                        </div>
                    </div>
                    <div class="news-content">
                        <?php
                            if(isset($_GET['category'])) {
                                $categoryID = $_GET['category'];
            
                                if(!empty($categoryID)) {
                                    $sqlCategory = "AND `category`='$categoryID'";
                                } else {
                                    $sqlCategory = "";
                                }
                            } else {
                                $sqlCategory = "";
                            }

                            $getItems = $database->query("SELECT * FROM `items` WHERE `status`='inprocess' $sqlCategory")->fetchAll(PDO::FETCH_ASSOC);

                            if(!empty($getItems)) {
                                foreach($getItems as $item) {
                                    $category = $database->query("SELECT * FROM `item_categories` WHERE `id`={$item['category']}")->fetch(PDO::FETCH_ASSOC);

                                    echo '
                                    <div class="item">
                                        <a href="?p=single&id='.$item['id'].'" class="item_image-box image-box">
                                            <img src="'.$item['image_path'].'" alt="" class="item-img">
                                        </a>
                                        <div class="item_text-content">
                                            <div class="item_headline">
                                                <p class="item-category">'.$category['name'].'</p>
                                                <p class="item-title">'.$item['name'].'</p>
                                            </div>
                                            <p class="item-description">
                                                '.$item['description'].'
                                            </p>
                                            <div class="item-actions">
                                                <a href="?p=admin&itemStatus&publicate&itemID='.$item['id'].'" class="link-style">Опубликовать</a>
                                                <a href="?p=admin&itemStatus&block&itemID='.$item['id'].'" class="link-style">Заблокировать</a>
                                            </div>
                                        </div>
                                    </div>
                                    ';
                                }
                            } else {
                                echo '<h2>Видимо, их ещё нет</h2>';
                            }
                        ?>
                    </div>
                   
                </div>
                <div class="all-news_container container">
                    <div class="news-header">
                            <h1>Все новости</h1>
                            <div class="filter">
                                <a href="?p=admin" class="link-style">Все новости</a>
                                <?php
                                    $categories = $database->query("SELECT * FROM `item_categories`")->fetchAll(PDO::FETCH_ASSOC);

                                    foreach($categories as $category) {
                                        echo '<a href="?p=admin&category='.$category['id'].'" class="link-style">'.$category['name'].'</a>';
                                    }
                                ?>
                                
                                
                            </div>
                        </div>
                        <div class="news-content">
                            <?php
                                if(isset($_GET['category'])) {
                                    $categoryID = $_GET['category'];
                
                                    if(!empty($categoryID)) {
                                        $sqlCategory = "WHERE `category`='$categoryID'";
                                    } else {
                                        $sqlCategory = "";
                                    }
                                } else {
                                    $sqlCategory = "";
                                }

                                $getItems = $database->query("SELECT * FROM `items` $sqlCategory")->fetchAll(PDO::FETCH_ASSOC);

                                if(!empty($getItems)) {
                                    foreach($getItems as $item) {
                                        $category = $database->query("SELECT * FROM `item_categories` WHERE `id`={$item['category']}")->fetch(PDO::FETCH_ASSOC);

                                        echo '
                                        <div class="item">
                                            <a href="?p=single&id='.$item['id'].'" class="item_image-box image-box">
                                                <img src="'.$item['image_path'].'" alt="" class="item-img">
                                            </a>
                                            <div class="item_text-content">
                                                <p>Статус: '.$item['status'].'</p>
                                                <div class="item_headline">
                                                    <p class="item-category">'.$category['name'].'</p>
                                                    <p class="item-title">'.$item['name'].'</p>
                                                </div>
                                                <p class="item-description">
                                                    '.$item['description'].'
                                                </p>
                                                <div class="item-actions">
                                                    <a href="?p=admin&itemStatus&publicate&itemID='.$item['id'].'" class="link-style">Опубликовать</a>
                                                    <a href="?p=admin&itemStatus&block&itemID='.$item['id'].'" class="link-style">Заблокировать</a>
                                                </div>
                                            </div>
                                        </div>
                                        ';
                                    }
                                } else {
                                    echo '<h2>Видимо, их ещё нет</h2>';
                                }
                            ?>
                        </div>
                </div>
            </section>
        <?php
    } else {
        echo '<h1>Не думаю, что это твоя территория</h1>';
    }
?>