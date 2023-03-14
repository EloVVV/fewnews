<form method="POST" action="actions/reg.php" class="form_container container">
    <h1>Регистрация</h1>
    <div class="input_blocks">
        <div class="input-box">
            <label>Имя</label>
            <input type="text" name="name" placeholder="Имя Фамилия Отчество" id="" class="input-style">
        </div>

        <div class="input-box">
            <label>Логин</label>
            <input type="text" name="login" placeholder="username" id="" class="input-style">
        </div>

        <div class="input-box">
            <label>Почта</label>
            <input type="text" name="email" placeholder="NameEmail@mail.ru" id="" class="input-style">
        </div>

        <div class="input-box">
            <label>Пароль</label>
            <input type="password" name="password" placeholder="123456" id="" class="input-style">
        </div>
        
        <div class="input-box">
            <label>Повторите пароль</label>
            <input type="password" name="re_password" placeholder="123456" id="" class="input-style">
        </div>
    </div>
    <button type="submit" class="button-style">Зарегистрироваться</button>
</form>