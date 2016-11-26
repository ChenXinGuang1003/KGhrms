<?php


use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use backend\models\Role;
use yii\helpers\ArrayHelper;
$this->params['breadcrumbs'][] = $this->title;
?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>

        <?= $form->field($model, 'username')->textInput() ?>

        <?= $form->field($model, 'role')->dropDownList(['0002'=>'总裁','0003'=>'副总裁','0004'=>'人力总监']) ?>

        <?php if(!$update):?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'repassword')->passwordInput() ?>
        <?php endif;?>


        <div class="form-group">
            <?= Html::submitButton('添加', ['class' => 'btn btn-primary', 'name' => 'signup-button']) ?>
        </div>

    <?php ActiveForm::end(); ?>

