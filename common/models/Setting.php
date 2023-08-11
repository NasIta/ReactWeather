<?php

namespace common\models;

/**
 * This is the model class for table "{{%settings}}".
 * @property int $id
 * @property string $key
 * @property mixed $value
 * @property string $description
 */
class Setting extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * {@inheritdoc}
     * @return queries\Setting the active query used by this AR class.
     */
    public static function find()
    {
        return new queries\Setting(static::class);
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['key', 'description'], 'trim'],

            [['key'], 'required'],

            [['description'], 'default', 'value' => null],

            [['key'], 'string', 'max' => 255],
            [['description'], 'string'],

            [['value'], 'safe'],

            [['key'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'key' => 'Ключ',
            'value' => 'Значение',
            'description' => 'Описание',
        ];
    }
}
