<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2016/8/31
 * Time: 11:08
 */
use yii\helpers\Url;
use common\func\FilterFunc;
?>
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header">
            <h2><i class="icon-user"></i>岗位人员列表</h2>
        </div>
        <div class="box-content">
            <?php foreach($key_persons as $key):?>
            <a class="quick-button span2" href="<?= Url::to([ 'view', 'id'=>$key->id,'post'=>$post]); ?>">
                <i class="icon-group"></i>
                <p><?php echo $key->name?></p>
                <p><?php echo FilterFunc::transLevel($key->level)?></p>
            </a>
            <?php endforeach;?>
            <div class="clearfix"></div>
        </div>
    </div><!--/span-->

</div>
