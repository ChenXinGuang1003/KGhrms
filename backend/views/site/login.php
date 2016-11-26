<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
$this->title = '登陆';
$this->params['breadcrumbs'][] = $this->title;
?>

<?php $form = ActiveForm::begin([
    'id' => 'loginform',
    'options'=>['class' => 'form-vertical']
]); ?>
<div class="control-group normal_text"> <h3>宽广集团关键岗位管理系统后台</h3></div>
<?= $form->field($model, 'username',[
    'inputOptions'=>['placeholder'=>'请输入用户名称'],
    'inputTemplate'=>'<div class="control-group" ><div class="controls"><div class="main_input_box"><span class="add-on bg_lg"><i class="icon-user"></i></span>{input}</div></div></div>'
])->textInput(['autofocus' => true])->label(false) ?>

<?= $form->field($model, 'password',[
    'inputOptions'=>['placeholder'=>'请输入用户密码'],
    'inputTemplate'=>'<div class="control-group" ><div class="controls"><div class="main_input_box"><span class="add-on bg_ly"><i class="icon-lock"></i></span>{input}</div></div></div>'
])->passwordInput()->label(false) ?>

<?= $form->field($model, 'rememberMe')->checkbox()->label('记住我') ?>

<div class="form-actions">
    <span class="pull-left"><a href="#" class="flip-link btn btn-info" id="to-recover">忘记密码?</a></span>
    <?= Html::submitButton('登录', ['class' => 'pull-right btn btn-success', 'name' => 'login-button']) ?>
</div>

<?php ActiveForm::end(); ?>

