<?php

use app\classes\ProfileForm;
use app\classes\User;

/** @var $form ProfileForm */
/** @var $user User */
/** @var $updated bool */

require_once 'header.php';

?>

    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-2 mt-3">
                <h2>Профиль пользователя</h2>
                <div class="mt-3">
                    <form action="/logout" method="post">
                        <input type="submit" name="submit" class="btn btn-success" value="Выйти">
                    </form>
                </div>
                <?php if ($updated): ?>
                    <div class="alert alert-success mt-3" role="alert">
                        Профиль обновлён
                    </div>
                <?php endif; ?>
                <form action="/profile" method="post" class="mt-3">
                    <div class="mb-3">
                        <label for="login" class="form-label">Логин</label>
                        <input type="text" class="form-control" name="login" value="<?= $user->login ?>">
                        <?php if ($form->errors['login']): ?>
                            <div class="form-text text-danger"><?= $form->errors['login'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Номер телефона</label>
                        <input type="number" class="form-control" name="phone" value="<?= $user->phone ?>">
                        <div class="form-text">Только цифры</div>
                        <?php if ($form->errors['phone']): ?>
                            <div class="form-text text-danger"><?= $form->errors['phone'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="<?= $user->email ?>"
                        ><?php if ($form->errors['email']): ?>
                            <div class="form-text text-danger"><?= $form->errors['email'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Новый пароль</label>
                        <input type="password" class="form-control" name="new_password" >
                        <?php if ($form->errors['new_password']): ?>
                            <div class="form-text text-danger"><?= $form->errors['new_password'] ?></div>
                        <?php endif; ?>
                    </div>
                    <div class="mb-3">
                        <label for="password-repeat" class="form-label">Повторите пароль</label>
                        <input type="password" class="form-control" name="password-repeat" >
                        <?php if ($form->errors['password_repeat']): ?>
                            <div class="form-text text-danger"><?= $form->errors['password_repeat'] ?></div>
                        <?php endif; ?>
                    </div>
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </form>
            </div>

        </div>

    </div>


<?php require_once 'footer.php'; ?>