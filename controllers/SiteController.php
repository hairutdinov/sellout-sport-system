<?php

namespace app\controllers;

use app\models\NewsApi;
use app\models\Tags;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
          'error' => [
            'class' => 'yii\web\ErrorAction',
          ],
        ];
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionSave()
    {
        $news = new NewsApi("https://newsapi.org/v2/top-headlines", "83f517558ad24c76981a9c46b11ba2f6");
        $news->setParameter("country", "us");
        $news->setParameter("pageSize", "100");
        $news->get();

        $news->save();
        $response = $news->getArticles();
        return false;
    }


    public function actionTest()
    {
        $date = "2020-01-20T06:41:00Z";
        $phpDate = new \DateTime($date);
        var_dump($phpDate);
        die;
    }

}
