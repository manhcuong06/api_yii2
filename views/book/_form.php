<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Book */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="book-form">

    <?php $form = ActiveForm::begin([
        'options'    => ['enctype' => 'multipart/form-data'],
    ]); ?>

    <?= $form->field($model, 'ten_sach')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <label for="book-image">Hinh 1</label>
        <?= Html::fileInput('image', '', [
            'id' => 'book-image',
        ]) ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
