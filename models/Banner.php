<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bs_slide_banner".
 *
 * @property integer $id
 * @property string $ten_slide
 * @property string $hinh
 * @property string $trang_thai
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bs_slide_banner';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ten_slide', 'hinh', 'trang_thai'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_slide' => 'Ten Slide',
            'hinh' => 'Hinh',
            'trang_thai' => 'Trang Thai',
        ];
    }

    public static function getAllBanners()
    {
        return Banner::find()
            ->select(['hinh'])
            ->asArray()
            ->all()
        ;
    }
}
