<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Posts;
?>
<div class="reserve-update">

    <h3>关键岗位储备人员信息--更新</h3>

    <div class="reserve-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'post_id')
            ->dropDownList(
                ArrayHelper::map(Posts::find()->where(['is_key'=>'1','flag'=>'1'])->asArray()->all(),'post_id','post_name')) ?>

        <?= $form->field($model, 'reserve_no')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('更新', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
