<?php
use yii\helpers\Url;
use common\libs\fileuploader\assets\ElfinderAsset;

/* @var $this \yii\web\View */

ElfinderAsset::register($this);

$backendUrl = Url::to(['fileconnector']);

$js = <<<JS
  var FileBrowserDialogue = {
    init: function() {
      // Here goes your code for setting your custom things onLoad.
    },
    mySubmit: function (file, elf) {
      // pass selected file data to TinyMCE
      parent.tinymce.activeEditor.windowManager.getParams().oninsert(file, elf);
      // close popup window
      parent.tinymce.activeEditor.windowManager.close();
    }
  }

  $().ready(function() {
    var elf = $('#elfinder').elfinder({
      // set your elFinder options here
      url: '{$backendUrl}',  // connector URL
      getFileCallback: function(file) { // editor callback
        // Require `commandsOptions.getfile.onlyURL = false` (default)
        FileBrowserDialogue.mySubmit(file, elf); // pass selected file path to TinyMCE
      }
    }).elfinder('instance');
  });
JS;
$this->registerJs($js);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>elFinder 2.0</title>
    <?php $this->head() ?>
</head>
<body>

<?php $this->beginBody() ?>

<!-- Element where elFinder will be created (REQUIRED) -->
<div id="elfinder"></div>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>