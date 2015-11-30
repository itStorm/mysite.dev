<?php

namespace app\modules\filestorage\controllers;

use app\modules\filestorage\models\File;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use \Yii;

class DefaultController extends Controller
{
    /**
     * Отдача файла из приватного хранилища
     * @param string $filename
     * @param string $path
     * @throws NotFoundHttpException
     */
    public function actionIndex($filename = null, $path = '')
    {
        if (!$filename) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        /** @var File $file */
        $file = File::findOne([
            'real_name'    => $filename,
            'path'         => $path,
            'is_protected' => File::IS_PROTECTED
        ]);

        if (!$file || !file_exists($file->getSystemFullPath())) {
            throw new NotFoundHttpException(Yii::t('yii', 'Page not found.'));
        }

        // Отдаем файл
        $filePath = $file->getSystemFullPath();
        $uploadFilename = $file->name . '.' . $file->extension;

        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $uploadFilename . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . $file->size);

        readfile($filePath);
        exit;
    }
}
