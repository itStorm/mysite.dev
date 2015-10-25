<?php
namespace common\widgets;

use app\modules\article\models\Tag;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\jui\AutoComplete;
use yii\helpers\Html;
use common\widgets\interfaces\TagsInterface;
use yii\base\Model;

class TagsWidget extends Widget
{
    /** @var Model|TagsInterface */
    public $model;
    public $attribute;

    public function run()
    {
        $objectTags = $this->model->getTags()->select([
            'id',
            'name',
        ])
            ->asArray()
            ->all();
        $objectTagsList = ArrayHelper::map($objectTags, 'id', 'name');
        $checkboxList = Html::activeCheckboxList($this->model, $this->attribute, $objectTagsList, [
            'name' => 'tags',
            'style' => ['display' => 'none']
        ]);

        $autoCompleteTagsList = Tag::find()
            ->select('name')
            ->where([
                'is_base' => 1
            ])
            ->asArray()
            ->column();

        $inputTag = AutoComplete::widget([
            'name'          => 'tag-input',
            'clientOptions' => [
                'source' => $autoCompleteTagsList
            ],
        ]);

        return $checkboxList . $inputTag;
    }
}