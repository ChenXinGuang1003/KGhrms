<?php

use yii\helpers\Html;
use yii\helpers\Url;
use backend\widgets\common\LinkPages;
use backend\assets\AppAsset;
use common\func\FilterFunc;
$this->title = '一级节点概览';
$this->params['breadcrumbs'][] = $this-> title;

AppAsset::register($this);
//只在该视图中使用非全局的
AppAsset::addScript($this,'@web/static/js/table_base.js');
AppAsset::addCss($this,'@web/static/css/site.css');

?>
<div class="auth-item-model-index">

    <div class ="search-container" >
        <?=Html::a("创建 <i class='icon-plus'></i>" , ['create' ], ['class' => 'btn btn-success green']) ?>
        <form action ="<?= Url::to(['persons/index'])?>" class="form-search pull-right" >
            <div class ="input-append" >
                <select name ="type" class="search-option">
                    <option value ="name">人员名称</option>
                    <option value ="number">人员编号</option>
                    <option value ="level">人员级别</option>
                    <option value ="is_key">是否关键岗</option>
                    <option value ="status">在职状态</option>
                </select >
                <input type="text" name ="value">
                <button class ="btn green btn-success " type= "submit">搜索</button >
            </div >
        </form >
    </div >

    <div class="summary">

        <?=Yii::t('common' , '{start}-{end} a total of {total}',['start' => $data[ 'start'], 'end'=> $data['end'],'total'=> $data['count' ]])?>
    </div >

    <table class ="table table-striped table-bordered table_base">
        <thead >
        <tr >
            <th ># </th >
            <th >姓名 </th >
            <th >员工编号 </th >
            <th >身份证号 </th >
            <th >级别 </th >
            <th >所属部门(一级) </th >
            <th >所属部门(二级) </th >
            <th >所属部门(三级) </th >
            <th >所属部门(四级) </th >
            <th >关键岗位 </th >
            <th >在职状态 </th >
            <th >操作 </th >
        </tr >
        </thead >
        <tbody >
        <?php if ( empty($data[ 'data'])): ?>
            <tr ><td colspan ="20"><?=Yii::t('common' ,'Not find data') ?> </td ></tr >
        <?php else: ?>
            <?php $i = $data['start'];?>
            <?php foreach ( $data['data'] as $list):?>
                <tr data-key ="<?=$list[ 'card_no'] ?>" >
                    <td ><?= $i++?> </td >
                    <td ><?= Html::encode($list[ 'name']) ?></ td>
                    <td ><?= Html::encode($list[ 'number']) ?></ td>
                    <td ><?= Html::encode($list[ 'card_no']) ?></ td>
                    <td ><?= Html::encode($list[ 'level']) ?></ td>
                    <td ><?= FilterFunc::transPost($list[ 'post_1'])?>|<?= Html::encode($list[ 'post_1']) ?></ td>
                    <td ><?= FilterFunc::transPost($list[ 'post_2'])?>|<?= Html::encode($list[ 'post_2']) ?></ td>
                    <td ><?= FilterFunc::transPost($list[ 'post_3'])?>|<?= Html::encode($list[ 'post_3']) ?></ td>
                    <td ><?= FilterFunc::transPost($list[ 'post_4'])?>|<?= Html::encode($list[ 'post_4']) ?></ td>
                    <td ><?= Html::encode($list[ 'is_key']=='1'?'是':'否') ?></ td>
                    <td ><?= Html::encode($list[ 'status']=='1'?'在职':'离职') ?></ td>
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