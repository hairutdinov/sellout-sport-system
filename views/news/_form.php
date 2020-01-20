<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\News */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row justify-content-sm-center">
      <div class="col-sm-10"><?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?></div>

      <div class="col-sm-10"><?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?></div>

      <div class="col-sm-10"><?= $form->field($model, 'url')->textarea(['rows' => 6]) ?></div>

      <div class="col-sm-10"><?= $form->field($model, 'urlToImage')->textarea(['rows' => 6]) ?></div>

      <div class="col-sm-10"><?= $form->field($model, 'publishedAt')->textInput() ?></div>

      <div class="col-sm-10"><?= $form->field($model, 'content')->textarea(['rows' => 6]) ?></div>

      <div class="form-group col-sm-10">
          <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
      </div>
    </div>



    <?php ActiveForm::end(); ?>

</div>
