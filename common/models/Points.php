<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "points".
 *
 * @property int $id
 * @property string $point
 */
class Points extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'points';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['point'], 'required'],
            [['point'], 'string', 'max' => 11],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'point' => 'Point',
        ];
    }
}
