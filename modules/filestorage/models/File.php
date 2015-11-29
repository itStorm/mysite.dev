<?php

namespace app\modules\filestorage\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\helpers\Url;
use yii\web\UploadedFile;

/**
 * Class File
 * @package app\modules\filestorage\models
 *
 * @property integer $id
 * @property string $name
 * @property string $extension
 * @property string $mime_type
 * @property integer $size
 * @property string $real_name
 * @property string $path
 * @property integer $created
 * @property integer $updated
 * @property bool $is_protected
 */
class File extends ActiveRecord
{
    const IS_PROTECTED = true;
    const NOT_PROTECTED = false;

    /** @inheritdoc */
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class'      => TimestampBehavior::className(),
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => 'created',
                    ActiveRecord::EVENT_BEFORE_UPDATE => 'updated',
                ],
                'value'      => function () {
                    return time();
                },
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'files';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'extension', 'mime_type', 'size', 'is_protected'], 'required'],
            [['size', 'created', 'updated'], 'integer'],
            [['name', 'mime_type'], 'string', 'max' => 128],
            [['extension'], 'string', 'max' => 16],
            [['real_name', 'path'], 'string', 'max' => 32],
            [['is_protected'], 'boolean'],
        ];
    }

    /**
     * Получить Url к файла
     * @param boolean|string $scheme the URI scheme to use in the generated URL
     * @return string
     */
    public function getUrl($scheme = false)
    {
        if ($this->is_protected) {
            $url = ['/filestorage/default/index', 'filename' => $this->real_name];
            if ($this->path) {
                $url['path'] = $this->path;
            }
        } else {
            $url = 'files/' . ($this->path ? $this->path . '/' : '') . $this->real_name . '.' . $this->extension;
        }

        return Url::to($url, $scheme);
    }

    /**
     * @return string
     */
    public function generateFileName()
    {
        return md5($this->id . $this->path . microtime());
    }

    public function getSystemFullPath()
    {
        $fileDir = $this->is_protected ? Yii::getAlias('@filestorage') : Yii::getAlias('@files');
        $fileDir .= DIRECTORY_SEPARATOR . ($this->path ? $this->path . DIRECTORY_SEPARATOR : '');

        return $fileDir . $this->real_name . ($this->is_protected ? '' : '.' . $this->extension);

    }

    /** @inheritdoc */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        $fullPath = $this->getSystemFullPath();

        if (file_exists($fullPath)) {
            return unlink($fullPath);
        }

        return true;
    }

    /**
     * @param UploadedFile $uploadedFile
     * @param string $subDir
     * @param bool|false $isProtected
     * @return File|false
     */
    public static function createFromUploaded(UploadedFile $uploadedFile, $subDir = '', $isProtected = self::NOT_PROTECTED)
    {
        $fileDir = $isProtected ? Yii::getAlias('@filestorage') : Yii::getAlias('@files');
        $fileDir .= DIRECTORY_SEPARATOR . ($subDir ? $subDir . DIRECTORY_SEPARATOR : '');

        $file = new self();
        $file->name = $uploadedFile->getBaseName();
        $file->extension = $uploadedFile->getExtension();
        $file->mime_type = $uploadedFile->type;
        $file->size = $uploadedFile->size;
        $file->real_name = '';
        $file->path = $subDir;
        $file->is_protected = $isProtected;

        $saveFileTransaction = File::getDb()->beginTransaction();
        try {
            do {
                $realFilename = $file->generateFileName();
                $fullPath = $fileDir . $realFilename . ($isProtected ? '' : '.' . $file->extension);
            } while (file_exists($fullPath));

            $uploadedFile->saveAs($fullPath);
            $file->real_name = $realFilename;
            $file->save();
        } catch (\Exception $e) {
            $saveFileTransaction->rollBack();

            return false;
        }

        $saveFileTransaction->commit();

        return $file;
    }
}