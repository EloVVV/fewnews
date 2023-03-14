<?php
    session_start(); 
    require('database/connect.php');
    global $database;
?>
<?php
    if(isset($_GET['id'])) {
        if(!empty($_GET['id'])) {
            ?>
            <section class="single container">
                <?php 
                    $item = $database->query("SELECT * FROM `items` WHERE `id`={$_GET['id']}")->fetch(PDO::FETCH_ASSOC);
                    $category = $database->query("SELECT * FROM `item_categories` WHERE `id`={$item['category']}")->fetch(PDO::FETCH_ASSOC);
                    echo '
                        <div class="item">
                            <div class="item_headline">
                                <p class="item-category">'.$category['name'].'</p>
                                <p class="item-title">'.$item['name'].'</p>
                            </div>
                            <div class="item_image-box image-box">
                                <img src="'.$item['image_path'].'" alt="" class="item-img">
                            </div>
                            <div class="item_text-content">
                                <h2>Описание</h2>
                                <p class="item-description">
                                    '.$item['description'].'
                                </p>
                            </div>
                        </div>
                    ';
                
                ?>
            </section>
            <?php
        } else {
            echo '<h1>Упс... Вернитесь-ка обратно</h1>';
        }
    } else {
        echo '<h1>Упс... Вернитесь-ка обратно</h1>';
    }

?>