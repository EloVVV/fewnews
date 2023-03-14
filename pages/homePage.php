<section class="news-block">
    <div class="news-block_container container">
        <div class="news-header">
            <h1>Новости</h1>
            <div class="filter">
                <a href="?p=home" class="link-style">Все новости</a>
                <?php
                    $categories = $database->query("SELECT * FROM `item_categories`")->fetchAll(PDO::FETCH_ASSOC);

                    foreach($categories as $category) {
                        echo '<a href="?p=home&category='.$category['id'].'" class="link-style">'.$category['name'].'</a>';
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
                
                $items = $database->query("SELECT * FROM `items` $sqlCategory")->fetchAll(PDO::FETCH_ASSOC);

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
            ?>
        </div>
    </div>
</section>