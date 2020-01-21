<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NewsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'News';
$this->params['breadcrumbs'][] = $this->title;
\antkaz\vue\VueAsset::register($this);

?>


<div class="news-index">

  <h1><?= Html::encode($this->title) ?></h1>

  <?php \yii\widgets\Pjax::begin(['id' => 'notes']); ?>

  <p>
      <?= Html::a('Create News', ['/news/create'], ['class' => 'btn btn-success']) ?>
  </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
        [
          'class' => 'yii\grid\SerialColumn'
        ],

        'id',
        'title',
        'author',
//        'urlToImage:ntext',
        'publishedAt',
          //'content:ntext',

        [
          'class' => 'yii\grid\DataColumn',
          'attribute' => 'urlToImage',
          'format' => 'image',
          'label' => 'Image',
          'contentOptions' => [
            "style" => [
              "width" => "400px"
            ]
          ]
        ],
        [
          'class' => 'yii\grid\ActionColumn',
          'header' => 'Действия',
          'template' => '{view} {update} {delete}',
          'buttons' => [
            'update' => function ($url, $dataProvider, $key) {
                return Html::a(Html::tag('i', '', ['class'=> 'fa fa-edit']), ['news/update', 'id' => $dataProvider->id], [
                  'id' => $dataProvider->id,
                  'value' => Url::to(['/news/update', 'id' => $dataProvider->id]),
                  'class' => 'update-news',
                  //'data-pjax' => '0',
                ]);
            },
          ],
        ],
      ],
      'tableOptions' => [
        'class' => 'table table-striped table-bordered news-table',
      ],
      'layout' => "{items}\n{summary}\n{pager}",

    ]); ?>
    <?php if (@isset($model)): ?>
        <?= $this->render('_form',[
          'model' => $model,
        ]) ?>
    <?php endif; ?>



  <?php \yii\widgets\Pjax::end(); ?>
</div>