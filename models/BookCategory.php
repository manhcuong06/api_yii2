<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bs_loai_sach".
 *
 * @property integer $id
 * @property string $ten_loai_sach
 * @property integer $id_loai_cha
 * @property string $sap_xep
 * @property integer $trang_thai
 */
class BookCategory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bs_loai_sach';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_loai_cha', 'trang_thai'], 'integer'],
            [['ten_loai_sach', 'sap_xep'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_loai_sach' => 'Ten Loai Sach',
            'id_loai_cha' => 'Id Loai Cha',
            'sap_xep' => 'Sap Xep',
            'trang_thai' => 'Trang Thai',
        ];
    }

    public static function getAllBookCategories()
    {
        return $categories = BookCategory::find()
            ->select(['id', 'ten_loai_sach', 'text' => 'ten_loai_sach'])
            ->orderBy(['ten_loai_sach' => SORT_ASC])
            ->asArray()
            ->all()
        ;
    }
}
