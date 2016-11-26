<?php

/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Url;
use yii\helpers\Html;
use backend\assets\AppAsset;
use backend\assets\HackAsset;

AppAsset::register($this);
HackAsset::register($this);
?>
<?php //$navList = Yii::$app->session->get('navList');var_dump($navList);die()?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title>宽广集团人力信息资源库</title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>
<!-- start: Header -->
<div class="navbar">
    <div class="navbar-inner">
        <div class="container-fluid">
            <a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <a id="main-menu-toggle" class="hidden-phone open"><i class="icon-reorder"></i></a>
            <div class="row-fluid">
                <a class="brand span2" href="index.html" style="padding-bottom: 0 !important;"><span>宽广集团岗位资源管理系统</span></a>
            </div>
            <!-- start: Header Menu -->
            <div class="nav-no-collapse header-nav">
                <ul class="nav pull-right">
                    <!-- start: User Dropdown -->
                    <li class="dropdown">
                        <a class="btn account dropdown-toggle" data-toggle="dropdown" href="#">
                            <div class="avatar"><img src="<?= Url::to('@web/static/img/avatar.png')?>" alt="Avatar" /></div>
                            <div class="user">
                                <span class="hello">Welcome!</span>
                                <span class="name"><?= Yii::$app->user->identity->username?></span>
                            </div>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="dropdown-menu-title"></li>
                            <li><a href="<?= Url::to(['admin/rest-password'])?>"><i class="icon-cog"></i> 修改密码</a></li>
                            <li><a href="<?= Url::toRoute(['site/logout'])?>" data-method="post" ><i class="icon-off"></i> 注销</a></li>
                        </ul>
                    </li>
                    <!-- end: User Dropdown -->
                </ul>
            </div>
            <!-- end: Header Menu -->

        </div>
    </div>
</div>
<!-- start: Header -->
<div class="container-fluid-full">
    <div class="row-fluid">
        <!-- start: Main Menu -->
        <div id="sidebar-left" class="span2">
            <div class="nav-collapse sidebar-nav">
                <ul class="nav nav-tabs nav-stacked main-menu">
                    <?php $navList = Yii::$app->session->get('navList');?>
                    <?php if(!$navList):?>

                    <?php endif;?>
                    <?php
                        if($navList):
                        foreach($navList as $nav):
                    ?>
                    <li>
                        <a class="dropmenu" href="#">
                            <i class="<?= $nav['nav_icon']; ?>"></i>
                            <span class="hidden-tablet"> <?= $nav['nav_name'];?></span>
                            <i class="icon-angle-right" style="margin-left: 15px;"></i>
                        </a>
                        <ul>
                            <?php foreach($nav['sub'] as $nav_item): ?>
                            <li>
                                <a class="submenu" href="<?= Url::to([$nav_item['nav_url']]) ; ?>">
                                    <i class="<?= $nav_item['nav_icon']; ?>"></i>
                                    <span class="hidden-tablet"> <?= $nav_item['nav_name'];?></span>
                                </a>
                            </li>
                            <?php endforeach; ?>
                        </ul>
                    </li>
                    <?php
                        endforeach;
                        endif;
                    ?>
                </ul>
            </div>
        </div>
        <!-- end: Main Menu -->

        <!-- start: Content -->
        <div id="content" class="span10" style="min-height: 558px;">
            <?= $content ?>
        </div>
    </div>
</div>

<div class="clearfix"></div>
<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; 宽广集团 <?= date('Y') ?></p>
        <p class="pull-right">宽广集团 信息中心</p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
