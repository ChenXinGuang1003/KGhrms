<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\widgets\common\LinkPages;
use backend\assets\AppAsset;
use common\func\FilterFunc;
$this->title = '储备人员概览';
$this->params['breadcrumbs'][] = $this-> title;

AppAsset::register($this);
//只在该视图中使用非全局的
AppAsset::addScript($this,'@web/static/js/table_base.js');
AppAsset::addCss($this,'@web/static/css/site.css');

?>
<div class="auth-item-model-index">

    <div class ="search-container" >
        <?=Html::a("创建 <i class='icon-plus'></i>" , ['create' ], ['class' => 'btn btn-success green']) ?>
        <form action ="" class="form-search pull-right" >
            <div class ="input-append" >
                <select name ="type" class="search-option">
                    <option value ="post_id">岗位ID</option>
                </select >
                <input type="text" name ="value">
                <button class ="btn green btn-success " type= "submit">搜索</button >
            </div >
        </form >
    </div >

    <div class="summary">

        <?=Yii::t('common' , '{start}-{end} a total of {total}',['start' => $data[ 'start'], 'end'=> $data['end'],'total'=> $data['count' ]])?> </div >

    <table class ="table table-striped table-bordered table_base">
        <thead >
        <tr >
            <th >岗位编号</th >
            <th >岗位名称</th >
            <th >储备人员 </th >
            <th >操作 </th >
        </tr >
        </thead >
        <tbody >
        <?php if ( empty($data[ 'data'])): ?>
            <tr ><td colspan ="20"><?=Yii::t('common' ,'Not find data') ?> </td ></tr >
        <?php else: ?>
            <?php $i = $data['start'];?>
            <?php foreach ( $data['data'] as $list):?>
                <tr data-key ="<?=$list[ 'id'] ?>" >
                    <td ><?= Html::encode($list[ 'post_id']) ?></ td>
                    <td ><?= Html::encode(FilterFunc::transPost($list[ 'post_id'])) ?></ td>
                    <td ><?= Html::encode(FilterFunc::transCardNo($list[ 'reserve_no'])) ?></ td>
                    <td >
                        <a href= "<?= Url::to([ 'update', 'id'=>$list[ 'id']]); ?>" >编辑 </a >
                        <a class ="del" href= "javascript:;">删除</a >
                    </td >
                </tr >
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody >
    </table >
    <?=LinkPages:: widget(['pagination' => $pages]);?>
    <input type ="hidden" name="delUrl" value= "<?= Url::to([ 'delete']) ?>" >
</div>