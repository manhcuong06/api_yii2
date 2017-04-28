<?php

namespace app\models;

use Yii;
use yii\web\UploadedFile;

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

    public function getCategory()
    {
        return $this->hasOne(BookCategory::className(), ['id' => 'id_loai_sach']);
    }

    public function getPublisher()
    {
        return $this->hasOne(Publisher::className(), ['id' => 'id_nha_xuat_ban']);
    }

    public function getWriter()
    {
        return $this->hasOne(Writer::className(), ['id' => 'id_tac_gia']);
    }

    public function uploadImage()
    {
        $file = $_FILES['image'];

        /******
        UploadedFile class has "tempName", no "temp_name" key
        Must change key from "tmp_name" to "tempName" before constructor

        $_FILES = [
            ...
            'tmp_name' => '',
            ...
        ];

        UploadedFile = [
            ...
            'tempName' => '',
            ...
        ];
        ******/
        $file['tempName'] = $file['tmp_name'];
        unset($file['tmp_name']);

        // Append date to file name
        $file['name'] = date('Y-m-d_H-i-s_') . $file['name'];
        $this->hinh = $file['name'];

        $uploadForm = new UploadForm();
        $uploadForm->imageFile = new UploadedFile($file);
        $uploadForm->imagePath = Yii::getAlias('@web') . Yii::$app->params['image_path']['Book'];

        if (!$uploadForm->upload()) {
            return false;
        }
        return true;
    }

    public function deleteImage()
    {
        $image_path = Yii::getAlias('@web') . Yii::$app->params['image_path']['Book'] . $this->hinh;

        if (file_exists($image_path)) {
            unlink($image_path);
            return true;
        }
        return false;
    }

    public static function getAllBooks()
    {
        return Book::find()
            ->select(['id', 'ten_sach', 'id_tac_gia', 'id_loai_sach', 'id_nha_xuat_ban', 'trang_thai', 'hinh', 'don_gia', 'noi_bat'])
            ->orderBy(['id' => SORT_DESC])
            ->asArray()
            ->all()
        ;
    }
}
