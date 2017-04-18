<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "bulletins".
 *
 * @property integer $id
 * @property string $title
 * @property string $body
 * @property integer $category
 * @property integer $active
 * @property integer $sticky
 * @property string $created
 */
class Bulletins extends \yii\db\ActiveRecord {

    public $titleLimit = true;
    public $bodyLimit = 200;
    public $readMore = false;

    const CAT_NEWS = '1';

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'bulletins';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['title', 'body', 'category', 'active'], 'required'],
            [['body'], 'string'],
            [['category', 'active', 'sticky'], 'integer'],
            [['created'], 'safe'],
            [['title'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', 'Title'),
            'body' => Yii::t('app', 'Body'),
            'category' => Yii::t('app', 'Category'),
            'active' => Yii::t('app', 'Active'),
            'created' => Yii::t('app', 'Date and time'),
            'sticky' => Yii::t('app', 'Stick the post'),
        ];
    }

    public function getLimtedTitle() {


        if ((strlen($this->title) > $this->titleLimit) === true) {

            return substr($this->title, 0, $this->titleLimit - 3) . '...';
        }
        return $this->title;
    }

    public function getLimtedBody() {


        if ((strlen($this->body) > $this->bodyLimit) === true) {
            $this->readMore = true;
            return substr($this->body, 0, $this->bodyLimit - 14) .
                    '...';
        }
        return $this->body;
    }

    public function getNiceDate() {
        return \Yii::$app->formatter->asDate($this->created, "php:d M Y");  //date("d-m-Y", strtotime($this->created_at));//
    }

    public function getNiceTime() {
        return \Yii::$app->formatter->asDate($this->created, "php:H:m");  //date("d-m-Y", strtotime($this->created_at));//
    }

    public static function Categories() {
        return [self::CAT_NEWS => 'News'];
    }

}
