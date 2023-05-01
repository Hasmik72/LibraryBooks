<?php

use app\models\LibraryBooks;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\LibraryBooksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Library Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="library-books-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Library Books', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
           // 'library_id',
            [
                'attribute' => 'library_id',
                'value' => function($data){
                    return $data->library->name;
                }
            ],
            'name',
            'description',
            'creator_id',
            //'created_date',
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, LibraryBooks $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
