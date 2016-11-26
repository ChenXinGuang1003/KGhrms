<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use common\models\Posts;
use yii\widgets\Pjax;
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <?= $form->field($model, 'username')->textInput() ?>

        <?= $form->field($model, 'role')->dropDownList(['0005'=>'总部人资','0006'=>'门店人资'],['prompt'=>'请选择']) ?>

        <?= $form->field($model, 'person_number')->textInput() ?>

        <?php if(!$update):?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'repassword')->passwordInput() ?>
        <?php endif;?>


        <div class="form-group">
            <?= Html::submitButton('添加', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>

