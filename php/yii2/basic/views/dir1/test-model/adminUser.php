<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title='登录页面';
$this->registerMetaTag(['name' => 'keywords', 'content' => 'yii, framework, php']);
$this->registerLinkTag([
    'rel' => 'stylesheet',
    'href' => 'a.css',
    ]);
/*
$this->params['breadcrumbs'][] = '我的面包';
$this->params['breadcrumbs'][] = '我的面包2';
 */
?>
<h1><?=Html::encode($this->title)?></h1>
The controller ID is: <?= $this->context->id ?>

<?php $form = ActiveForm::begin(); ?>

    <?php echo $form->field($model, 'user_name') ?>
    <?= $form->field($model, 'user_password')->passwordInput() ?>
    <?= $form->field($model, 'user_personid') ?>

    <div class="form-group">
        <?= Html::submitButton('提交', ['class' => 'btn btn-primary']) ?>
    </div>
<?php ActiveForm::end(); ?>

<!--使用一下方式可以做到布局嵌套
-->

<?php if (isset($this->blocks['block1'])): ?>
    <?= $this->blocks['block1'] ?>
<?php else: ?>
    ... default content for block1 ...
<?php endif; ?>
