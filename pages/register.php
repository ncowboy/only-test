<?php

use app\classes\RegisterForm;

require_once 'header.php'; ?>

<?php /** @var $form RegisterForm */ ?>

    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-2 mt-3">
                <h2>Регистрация</h2>
                <form action="/register" method="post">
                    <div class="mb-3">
                        <label for="login" class="form-label">Логин</label>
                        <input type="text" class="form-control" name="login" value="<?= $form->login ?>">
                        <?php if ($form->errors['login']): ?>
                            <div class="form-text text-danger"><?= $form->errors['login'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Номер телефона</label>
                        <input type="number" class="form-control" name="phone" value="<?= $form->phone ?>">
                        <div class="form-text">Только цифры</div>
                        <?php if ($form->errors['phone']): ?>
                            <div class="form-text text-danger"><?= $form->errors['phone'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= $form->email ?>"
                        ><?php if ($form->errors['email']): ?>
                            <div class="form-text text-danger"><?= $form->errors['email'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Пароль</label>
                        <input type="password" class="form-control" name="password" value="<?= $form->password ?>">
                        <?php if ($form->errors['password']): ?>
                            <div class="form-text text-danger"><?= $form->errors['password'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="password-repeat" class="form-label">Повторите пароль</label>
                        <input type="password" class="form-control" name="password-repeat" value="<?= $form->password_repeat ?>">
                        <?php if ($form->errors['password_repeat']): ?>
                            <div class="form-text text-danger"><?= $form->errors['password_repeat'] ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Зарегистрироваться</button>
                </form>
            </div>

        </div>

    </div>


<?php require_once 'footer.php'; ?>