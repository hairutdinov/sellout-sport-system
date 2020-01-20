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


        $news = new NewsApi("https://newsapi.org/v2/top-headlines", "83f517558ad24c76981a9c46b11ba2f6");
        $news->setParameter("country", "us");
        $news->setParameter("pageSize", "100");
        $news->get();

        $tags = new Tags();
        $tags->parse("On Monday, Jan. 20 starting at 6:50 a.m. EST, NASA astronauts Jessica Meir and Christina Koch will step outside of the International Space Station into the vacuum of space together. The duo will wrap up the work of installing new lithium-ion batteries to upgr… [+98 chars]");

        die;
        $news->save();
        die;

        $response = $news->getArticles();

        return $this->render('index', compact('response'));
    }


    public function actionTest()
    {
        $date = "2020-01-20T06:41:00Z";
        $phpDate = new \DateTime($date);
        var_dump($phpDate);
        die;
    }

}
