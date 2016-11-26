<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\BadIfno */

$this->title = 'Create Bad Ifno';
$this->params['breadcrumbs'][] = ['label' => 'Bad Ifnos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="bad-ifno-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
