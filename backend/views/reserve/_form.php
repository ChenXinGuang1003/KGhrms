<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Posts;
use yii\widgets\Pjax;
use common\models\Persons;
/* @var $this yii\web\View */
/* @var $model common\models\Reserve */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="reserve-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'post_id')
        ->dropDownList(
            ArrayHelper::map(Posts::find()->where(['is_key'=>'1','flag'=>'1'])->asArray()->all(),'post_id','post_name')) ?>

    <?= $form->field($model, 'reserve_no')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
