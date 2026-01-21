<?php

namespace app\models;

use yii\db\ActiveRecord;

/**
 * @property int $id
 * @property string $parent_name
 * @property int $child_age
 * @property string $parent_phone
 * @property string $status
 * @property int $created_at
 */
class Request extends ActiveRecord
{
  public const STATUS_NEW = 'new';
  public const STATUS_IN_PROGRESS = 'in_progress';
  public const STATUS_DONE = 'done';

  public static function tableName(): string
  {
    return '{{%requests}}';
  }

  public function rules(): array
  {
    return [
      [['parent_name', 'child_age', 'parent_phone'], 'required'],
      [['parent_name', 'parent_phone'], 'string', 'max' => 255],
      [['child_age'], 'integer', 'min' => 1, 'max' => 120],

      [['status'], 'string', 'max' => 32],
      [['status'], 'default', 'value' => self::STATUS_NEW],
      [['status'], 'in', 'range' => [
        self::STATUS_NEW,
        self::STATUS_IN_PROGRESS,
        self::STATUS_DONE,
      ]],

      [['created_at'], 'integer'],
      // чтобы при создании заявки created_at ставился автоматически:
      [['created_at'], 'default', 'value' => function () {
        return time();
      }],
    ];
  }

  public function attributeLabels(): array
  {
    return [
      'id' => 'ID',
      'parent_name' => 'Имя родителя',
      'child_age' => 'Возраст ребёнка',
      'parent_phone' => 'Телефон родителя',
      'status' => 'Статус',
      'created_at' => 'Создано',
    ];
  }

  public static function statusLabels(): array
  {
    return [
      self::STATUS_NEW => 'Новая',
      self::STATUS_IN_PROGRESS => 'В работе',
      self::STATUS_DONE => 'Закрыта',
    ];
  }

  public function getStatusLabel(): string
  {
    return self::statusLabels()[$this->status] ?? $this->status;
  }
}
