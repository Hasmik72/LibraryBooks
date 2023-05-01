<?php


/** @var yii\web\View $this */

use yii\helpers\Html;

$this->registerJsFile('@web/js/script.js', ['position' => \yii\web\View::POS_END,'depends' => [\yii\web\JqueryAsset::className()]]);
?>

<label>
    <?= Html::checkbox('select_all', false, ['class' => 'select-all']) ?>
    Select All
</label>

<br>
<?php foreach ($books as $book): ?>
    <label>
        <?= Html::checkbox('book[]', false, ['value' => $book->id, 'class' => 'book-checkbox']) ?>
        <?= $book->name ?>
    </label><br />
<?php endforeach; ?>



