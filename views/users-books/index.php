<?php

use app\models\UsersBooks;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\UsersBooksSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Users Books';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="users-books-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Users Books', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'user_id', 

            // [ 
            //     'attribute' => 'user_id',
            //     'value' => function($data){
            //         return $data->user->fullName;
            //     }
            // ],
            //'library_book_id',
            [
                'attribute' => 'library_book_id',
                'value' => function($data){
                    return $data->libraryBook->name;
                }
            ],
            // 'when_taken',
            [
                'attribute' => 'when_taken',
                'value' => function($data){
                    $whenTaken = $data->when_taken;
                    $whenTakenDateObj = new \DateTime($whenTaken);
                    //var_dump($whenTakenDateObj);
                    return $whenTakenDateObj->format('d F Y');
                }
            ],
            [
                'attribute' => 'duration',
                'value' => function($data){
                    $duration = $data->duration;
                    return $duration . " days";
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, UsersBooks $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id' => $model->id]);
                 }
            ],
        ],
    ]); ?>


</div>
