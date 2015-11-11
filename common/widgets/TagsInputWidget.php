<?php
namespace common\widgets;

use app\modules\article\models\Tag;
use yii\base\Widget;
use yii\jui\AutoComplete;
use yii\helpers\Html;
use common\widgets\interfaces\TagsInterface;
use yii\base\Model;

/**
 * Class TagsInputWidget
 * @package common\widgets
 */
class TagsInputWidget extends Widget
{
    /** @var Model|TagsInterface */
    public $model;

    /** @var string */
    public $attribute;

    /** @var string */
    protected $inputName;

    public function run()
    {
        $this->registerJs();

        // Заголовок
        $mainLabel = Html::activeLabel($this->model, $this->attribute);

        // Блок hidden тегов
        $tags = $this->model->getTags();
        $tagInputs = '';
        foreach ($tags as $tagName) {
            $tagInputs .= $this->getInput($tagName);
        }

        // Инпут для добавления тегов
        $inputTag = AutoComplete::widget([
            'name'          => 'tag-input',
            'clientOptions' => [
                'source' => Tag::getBaseTagsNames()
            ],
        ]);

        $html = <<<HTML
$mainLabel
<div class="tags-input-widget">
    <div class="tags">
        $tagInputs
    </div>
    <div class="tags-lables"></div>
    $inputTag
</div>
HTML;

        return $html;
    }

    /**
     * @param string $value
     * @return string
     */
    protected function getInput($value = '')
    {
        return Html::hiddenInput(Html::getInputName($this->model, $this->attribute) . '[]', $value);
    }

    /**
     * Имя для инпута
     * @return string
     */
    protected function getInputName()
    {
        if (!$this->inputName) {
            $this->inputName = Html::getInputName($this->model, $this->attribute) . '[]';
        }

        return $this->inputName;
    }

    protected function registerJs()
    {
        $inputName = $this->getInputName();

        $js = <<<JS
    $('.tags-input-widget').each(function(i, widget) {
        var inputsBlock, lablesBlock;

        inputsBlock = $(widget).find('.tags').first();
        lablesBlock = $(widget).find('.tags-lables').first();

        $(widget).find('input[name=tag-input]').keydown(function(e) {
            if(e.keyCode == 13){
                var textLabel, lable, deleteButton, input;

                textLabel = $(this).val().trim();
                if(!textLabel) {
                    return false;
                }

                lable = $(document.createElement('span')).addClass('label label-info').text(textLabel+' ');
                deleteButton = $(document.createElement('span')).addClass('tag-delete').append('<a href="#">x</a>').appendTo(lable);
                input = $(document.createElement('input')).attr({
                    'type': 'hidden',
                    'name': '{$inputName}'
                }).val(textLabel);

                $(lablesBlock).append(lable).append('\\n');
                $(inputsBlock).append(input);

                $(deleteButton).bind('click', function() {
                    $(input).remove();
                    $(lable).remove();

                    return false;
                });

                $(this).val('');

                return false;
            }
        });


        $(inputsBlock).find('input[name="{$inputName}"]').each(function(i, input) {
            var textLabel, lable, deleteButton;

            textLabel = $(input).val();
            lable = $(document.createElement('span')).addClass('label label-info').text(textLabel+' ');
            deleteButton = $(document.createElement('span')).addClass('tag-delete').append('<a href="#">x</a>').appendTo(lable);

            $(lablesBlock).append(lable).append('\\n');

            $(deleteButton).bind('click', function() {
                $(input).remove();
                $(lable).remove();

                return false;
            });
        })
    });

JS;

        $this->getView()->registerJs($js);

        return $this;
    }
}