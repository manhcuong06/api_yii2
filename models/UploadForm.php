<?php

namespace app\models;

use Yii;
use yii\base\Model;

class UploadForm extends Model
{
    /**
     * @var UploadedFile
     */
    public $imageFile;
    public $imagePath;

    public function rules()
    {
        return [
            [['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg, gif'],
            [['imagePath'], 'string'],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->imageFile->saveAs($this->imagePath . $this->imageFile->baseName . '.' . $this->imageFile->extension);
            return true;
        } else {
            return false;
        }
    }
}