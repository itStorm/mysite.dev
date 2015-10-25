<div class="h1">TEST PAGE</div>

<?php echo time();?>
<br>
<?php echo date('Y-m-d H:i:s T');?>

<br><br>
<?php
    echo common\widgets\SocialButtonsWidget::widget([
        'url' => '/test/ololo12',
    ]);
?>