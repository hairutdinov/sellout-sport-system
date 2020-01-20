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
    private $news_id;

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
        preg_match_all($find_words_pattern, strtolower($string), $this->tags);

        $this->tags = $this->tags[0];
    }

    /**
     * @param mixed $news_id
     */
    public function setNewsId($news_id)
    {
        $this->news_id = $news_id;
    }

    /**
     * @return array
     */
    public function getTags()
    {
        return $this->tags;
    }

    public function db_save()
    {

        $errors = [];
        $inserted = 0;
        $updated = 0;

        $repeated_tags_arr = array_count_values($this->tags);


        foreach ($repeated_tags_arr as $tag => $num_of_repeats) {
            $tag_in_db = self::find()->where(["news_id" => $this->news_id, "name" => $tag])->limit(1)->one();

            if ($tag_in_db) {
                if ($tag_in_db->updateCounters(["number_of_repetitions" => $num_of_repeats])) {
                    $updated++;
                } else {
                    $errors["update_tag"][] = compact('tag', 'num_of_repeats');
                }
                continue;
            }

            $modelData = [
              "news_id" => $this->news_id,
              "name" => $tag,
              "number_of_repetitions" => $num_of_repeats,
            ];

            $model = new self();

            if ($model->load($modelData, '') && $model->validate()) {
                if ($model->save()) {
                    $inserted++;
                } else {
                    $errors["save_tag"][] = [
                      "tag" => $tag,
                      "num_of_repeats" => $num_of_repeats,
                      "news_id" => $this->news_id,
                    ];
                }
            } else {
                $errors["load_or_validate_tag"][] = [
                  "tag" => $tag,
                  "num_of_repeats" => $num_of_repeats,
                  "news_id" => $this->news_id,
                  "error_message" => $model->errors
                ];
            }


        }

        return compact('inserted', 'updated', 'errors');
    }

}
