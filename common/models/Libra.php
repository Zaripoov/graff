<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "libra".
 *
 * @property int $id
 * @property int $start_point
 * @property int $end_point
 * @property int $libra
 */
class Libra extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'libra';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['start_point', 'end_point', 'libra'], 'required'],
            [['start_point', 'end_point', 'libra'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'start_point' => 'Start Point',
            'end_point' => 'End Point',
            'libra' => 'Libra',
        ];
    }

    public function getStart(){
        return $this->hasMany(Points::className(), ['id' => 'start_point']);
    }
}
