<?php
    if(!isset($_SESSION['USER'])) {
        echo '<script>document.location.href="?p=error"</script>';
    }
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
            <a href="?p=createNews" class="button-style">Предложить новость</a>
        </div>
    </div>
    <div class="profile_container container">
        <div class="news-header">
            <h1>Мои новости</h1>
            <div class="filter">
                <a href="?p=profile" class="link-style">Все новости</a>
                <?php
                    $categories = $database->query("SELECT * FROM `item_categories`")->fetchAll(PDO::FETCH_ASSOC);

                    foreach($categories as $category) {
                        echo '<a href="?p=profile&category='.$category['id'].'" class="link-style">'.$category['name'].'</a>';
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
                
                $items = $database->query("SELECT * FROM `items` WHERE `author`={$_SESSION['USER']} $sqlCategory")->fetchAll(PDO::FETCH_ASSOC);

                if(!empty($items)) {
                    foreach($items as $item) {
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
                                </div>
                            </div>
                            ';
                    }
                } else {
                    echo '<h2>Эх.. они ещё не созданы...</h2>';
                }
            ?>
        </div>
    </div>
</section>