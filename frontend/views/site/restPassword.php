<?php
use yii\widgets\ActiveForm;
use yii\helpers\Html;
?>
<?php $form=ActiveForm::begin(['id' => 'form-signup'])?>
    <?= $form->field($model, 'password')->passwordInput() ?>
    <?= $form->field($model, 'repassword')->passwordInput() ?>
    <?= Html::submitButton('重置',['class' => 'btn btn-primary', 'name' => 'signup-button'])?>
<?php ActiveForm::end()?>
