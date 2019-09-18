<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "acomodaciones".
 *
 * @property int $id_acomodacion
 * @property string $acomodacion
 * @property string $estado
 *
 * @property TipoHabitaciones[] $tipoHabitaciones
 */
class Acomodaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'acomodaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['acomodacion'], 'required'],
            [['acomodacion'], 'string', 'max' => 45],
            [['estado'], 'string', 'max' => 8],
            [['acomodacion'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_acomodacion' => 'Id Acomodacion',
            'acomodacion' => 'Acomodacion',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoHabitaciones()
    {
        return $this->hasMany(TipoHabitaciones::className(), ['id_acomodacion' => 'id_acomodacion']);
    }
}
