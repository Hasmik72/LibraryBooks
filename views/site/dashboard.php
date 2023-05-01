<?php



use yii\helpers\Html;
use yii\bootstrap5\ActiveForm;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use app\models\UsersBooks;

/** @var yii\web\View $this */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Dashboard';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJsFile('@web/js/script.js', ['position' => \yii\web\View::POS_END,'depends' => [\yii\web\JqueryAsset::className()]]);
?>




<div class="site-dashboard">
    <h1><?= Html::encode($this->title) ?></h1>

    <p> This is the Dashboard page. </p>

    <?php $form = ActiveForm::begin(['action' => ['site/dashboard']]); ?>

    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <?=Html::dropDownList('library', null, $libraryList, ['prompt' => 'Library List', 'id' => 'libId','class'=>'form-control']) ?>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <div id="book-checkboxes"></div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
            <?= Html::submitButton('Save', ['id' => 'my-button', 'class' => 'btn btn-success', 'style' => 'display:none']) ?>
        </div>
    </div>

    <div class="container mt-3">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>User ID</th>
                    <th>Libray Book</th>
                    <th>When Taken</th>
                    <th>Duration</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($userBooks as $userBook): ?>
                    <tr>
                        <td><?= $userBook->id ?></td>
                        <td><?= $userBook->user_id ?></td>
                        <td><?= $userBook->libraryBook->name ?></td>
                        <td><?= $userBook->when_taken ?> </td>
                        <td><?= $userBook->duration ?> days</td>
                    </tr>
                <?php endforeach ?>
            </tbody>
        </table>
    </div>
    
    <?php ActiveForm::end(); ?>










