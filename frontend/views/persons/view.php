<?php
use common\func\FilterFunc;
use yii\helpers\Url;
$cssString = '.discussions ul li .name{left:0;padding:10px 0;background:#f3f4f6;text-indent:1.5em;}';
$cssString .= '.discussions ul li ul li .name{left:0}';
$cssString .= '.discussions ul li .date{padding:10px 20px;}';
$this->registerCss($cssString);
?>

<div class="row-fluid">
    <div class="span12 discussions">
        <ul>
            <li>
                <div class="author">
                    <img src="<?= Url::to('@web'.$model->img_url)?>" alt="<?php echo '员工照片'?>">
                </div>

                <div class="name">姓名:<?= $model->name;?></div>
                <div class="date">职位：<?= FilterFunc::transLevel($model->level);?></div>

                <div class="message">
                    <div class="row-fluid">
                        <div class="span3">性别: <?= FilterFunc::convert($model->sex)=='0'?'女':'男' ?></div>
                        <div class="span3">民族：<?= $model->nation?></div>
                        <div class="span3">出生年月: <?= FilterFunc::convert($model->birth)?></div>
                        <div class="span3">最高学历：<?= FilterFunc::transEdu($model->edu)?></div>
                    </div>
                    <div class="row-fluid">
                        <div class="span3">员工编号：<?= $model->number ?></div>
                        <div class="span3">入职时间：<?= FilterFunc::convert($model->hiredate)?></div>
                        <div class="span3">此关键岗位状态：<?= FilterFunc::transIsKey($post,$model->card_no) ?></div>
                    </div>
                    <div class="row-fluid">
                        <div class="span12">
                            任职单位：
                            <?= FilterFunc::transPost($model->post_1)?>--
                            <?= FilterFunc::transPost($model->post_2)?>
                            <?php if($model->post_3):?>
                                --<?= FilterFunc::transPost($model->post_3)?>
                            <?php endif;?>
                            <?php if($model->post_4):?>
                                --<?= FilterFunc::transPost($model->post_4)?>
                            <?php endif;?>
                        </div>
                    </div>
                </div>

                <ul>
                    <li>
                        <div class="name">工作经历：</div>
                        <?php foreach($works as $work):?>
                        <div class="message">
                            <h5><?= FilterFunc::convert($work->date_begin)?> 至 <?= FilterFunc::convert($work->date_end)?>：</h5>
                            <?= $work->desc?>
                        </div>
                        <?php endforeach;?>
                    </li>
                </ul>
                <?php if($reserve_persons):?>
                <ul class="row-fluid">
                    <li class="box span12">
                        <div class="name">岗位(<?= FilterFunc::transPost($post)?>)储备人员：</div>
                            <div class="box-content" style="margin-top: 3em;">
                                <?php foreach($reserve_persons as $person):?>
                                <a class="quick-button-small span1"href="<?= Url::to(['persons/view','id'=>$person->id,'post'=>$post])?>">
                                    <i class="icon-group"></i>
                                    <p><?= $person->name?></p>
                                </a>
                                <?php endforeach;?>
                                <div class="clearfix"></div>
                            </div>

                    </li>
                </ul>
                <?php endif;?>
            </li>
        </ul>
    </div>
</div>
