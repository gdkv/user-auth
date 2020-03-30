<div class="errors">
    <?php foreach ($errors as $error): ?>
        <div class="form_error"><?php echo $error; ?></div>
    <?php endforeach; ?>
</div>

<div class="form-wrapper">

    <div class="form">
        <h3>Регистрация</h3>
        <p>Заполните информацию о себе</p>

        <form action="/register" method="post" enctype="multipart/form-data">

        <div class="form-row">
            <input type="text" name="_name" required value="<?php echo htmlspecialchars($_POST["_name"]); ?>" />
            <label class="form-row_label">Имя, фамилия</label>
        </div>

        <div class="form-row">
            <input type="file" name="_avatar" placeholder="Загрузите свое фото" />
            <label class="form-row_info">Файл должен быть формата GIF, PNG или JPG. Размер файла не должен превыщать 2Мб.</label>
        </div>

        <div class="form-row">
            <input type="email" name="_email" required value="<?php echo htmlspecialchars($_POST["_email"]); ?>"/>
            <label class="form-row_label">Email</label>
        </div>

        <div class="form-row">
            <input type="text" name="_date_of_birth" required value="<?php echo htmlspecialchars($_POST["_date_of_birth"]); ?>">
            <label class="form-row_label">Дата рождения</label>
        </div>

        <div class="form-row">
            <input type="password" name="_password" required />
            <label class="form-row_label">Пароль</label>
        </div>

        <textarea name="_bio" placeholder="Заполните краткую информацию о себе"><?php echo htmlspecialchars($_POST["_bio"]); ?></textarea>

        <button type="submit">Зарегистрироваться</button>
        <p>Есть аккаунт? <a href="/login">Авторизуйтесть</a></p>
    </form>
    </div>
</div>