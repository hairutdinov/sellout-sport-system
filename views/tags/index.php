<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\TagSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Теги';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="tags-index">

  <h1><?= Html::encode($this->title) ?></h1>


    <?php Pjax::begin(); ?>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
      'dataProvider' => $dataProvider,
      'filterModel' => $searchModel,
      'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

          //'id',
          //'news_id',
        'name',
        'number_of_repetitions',

        /*[
          'class' => 'yii\grid\DataColumn',
          'attribute' => 'count_news_with_tag',
          'format' => 'text',
          'label' => 'Количество новостей с тегом',
        ],*/
        [
          'class' => 'yii\grid\ActionColumn',
          'header' => 'Дополнительная информация',
          'template' => '',
          'buttons' => [
              /*'update' => function ($url, $dataProvider, $key) {
                  return Html::a(Html::tag('i', '', ['class' => 'fa fa-edit']), ['news/update', 'id' => $dataProvider->id], [
                    'id' => $dataProvider->id,
                    'value' => Url::to(['/news/update', 'id' => $dataProvider->id]),
                    'class' => 'update-news',
                      //'data-pjax' => '0',
                  ]);
              },*/
          ],
        ],

      ],

      'layout' => "{items}\n{summary}\n{pager}",
    ]); ?>

    <?php Pjax::end(); ?>

</div>
