<?php
    session_start();
    require('database/connect.php');
    global $database;
    
    if(!isset($_SESSION['USER'])) {
        echo '<script>document.location.href="?p=error"</script>';
    }

    $getCategories = $database->query("SELECT * FROM `item_categories`")->fetchAll(PDO::FETCH_ASSOC);
?>

<form method="POST" enctype="multipart/form-data" action="actions/createNews.php" class="form_container container">
    <h1>Новая публикация</h1>
    <div class="input_blocks">
        <div class="input-box">
            <label>Заголовок</label>
            <input type="text" name="name" placeholder="Крутой заголовок" id="" class="input-style">
        </div>

        <div class="input-box">
            <label>Категория</label>
            <select name="category" class="input-style">
                <?php
                    foreach($getCategories as $ctg) {
                        echo '
                        <option value="'.$ctg['id'].'">'.$ctg['name'].'</option>
                        ';
                    }
                ?>
            </select>
        </div>

        <div class="input-box">
            <label>Описание</label>
            <textarea name="description" id="" placeholder="Какой-то контент" class="input-style"></textarea>
        </div>

        <div class="input-box">
            <label>Изображение</label>
            <input type="file" name="image_path" id="" class="input-style">
        </div>
    </div>
    <button type="submit" class="button-style">Предложить</button>
</form>