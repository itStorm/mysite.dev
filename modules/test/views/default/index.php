<div class="h1">TEST PAGE</div>

<?php echo time(); ?>
<br>
<?php echo date('Y-m-d H:i:s T'); ?>

<br><br>
<?php
echo common\widgets\SocialButtonsWidget::widget([
    'url'   => \yii\helpers\Url::to('/test/ololo14', true),
    'image' => \yii\helpers\Url::to('/img/social-logo.jpeg', true),
]);

echo '<br>' . mb_internal_encoding();
?>
