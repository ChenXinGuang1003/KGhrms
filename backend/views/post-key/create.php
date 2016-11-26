<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Posts;



$this->title = '关键岗位在岗人员信息--创建';
?>
<div class="post-key-create">

    <h3><?= Html::encode($this->title) ?></h3>

    <div class="post-key-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($models[0], 'post_id')->dropDownList(ArrayHelper::map(Posts::find()->where(['is_key'=>'1','flag'=>'1'])->asArray()->all(),'post_id','post_name')) ?>
        <?php foreach($models as $model):?>
            <?= $form->field($model, 'key_no',[
                'template'=>'<div>{label}{input}
                        <a class="btn btn-danger" href="javascript:void(0)" style="margin: -10px 5px 0 20px" id="del"><i class="icon-trash"></i></a>
                        <a class="btn btn-info" href="javascript:void(0)"  style="margin: -10px 10px 0 5px;" id="add"><i class="icon-plus"></i></a>{error}</div>'
            ])->textInput(['maxlength' => true,'name'=>'PostKey[key_no][]']) ?>
        <?php endforeach;?>
        <div class="form-group"  style="margin-top: 50px;" id="enter">
            <?= Html::submitButton( '保存', ['class' =>'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

    <?php $this->beginBlock('js_postkey')?>
    $(document).on('click','#add',function(){
        var cardNoBox = $("#w0 .field-postkey-key_no").eq(0).clone();
        cardNoBox.find('input').val('');
        $("#enter").before(cardNoBox);
    });
    $(document).on('click','#del',function(){
        var cardNoBox = $(this).parent().parent().remove();
    });
    <?php $this->endBlock()?>
    <?php $this->registerJs($this->blocks['js_postkey'], \yii\web\View::POS_END); ?>

</div>
