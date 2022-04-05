<div class="auth">
  <?php if (empty($arrAccessKey)): ?>
    <p class="auth__text">
        Придупайте и введите пароль главного пользователя,
        пароль должен наченаться с 'key:' пример 'key:new-password',
        в случаее окончания или удаления cookies, вход будет возможен
        только по этому паролю. Нажмите кнопку 'отправить' и перейдите
        по сссылки:

        <a href="/route/admin" class="auth__link">Администрирование</a>
    </p>
  <?php endif; ?>

  <form class="auth-form" action="" method="post">
    <label for="" class="auth-form__label"> key:
      <input class="auth-form__input" type="text" name="key">
    </label>

    <button class="auth-form__btn btn" name="submitKey">Отправить</button>
  </form>


  <button class="auth__btn btn">Обновить</button>
</div>
