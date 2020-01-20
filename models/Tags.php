<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tags".
 *
 * @property int $id
 * @property int $news_id
 * @property string|null $name
 * @property int|null $number_of_repetitions
 *
 * @property News $news
 */
class Tags extends \yii\db\ActiveRecord
{
    private $tags = [];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%tags}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id'], 'required'],
            [['news_id', 'number_of_repetitions'], 'integer'],
            [['name'], 'string', 'max' => 100],
            [['news_id'], 'exist', 'skipOnError' => true, 'targetClass' => News::className(), 'targetAttribute' => ['news_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'News ID',
            'name' => 'Name',
            'number_of_repetitions' => 'Number Of Repetitions',
        ];
    }

    /**
     * Gets query for [[News]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    public function parse($string)
    {
        $pattern = '#\b\w+\b.{3}\s\[\+[0-9]+\schars\]#i';
        $string = preg_replace($pattern, "", $string);

        $find_words_pattern = '#\b\w+\b#i';
        preg_match_all($find_words_pattern, $string, $words);

        debug($words);
    }

}
