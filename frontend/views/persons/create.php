<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $person common\models\Persons */
/* @var $works common\models\WorkExperience */

$this->title = 'Create Persons';
$this->params['breadcrumbs'][] = ['label' => 'Persons', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


   <!-- --><?/*= $this->render('_form', [
        'model' => $model,
    ]) */?>
    <?= $this->render('_form', [
        'person' => $person,
        'works' => $works,
    ]) ?>

