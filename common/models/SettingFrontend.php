<?php

namespace common\models;

/**
 * This is the model class for table "{{%settings_frontend}}".
 * @property int $id
 * @property string $key
 * @property mixed $value
 * @property string $description
 */
class SettingFrontend extends BaseModel
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%settings_frontend}}';
    }

    /**
     * {@inheritdoc}
     * @return queries\SettingFrontend the active query used by this AR class.
     */
    public static function find()
    {
        return new queries\SettingFrontend(static::class);
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
