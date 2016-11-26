<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Posts */


?>
<div class="posts-create">

    <h3>岗位信息--新建</h3>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
