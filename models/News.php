<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $author
 * @property string|null $url
 * @property string|null $urlToImage
 * @property string|null $publishedAt
 * @property string|null $content
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['url', 'urlToImage', 'content'], 'string'],
            [['title', 'author'], 'string', 'max' => 255],
            [['publishedAt'], 'string', 'max' => 100],
            [['title', 'publishedAt'], 'unique', 'targetAttribute' => ['title', 'publishedAt']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'author' => 'Author',
            'url' => 'Url',
            'urlToImage' => 'Url To Image',
            'publishedAt' => 'Published At',
            'content' => 'Content',
        ];
    }

    /**
     * Gets query for [[Tags]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function hasTags()
    {
        return $this->hasMany(Tags::className(), ["id_news" => "id"]);
    }
}
