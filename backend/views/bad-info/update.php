<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\BadIfno */

$this->title = 'Update Bad Ifno: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Bad Ifnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="bad-ifno-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
