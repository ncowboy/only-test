<?php require_once 'header.php'; ?>
<?php /** @var $form \app\classes\LoginForm */ ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-2 mt-3">
                <?php if (\app\classes\Session::read('success')): ?>
                    <div class="alert alert-success" role="alert">
                        Вы зарегистрированы!
                    </div>
                <?php endif; ?>
                <h2>Вход</h2>
                <form action="/login" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Имя пользователя</label>
                        <input type="text" class="form-control" name="username" value="<?= $form->username ?>">
                        <div class="form-text">Номер телефона или Email</div>
                        <?php if ($form->errors['username']): ?>
                            <div class="form-text text-danger"><?= $form->errors['username'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" class="form-control" name="password" value="<?= $form->password ?>">
                        <?php if ($form->errors['password']): ?>
                            <div class="form-text text-danger"><?= $form->errors['password'] ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Войти</button>
                </form>
                <div class="mt-3">
                    <a href="/register">Регистрация</a>
                </div>
            </div>

        </div>
    </div>

<?php require_once 'footer.php'; ?>