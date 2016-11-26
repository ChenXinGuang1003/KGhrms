<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Posts;
/* @var $this yii\web\View */
/* @var $model common\models\PostKey */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="post-key-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($models[0], 'post_id')->dropDownList(ArrayHelper::map(Posts::find()->where(['is_key'=>'1','flag'=>'1'])->asArray()->all(),'post_id','post_name')) ?>
    <?php foreach($models as $model):?>
        <?= $form->field($model, 'key_no')->textInput(['maxlength' => true]) ?>
    <?php endforeach;?>
    <div class="form-group"  style="margin-top: 50px;" id="enter">
        <?= Html::submitButton($model->isNewRecord ? '保存' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('js_postkey')?>
    $(document).on('click','#add',function(){
        var cardNoBox = $("#w0 .field-postkey-key_no").eq(0).clone();
        cardNoBox.find('input').val('');
        $("#enter").before(cardNoBox);
    });
<?php $this->endBlock()?>
<?php $this->registerJs($this->blocks['js_postkey'], \yii\web\View::POS_END); ?>