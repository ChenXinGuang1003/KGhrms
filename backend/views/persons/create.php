<?php
$this->title = '创建人员信息';

?>
    <?= $this->render('_form', [
        'person' => $person,
        'works' => $works,
        'badInfos' => $badInfos,
        'kgworks' => $kgworks,
    ]) ?>

