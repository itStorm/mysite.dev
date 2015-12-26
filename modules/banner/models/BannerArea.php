<?php

namespace app\modules\banner\models;

use Yii;

/**
 * This is the model class for table "banner_areas".
 *
 * @property integer $id
 * @property string $alias
 * @property string $name
 *
 * @property Banner[] $banners
 */
class BannerArea extends \yii\db\ActiveRecord
{
    const RULE_VIEW = 'banner_area_view';
    const RULE_CREATE = 'banner_area_create';
    const RULE_UPDATE = 'banner_area_update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banner_areas';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['alias', 'required'],
            ['alias', 'string', 'max' => 128],
            ['alias', 'unique'],

            ['name', 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'alias' => 'Alias',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBanners()
    {
        return $this->hasMany(Banner::className(), ['area_id' => 'id']);
    }
}
