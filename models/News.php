<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

/**
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $is_published
 * @property int|null $published_at
 * @property int $created_at
 * @property int $updated_at
 * @property string|null $image
 */
class News extends ActiveRecord
{
  public static function tableName(): string
  {
    return '{{%news}}';
  }

  public function behaviors(): array
  {
    return [
      TimestampBehavior::class, // сам заполнит created_at/updated_at (unix time)
    ];
  }

  public function rules(): array
  {
    return [
      [['title', 'content'], 'required'],
      [['content'], 'string'],
      [['title', 'image'], 'string', 'max' => 255],

      [['is_published'], 'integer'],
      [['is_published'], 'default', 'value' => 0],
      [['is_published'], 'in', 'range' => [0, 1]],

      [['published_at', 'created_at', 'updated_at'], 'integer'],
      [['published_at'], 'default', 'value' => null],
    ];
  }

  public function attributeLabels(): array
  {
    return [
      'id' => 'ID',
      'title' => 'Заголовок',
      'content' => 'Текст',
      'is_published' => 'Опубликовано',
      'published_at' => 'Дата публикации',
      'image' => 'Картинка',
      'created_at' => 'Создано',
      'updated_at' => 'Обновлено',
    ];
  }
}
