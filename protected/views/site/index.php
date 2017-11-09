<?php
/* @var $this SiteController */

$this->pageTitle=Yii::app()->name;
?>

<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>


<p>My tasks:</p>
<ul>
	<li><?php echo CHtml::link(CHtml::encode("Task 1 - Google Disk"), array('/googleDisk/index')); ?></li>
	<li><?php echo CHtml::link(CHtml::encode("Task 2 - Pages"), array('/pages')); ?></code></li>
</ul>
