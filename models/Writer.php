<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bs_tac_gia".
 *
 * @property integer $id
 * @property string $ten_tac_gia
 * @property string $ngay_sinh
 * @property string $gioi_thieu
 */
class Writer extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bs_tac_gia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ngay_sinh'], 'safe'],
            [['gioi_thieu'], 'string'],
            [['ten_tac_gia'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_tac_gia' => 'Ten Tac Gia',
            'ngay_sinh' => 'Ngay Sinh',
            'gioi_thieu' => 'Gioi Thieu',
        ];
    }

    public static function getAllWriters()
    {
        return $writers = Writer::find()
            ->select(['value' => 'id', 'label' => 'ten_tac_gia'])
            ->orderBy(['ten_tac_gia' => SORT_ASC])
            ->asArray()
            ->all()
        ;
    }
}
