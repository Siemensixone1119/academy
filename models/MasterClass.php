<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii\db\Expression;

class MasterClass extends ActiveRecord
{
  public static function tableName()
  {
    return '{{%master_class}}';
  }

  public function behaviors()
  {
    return [
      [
        'class' => TimestampBehavior::class,
        'value' => time(),
      ],
    ];
  }

  public function rules()
  {
    return [
      [['title', 'starts_at'], 'required'],
      [['description', 'location'], 'string'],
      [['age_from', 'age_to', 'duration_min', 'price', 'seats', 'sort'], 'integer'],
      [['is_published'], 'boolean'],
      [['title'], 'string', 'max' => 255],
      [['starts_at'], 'safe'],
    ];
  }

  public function attributeLabels()
  {
    return [
      'title' => 'Название',
      'description' => 'Описание',
      'age_from' => 'Возраст от',
      'age_to' => 'Возраст до',
      'starts_at' => 'Дата и время',
      'duration_min' => 'Длительность (мин)',
      'price' => 'Цена (руб.)',
      'seats' => 'Мест',
      'location' => 'Место проведения',
      'is_published' => 'Опубликовано',
      'sort' => 'Сортировка',
    ];
  }
}
