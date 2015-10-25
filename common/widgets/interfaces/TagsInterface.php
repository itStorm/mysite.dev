<?php
namespace common\widgets\interfaces;

use yii\db\ActiveQuery;


interface TagsInterface
{
    /**
     * @return ActiveQuery
     */
    public function getTags();
}