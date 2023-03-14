<header>
    <div class="header_container container">
        <a href="?p=home" class="logotype-box image-box">
            <div class="logotype-name">
                FewNews
            </div>
        </a>
        <!-- <nav class="menu">
            <li><a href="#" class="link-style">Новости</a></li>
        </nav> -->
        <div class="actions">
            <?php
                if(isset($_SESSION['USER'])) {
                    if($user['role'] === 'admin') {
                        echo '
                        <a href="?p=admin" class="link-style">Админ панель</a>
                        <span>/</span>
                        <a href="?do=exit" class="link-style">Выйти</a>
                        ';
                    } else {
                        echo '
                        <a href="?p=profile" class="link-style">Профиль</a>
                        <span>/</span>
                        <a href="?do=exit" class="link-style">Выйти</a>
                        ';
                    }
                } else {
                    echo '
                    <a href="?p=auth" class="link-style">Войти</a>
                    <span>/</span>
                    <a href="?p=reg" class="link-style">Регистрация</a>
                    ';
                }
            ?>
        </div>
    </div>
</header>