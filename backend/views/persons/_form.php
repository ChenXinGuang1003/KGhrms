<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use common\models\Posts;
use common\models\Level;
use common\models\Persons;
use yii\widgets\Pjax;
use common\models\Edu;
use common\func\FilterFunc;
?>
<style>
    #personsform-sex label,#personsform-status label{display: inline-block;margin-left: 10px;}
</style>
<div class=" row-fluid">

    <?php $form = ActiveForm::begin(['options'=>['class' => 'form-horizontal','enctype' => 'multipart/form-data'],]); ?>
    <!--  基本信息 s  -->
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
                    <?php if($person->img_url):?>
                        <?= $form->field($person, 'img_url')->textInput(['value'=>$person->img])->label(false)?>
                        <?= $form->field($person, 'img')->fileInput()->label(false) ?>
                    <?php else:?>
                        <?= $form->field($person, 'img')->fileInput()->label(false) ?>
                    <?php endif;?>
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
                    <?= $form->field($person, 'sex')->radioList(['1' => '男', '2' => '女'])->label(false);?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">出生年月</label>
                <div class="controls">
                    <?= $form->field($person, 'birth')->label(false)  ?>
                </div>
            </div>
            <div class="control-group">
                <label class="control-label">最高学历</label>
                <div class="controls">
                    <?= $form->field($person, 'edu')->dropDownList(ArrayHelper::map(Edu::find()->where(['flag'=>'1'])->all(),'edu_id','edu_name'), ['prompt'=>'请选择']) ->label(false) ?>
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
                    <?= $form->field($person, 'status')->radioList(['2'=>'离职','1'=>'在职'])->label(false) ?>
                </div>
            </div>
            <?php $role = Yii::$app->user->identity->role;?>
            <?php if($role=='0006'):?>
                <?php
                $number = Yii::$app->user->identity->person_number;
                $operator = Persons::find()->select(['post_1','post_2','post_3','post_4'])->where('number=:number',[':number'=>$number])->one();
                ?>

                <?php if($operator->post_1 && $operator->post_2 && $operator->post_3 && $operator->post_4):?>
                    <div class="control-group">
                        <label class="control-label">所属一级部门（岗位）</label>
                        <div class="controls">
                            <?=
                            $form->field($person, 'post_1')
                                ->dropDownList(
                                    ArrayHelper::map(Posts::find()->where(['post_id'=>$operator->post_1])->asArray()->all(),'post_id','post_name')
                                )
                                ->label(false)
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">所属二级部门（岗位）</label>
                        <div class="controls">
                            <?=
                            $form->field($person, 'post_2')
                                ->dropDownList(
                                    ArrayHelper::map(Posts::find()->where(['post_id'=>$operator->post_2])->asArray()->all(),'post_id','post_name')
                                )
                                ->label(false)
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">所属三级部门（岗位）</label>
                        <div class="controls">
                            <?=
                            $form->field($person, 'post_3')
                                ->dropDownList(
                                    ArrayHelper::map(Posts::find()->where(['post_id'=>$operator->post_3])->asArray()->all(),'post_id','post_name')
                                )
                                ->label(false)
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">所属四级部门（岗位）</label>
                        <div class="controls">
                            <?=
                            $form->field($person, 'post_4')
                                ->dropDownList(
                                    ArrayHelper::map(Posts::find()->where(['parent_id'=>$operator->post_3])->asArray()->all(),'post_id','post_name'),
                                    ['prompt'=>'请选择']
                                )
                                ->label(false)
                            ?>
                        </div>
                    </div>
                <?php endif;?>
                <?php if($operator->post_1 && $operator->post_2 && $operator->post_3 && !$operator->post_4):?>
                    <div class="control-group">
                        <label class="control-label">所属一级部门（岗位）</label>
                        <div class="controls">
                            <?=
                            $form->field($person, 'post_1')
                                ->dropDownList(
                                    ArrayHelper::map(Posts::find()->where(['post_id'=>$operator->post_1])->asArray()->all(),'post_id','post_name')
                                )
                                ->label(false)
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">所属二级部门（岗位）</label>
                        <div class="controls">
                            <?=
                            $form->field($person, 'post_2')
                                ->dropDownList(
                                    ArrayHelper::map(Posts::find()->where(['post_id'=>$operator->post_2])->asArray()->all(),'post_id','post_name')
                                )
                                ->label(false)
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">所属三级部门（岗位）</label>
                        <div class="controls">
                            <?=
                            $form->field($person, 'post_3')
                                ->dropDownList(
                                    ArrayHelper::map(Posts::find()->where(['parent_id'=>$operator->post_2])->asArray()->all(),'post_id','post_name'),
                                    ['prompt'=>'请选择']
                                )
                                ->label(false)
                            ?>
                        </div>
                    </div>
                <?php endif;?>
                <?php if($operator->post_1 && $operator->post_2 && !$operator->post_3 && !$operator->post_4):?>
                    <div class="control-group">
                        <label class="control-label">所属一级部门（岗位）</label>
                        <div class="controls">
                            <?=
                            $form->field($person, 'post_1')
                                ->dropDownList(
                                    ArrayHelper::map(Posts::find()->where(['post_id'=>$operator->post_1])->asArray()->all(),'post_id','post_name')
                                )
                                ->label(false)
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">所属二级部门（岗位）</label>
                        <div class="controls">
                            <?=
                            $form->field($person, 'post_2')
                                ->dropDownList(
                                    ArrayHelper::map(Posts::find()->where(['parent_id'=>$operator->post_1])->asArray()->all(),'post_id','post_name'),
                                    ['prompt'=>'请选择']
                                )
                                ->label(false)
                            ?>
                        </div>
                    </div>
                <?php endif;?>
            <?php else:?>
                <div class="control-group">
                    <label class="control-label">所属部门（一级）</label>
                    <div class="controls">
                        <?=
                        $form->field($person, 'post_1')
                            ->dropDownList(
                                ArrayHelper::map(Posts::find()->where(['parent_id'=>''])->asArray()->all(),'post_id','post_name'),
                                ['prompt'=>'请选择',"onchange"=>"$.pjax.reload({container:'#pjax_post_2', history:false, data:{'post_1':this.value}});return false;"]
                            )
                            ->label(false)
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">所属部门（二级）</label>
                    <div class="controls">
                        <?php Pjax::begin(['id'=>'pjax_post_2']);?>
                        <?php if(Yii::$app->request->get('post_1')):?>
                            <?php $where_post_2 = ['parent_id'=>Yii::$app->request->get('post_1'),'flag'=>'1'];?>
                        <?php else:?>
                            <?php $where_post_2 = ['post_id'=>$person->post_2,'flag'=>'1'];?>
                        <?php endif;?>
                        <?=
                        $form->field($person, 'post_2')
                            ->dropDownList(
                                ArrayHelper::map(
                                    Posts::find()->where($where_post_2)
                                        ->asArray()
                                        ->all(),
                                    'post_id','post_name'
                                ),
                                ['prompt'=>'请选择',"onchange"=>"$.pjax.reload({container:'#pjax_post_3', history:false, data:{'post_2':this.value}});return false;"]
                            )
                            ->label(false)
                        ?>
                        <?php Pjax::end();?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">所属部门（三级）</label>
                    <div class="controls">
                        <?php Pjax::begin(['id'=>'pjax_post_3']);?>
                        <?php if(Yii::$app->request->get('post_2')):?>
                            <?php $where_post_3 = ['parent_id'=>Yii::$app->request->get('post_2'),'flag'=>'1'];?>
                        <?php else:?>
                            <?php $where_post_3 = ['post_id'=>$person->post_3,'flag'=>'1'];?>
                        <?php endif;?>
                        <?=
                        $form->field($person, 'post_3')
                            ->dropDownList(
                                ArrayHelper::map(
                                    Posts::find()
                                        ->where($where_post_3)
                                        ->asArray()
                                        ->all(),
                                    'post_id','post_name'
                                ),
                                ['prompt'=>'请选择',"onchange"=>"$.pjax.reload({container:'#pjax_post_4', history:false, data:{'post_3':this.value}});return false;"]
                            )
                            ->label(false)
                        ?>
                        <?php Pjax::end();?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">所属部门（四级）</label>
                    <div class="controls">
                        <?php Pjax::begin(['id'=>'pjax_post_4']);?>
                        <?php if(Yii::$app->request->get('post_3')):?>
                            <?php $where_post_4 = ['parent_id'=>Yii::$app->request->get('post_3'),'flag'=>'1'];?>
                        <?php else:?>
                            <?php $where_post_4 = ['post_id'=>$person->post_4,'flag'=>'1'];?>
                        <?php endif;?>
                        <?=
                        $form->field($person, 'post_4')
                            ->dropDownList(
                                ArrayHelper::map(
                                    Posts::find()
                                        ->where($where_post_4)
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
            <?php endif;?>



            <div class="control-group">
                <label class="control-label">职务级别</label>
                <div class="controls">
                    <?= $form->field($person, 'level')->dropDownList(ArrayHelper::map(Level::find()->asArray()->all(),'level_id','level_name'), ['prompt'=>'请选择']) ->label(false) ?>
                </div>
            </div>
            <!--<div class="control-group">
                <label class="control-label">是否关键岗</label>
                <div class="controls">
                    <?/*= $form->field($person, 'is_key')->dropDownList(['0'=>'否','1'=>'是']) ->label(false) */?>
                </div>
            </div>
-->
        </div>
    </div>
    <!--  基本信息 e  -->
    <!--  工作经历 s  -->
    <div class="box span12" style="margin:15px 0;">
        <div class="box-header">
            <h2><i class="icon-edit"></i>工作经历</h2>
            <div class="box-icon">
                <a href="javascript:void(0)" class="btn-setting" id="addWork"><i class="icon-plus"></i></a>
                <a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content" id="workBox">

            <?php
            if(count($works)>0):
            foreach($works as $work):
            ?>
            <div class="word-item workItem">
                <?= $form->field($work, 'id')->hiddenInput(['name'=>'work[id][]'])->label(false) ?>
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
            <?php
            endforeach;
            endif;
            ?>

        </div>
    </div>
    <!--  工作经历 e  -->
    <!--  集团工作经历 s  -->
    <div class="box span12" style="margin:15px 0;">
        <div class="box-header">
            <h2><i class="icon-edit"></i>集团工作经历</h2>
            <div class="box-icon">
                <a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content">
            <?php
            if(count($kgworks)>0):
                foreach($kgworks as $kgwork):
                    ?>
                    <div class="word-item badItem">
                        <div class="control-group" style="margin-bottom: 0">
                            <div class="span3">开始日期: <?= FilterFunc::convert($kgwork->begin_time)?></div>
                            <div class="span3">在岗职务: <?= FilterFunc::transLevel($kgwork->level)?></div>
                        </div>
                        <div class="control-group" style="margin-bottom: 0;border-bottom: 1px dotted #eee;">
                            <div class="span12">
                                任职单位：
                                <?= FilterFunc::transPost($kgwork->post_1)?>--
                                <?= FilterFunc::transPost($kgwork->post_2)?>
                                <?php if($kgwork->post_3):?>
                                    --<?= FilterFunc::transPost($kgwork->post_3)?>
                                <?php endif;?>
                                <?php if($kgwork->post_4):?>
                                    --<?= FilterFunc::transPost($kgwork->post_4)?>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>

        </div>
    </div>

    <!--  集团工作经历 e -->

    <div class="box span12" style="margin:15px 0;">
        <div class="box-header">
            <h2><i class="icon-edit"></i>违规记录</h2>
            <div class="box-icon">
                <a href="javascript:void(0)" class="btn-setting" id="addBad"><i class="icon-plus"></i></a>
                <a href="#" class="btn-minimize"><i class="icon-chevron-up"></i></a>
            </div>
        </div>
        <div class="box-content" id="badBox">
            <?php
            if(count($badInfos)>0):
                foreach($badInfos as $bad):
                    ?>

                    <div class="word-item badItem">
                        <?= $form->field($bad, 'id')->hiddenInput(['name'=>'bad[id][]'])->label(false) ?>
                        <div class="control-group">
                            <label class="control-label" for="">日期</label>
                            <div class="controls">
                                <?= $form->field($bad, 'bad_time')->textInput(['name'=>'bad[bad_time][]'])->label(false) ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <label class="control-label" for="">描述</label>
                            <div class="controls">
                                <?= $form->field($bad, 'bad_info')->textarea(['name'=>'bad[bad_info][]','style'=>'width:98%;'])->label(false) ?>
                            </div>
                        </div>
                    </div>
                    <?php
                endforeach;
            endif;
            ?>

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
        workBox.append(workItem)
    });

    $('#addBad').click(function(){
        var badBox = $('#badBox');
        var badItem = $('#badBox .badItem').eq(0).clone();
        badItem.find('input').val('');
        badBox.append(badItem)
    });
<?php $this->endBlock() ?>
<?php $this->registerJs($this->blocks['test'], \yii\web\View::POS_END); ?>
