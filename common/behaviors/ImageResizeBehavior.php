<?php

namespace common\behaviors;

use yii\base\Behavior;
use yii\base\Event;
use yii\base\Model;
use yii\imagine\Image;
use yii\web\UploadedFile;

/**
 * Class ImageResizeBehavior
 * @package common\behaviors
 */
class ImageResizeBehavior extends Behavior
{
    /** @var array */
    public $images = [];

    /** @inheritdoc */
    public function events()
    {
        return [
            Model::EVENT_AFTER_VALIDATE => 'resizeImages',
        ];
    }


    /**
     * @param Event $event
     */
    public function resizeImages(Event $event)
    {
        foreach ($this->images as $property => $params) {
            $this->resize($property, $params['w'], $params['h']);
        }
    }

    protected function resize($property, $w, $h)
    {
        if (!$this->owner->{$property}) {
            return;
        }

        $oldFileName = $this->owner->{$property}->tempName;
        $newFileName = $this->owner->{$property}->tempName . '.' . $this->owner->{$property}->getExtension();
        Image::thumbnail($this->owner->{$property}->tempName, $w, $h)->save($newFileName);

        if (file_exists($newFileName)) {
            unlink($oldFileName);
            rename($newFileName, $oldFileName);
            $this->owner->{$property}->size = filesize($oldFileName);
        }
    }
}