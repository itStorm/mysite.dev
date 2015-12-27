<?php

namespace app\modules\banner\models;

use Yii;

/**
 * This is the model class for table "banners".
 *
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $area_id
 *
 * @property BannerArea $area
 */
class Banner extends \yii\db\ActiveRecord
{
    const RULE_VIEW = 'banner_view';
    const RULE_CREATE = 'banner_create';
    const RULE_UPDATE = 'banner_update';
    const RULE_UPLOAD_FILES = 'banner_upload_files';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'banners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'area_id'], 'required'],
            [['code'], 'string'],
            [['area_id'], 'integer'],
            [['name'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'area_id' => 'Area for placement',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getArea()
    {
        return $this->hasOne(BannerArea::className(), ['id' => 'area_id']);
    }
}
