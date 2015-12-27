<?php
use yii\helpers\Html;
use app\assets\AppAsset;

/* @var $this common\View */
/* @var $content string */

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?php echo ($this->title ? Html::encode($this->title) . ' - ' : '') . Yii::$app->params['projectUrl']; ?></title>
    <?php $this->head() ?>
</head>
<body>

<?php
$this->beginBody();
echo $content;
$this->endBody();
?>

</body>
</html>
<?php $this->endPage() ?>
