<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\UsersBooks $model */

$this->title = 'Create Users Books';
$this->params['breadcrumbs'][] = ['label' => 'Users Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-books-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
