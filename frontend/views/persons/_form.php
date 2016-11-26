<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Depart;
use common\models\Post;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<div class=" row-fluid">

    <?php $form = ActiveForm::begin(['options'=>['class' => 'form-horizontal','enctype' => 'multipart/form-data'],]); ?>

    <div class="box span12" style="margin:15px 0;">
        <div class="box-header">
            <h2><i class="icon-edit"></i>基础信息</h2>
            <div class="box-icon">
                <a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <div class="control-group">
                <label class="control-label" for="focusedInput">身份证号</label>
                <div class="controls">
                    <?= $form->field($person, 'card_no')->label(false) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="focusedInput">员工编号</label>
                <div class="controls">
                    <?= $form->field($person, 'number')->label(false) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="focusedInput">员工姓名</label>
                <div class="controls">
                    <?= $form->field($person, 'name')->label(false) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="focusedInput">员工照片</label>
                <div class="controls">
                        <?= $form->field($person, 'img')->fileInput()->label(false) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label" for="selectError3">民族</label>
                <div class="controls">
                    <?= $form->field($person, 'nation')->textInput(['maxlength' => true])->label(false)  ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">性别</label>
                <div class="controls">
                    <?= $form->field($person, 'sex')->radioList([1 => '男', 0 => '女'],[
                        'item' => function($index, $label, $name, $checked, $value) {
                            $return = '<label class="radio inline">';
                            $return .= '<input type="radio" name="' . $name . '" value="' . $value . '">';
                            $return .= '<span>' . ucwords($label) . '</span>';
                            $return .= '</label>';
                            return $return;
                        }
                    ])->label(false);?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">出生年月</label>
                <div class="controls">
                    <?= $form->field($person, 'birth')->label(false)  ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">入职日期</label>
                <div class="controls">
                    <?= $form->field($person, 'hiredate')->label(false)  ?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">在职状态</label>
                <div class="controls">
                    <?= $form->field($person, 'status')->radioList(['0'=>'离职','1'=>'在职','2'=>'储备'],[
                        'item'=>function($index, $label, $name, $checked, $value){
                            $return  =  '<label class="radio inline">';
                            $return .= '<input type="radio" name="'.$name.'" value="'.$value.'">';
                            $return .= '<span>'.ucwords($label).'</span>';
                            $return .= '</label>';
                            return $return;
                        }
                    ])->label(false) ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">所属公司</label>
                <div class="controls">
                    <?=
                        $form->field($person, 'depart')
                            ->dropDownList(
                                ArrayHelper::map(Depart::find()->asArray()->all(),'depart_id','depart_name'),
                                ['prompt'=>'请选择',"onchange"=>"$.pjax.reload({container:'#pjax_post', history:false, data:{'depart':this.value}});"]
                            )
                            ->label(false)
                    ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">所在岗位</label>
                <div class="controls">
                    <?php Pjax::begin(['id'=>'pjax_post']);?>
                    <?=
                        $form->field($person, 'post')
                            ->dropDownList(
                                ArrayHelper::map(
                                    Post::find()
                                        ->where(['depart'=>Yii::$app->request->get('depart'),'flag'=>'1'])
                                        ->asArray()
                                        ->all(),
                                    'post_id','post_name'
                                ),
                                ['prompt'=>'请选择']
                            )
                            ->label(false)
                    ?>
                    <?php Pjax::end();?>
                </div>
            </div>

            <div class="control-group">
                <label class="control-label">最高学历</label>
                <div class="controls">
                    <?= $form->field($person, 'edu')->dropDownList(['1'=>'本科','2'=>'专科','3'=>'中专','4'=>'高中'], ['prompt'=>'请选择']) ->label(false) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="box span12" style="margin:15px 0;">
        <div class="box-header">
            <h2><i class="icon-edit"></i>Form Elements</h2>
            <div class="box-icon">
                <a href="javascript:void(0)" class="btn-setting" id="addWork"><i class="icon-plus"></i></a>
                <a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content" id="workBox">
            <?php foreach($works as $work):?>
            <div class="word-item workItem">
                <div class="control-group">
                    <label class="control-label" for="">公司名称</label>
                    <div class="controls">
                        <?= $form->field($work, 'company')->textInput(['name'=>'work[company][]'])->label(false) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">职位名称</label>
                    <div class="controls">
                        <?= $form->field($work, 'post_name')->textInput(['name'=>'work[post_name][]'])->label(false) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label inline" for="">在职日期</label>
                    <div class="controls">
                        <?= $form->field($work, 'date_begin',['options'=>['class'=>'inline']])->textInput(['name'=>'work[date_begin][]'])->label(false) ?>至
                        <?= $form->field($work, 'date_end',['options'=>['class'=>'inline']])->textInput(['name'=>'work[date_end][]'])->label(false) ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label" for="">岗位描述</label>
                    <div class="controls">
                        <?= $form->field($work, 'desc')->textarea(['name'=>'work[desc][]','style'=>'width:98%;'])->label(false) ?>
                    </div>
                </div>
            </div>
            <?php endforeach;?>
        </div>
    </div>
    <div class="form-group">
        <?= Html::submitButton( '保存', ['class' =>  'btn btn-success','style'=>'min-width:8em;']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php $this->beginBlock('test') ?>
    $('#addWork').click(function(){
        var workBox = $('#workBox');
        var workItem = $('#workBox .workItem').eq(0).clone();
        workItem.find('input').val('');
        console.log(workItem);
        workBox.append(workItem)
    });


<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>
