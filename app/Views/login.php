<div class="errors">
    <?php foreach ($errors as $error): ?>
        <div class="form_error"><?php echo $error; ?></div>
    <?php endforeach; ?>
</div>

<div class="form-wrapper">

    <div class="form">
        <h3>Войдите в ваш аккаунт</h3>
        <p>Введите свою почту и пароль который вы указали при регистрации</p>

        <form action="/login" method="post" enctype="multipart/form-data">
            <div class="form-row">
                <input type="text" name="_email" required value="<?php htmlspecialchars($_POST["_email"]); ?>" />
                <label class="form-row_label">Email</label>
            </div>

            <div class="form-row">
                <input type="password" name="_password" required />
                <label class="form-row_label">Пароль</label>
            </div>

            <button type="submit">Войти</button>

            <p>Ещё нет аккаунта? <a href="/register">Зарегистрируйтесь</a></p>
        </form>
    </div>
</div>