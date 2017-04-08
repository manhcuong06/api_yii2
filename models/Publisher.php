<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bs_nha_xuat_ban".
 *
 * @property integer $id
 * @property string $ten_nha_xuat_ban
 * @property string $dia_chi
 * @property string $dien_thoai
 * @property string $email
 */
class Publisher extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bs_nha_xuat_ban';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ten_nha_xuat_ban', 'dia_chi', 'dien_thoai', 'email'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_nha_xuat_ban' => 'Ten Nha Xuat Ban',
            'dia_chi' => 'Dia Chi',
            'dien_thoai' => 'Dien Thoai',
            'email' => 'Email',
        ];
    }

    public static function getAllPublishers()
    {
        return $publishers = Publisher::find()
            ->select(['value' => 'id', 'label' => 'ten_nha_xuat_ban'])
            ->orderBy(['ten_nha_xuat_ban' => SORT_ASC])
            ->asArray()
            ->all()
        ;
    }
}
