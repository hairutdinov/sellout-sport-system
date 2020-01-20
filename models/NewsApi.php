<?php

namespace app\models;


use yii\db\Query;
use yii\db\QueryBuilder;
use yii\helpers\Url;

class NewsApi
{
    private $url;
    private $api;
    private $parameters = [];
    private $response;
    private $articles = [];

    /**
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl($url)
    {
        $this->url = $url;
    }

    /**
     * @return string
     */
    public function getApi()
    {
        return $this->api;
    }

    /**
     * @param string $api
     */
    public function setApi($api)
    {
        $this->api = $api;
    }

    /**
     * @param $key string
     * @param $value string
     */
    public function setParameter($key, $value)
    {
        $this->parameters[$key] = $value;
    }


    /**
     * News constructor.
     * @param $url string
     * @param $api string
     */
    public function __construct($url = null, $api = null)
    {

        $this->url = $url;
        $this->api = $api;
    }

    public function get()
    {

        /*$lastNewsPublishedTime = $this->getLastNews()->publishedAt;

        if ($lastNewsPublishedTime) {
            $this->setParameter("from", $lastNewsPublishedTime);
        }*/

        $data = http_build_query($this->parameters);

        $ch = curl_init(Url::to([$this->url], "https") . "?" . $data);

        curl_setopt($ch, CURLOPT_HTTPHEADER, [
          "x-api-key: " . $this->api,
        ]);

        curl_setopt($ch, CURLOPT_HTTPGET, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HEADER, false);

        $this->response = json_decode(curl_exec($ch), true);
        $this->articles = $this->response["articles"];

        curl_close($ch);
    }

    /**
     * @return object
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @return array
     */
    public function getArticles()
    {
        return $this->articles;
    }

    public function save()
    {
        $results = [];
        $inserted = 0;
        $not_inserted = 0;

        foreach ($this->articles as $article) {
            $model = new News();

            $modelData = [
              "title" => $article["title"],
              "author" => $article["author"],
              "url" => $article["url"],
              "urlToImage" => $article["urlToImage"],
              "publishedAt" => $article["publishedAt"],
              "content" => $article["content"],
            ];

            if ($model->load($modelData, '')) {
                if ($model->validate()) {
                    $results[] = [
                      "title" => $article["title"],
                      "publishedAt" => $article["publishedAt"],
                      "status" => $model->save()
                    ];
                    $inserted++;

                    $tags = new Tags();
                    $tags->setNewsId($model->id);
                    $tags->parse($article["content"]);
                    $tags->db_save();

                    continue;
                }
            }

            $results[] = [
              "title" => $article["title"],
              "publishedAt" => $article["publishedAt"],
              "status" => false
            ];
            $not_inserted++;
        }

        return compact('results', 'inserted', 'not_inserted');
    }


    public function getLastNews()
    {
        return News::find()->orderBy("publishedAt DESC")->limit(1)->one();
    }

}