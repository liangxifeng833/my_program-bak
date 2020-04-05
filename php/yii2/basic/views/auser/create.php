<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Auser */

$this->title = 'Create Auser';
$this->params['breadcrumbs'][] = ['label' => 'Ausers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auser-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
