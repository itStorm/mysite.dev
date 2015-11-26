<div class="user-email-confirm">

    <?php if (Yii::$app->session->hasFlash('successActivation')): ?>

        <div class="alert alert-success">
            Your account successfully activated
        </div>
        <h1>You are welcome!</h1>
        <p>
            <img alt="Welcome" src="/img/welcome.jpeg"/>
        </p>

    <?php elseif(Yii::$app->session->hasFlash('userAlreadyActivated')): ?>

        <div class="alert alert-warning">
            Your account already activated
        </div>

    <?php endif; ?>
</div>