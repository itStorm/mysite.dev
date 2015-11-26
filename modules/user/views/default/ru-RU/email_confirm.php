<div class="user-email-confirm">
    <?php if (Yii::$app->session->hasFlash('successActivation')): ?>
        <div class="alert alert-success">
            Ваш аккаунт успешно активирован
        </div>
        <h1>Добро пожаловать!</h1>
        <p>
            <img alt="Welcome" src="/img/welcome.jpeg"/>
        </p>
    <?php elseif(Yii::$app->session->hasFlash('userAlreadyActivated')): ?>
        <div class="alert alert-warning">
            Аккаунт уже активирован
        </div>
    <?php endif; ?>
</div>