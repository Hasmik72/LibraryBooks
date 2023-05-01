<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\LibraryBooks $model */

$this->title = 'Create Library Books';
$this->params['breadcrumbs'][] = ['label' => 'Library Books', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="library-books-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
