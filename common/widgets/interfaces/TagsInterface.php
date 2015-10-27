<?php
namespace common\widgets\interfaces;

use yii\db\ActiveQuery;


interface TagsInterface
{
    /**
     * @return array
     */
    public function getTags();
}