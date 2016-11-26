<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Posts;
$this->title = '关键岗位在岗人员信息--更新';
?>
<div class="post-key-update">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="post-key-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'post_id')->dropDownList(ArrayHelper::map(Posts::find()->where(['is_key'=>'1','flag'=>'1'])->asArray()->all(),'post_id','post_name')) ?>
        <?= $form->field($model, 'key_no')->textInput(['maxlength' => true]) ?>
        <div class="form-group"  style="margin-top: 50px;" id="enter">
            <?= Html::submitButton( '更新', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
