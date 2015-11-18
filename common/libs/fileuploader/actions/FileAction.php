<?php
namespace common\libs\fileuploader\actions;

use yii\base\Action;

/**
 * Class FileAction
 * @package common\actions
 */
class FileAction extends Action
{
    public function run()
    {
        return $this->controller->getView()->render('@common/libs/fileuploader/views/index', [], $this);
    }
}