<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "bs_sach".
 *
 * @property integer $id
 * @property string $ten_sach
 * @property integer $id_tac_gia
 * @property string $gioi_thieu
 * @property string $doc_thu
 * @property integer $id_loai_sach
 * @property integer $id_nha_xuat_ban
 * @property integer $so_trang
 * @property string $ngay_xuat_ban
 * @property string $kich_thuoc
 * @property string $sku
 * @property string $trong_luong
 * @property integer $trang_thai
 * @property string $hinh
 * @property integer $don_gia
 * @property integer $gia_bia
 * @property integer $noi_bat
 */
class Book extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'bs_sach';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_tac_gia', 'id_loai_sach', 'id_nha_xuat_ban', 'so_trang', 'trang_thai', 'don_gia', 'gia_bia', 'noi_bat'], 'integer'],
            [['gioi_thieu'], 'string'],
            [['ngay_xuat_ban'], 'safe'],
            [['ten_sach', 'doc_thu', 'kich_thuoc', 'sku', 'trong_luong', 'hinh'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ten_sach' => 'Ten Sach',
            'id_tac_gia' => 'Id Tac Gia',
            'gioi_thieu' => 'Gioi Thieu',
            'doc_thu' => 'Doc Thu',
            'id_loai_sach' => 'Id Loai Sach',
            'id_nha_xuat_ban' => 'Id Nha Xuat Ban',
            'so_trang' => 'So Trang',
            'ngay_xuat_ban' => 'Ngay Xuat Ban',
            'kich_thuoc' => 'Kich Thuoc',
            'sku' => 'Sku',
            'trong_luong' => 'Trong Luong',
            'trang_thai' => 'Trang Thai',
            'hinh' => 'Hinh',
            'don_gia' => 'Don Gia',
            'gia_bia' => 'Gia Bia',
            'noi_bat' => 'Noi Bat',
        ];
    }
}
