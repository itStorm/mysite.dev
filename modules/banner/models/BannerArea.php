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
            [['alias', 'name'], 'required'],
            [['alias', 'name'], 'string', 'max' => 255]
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
