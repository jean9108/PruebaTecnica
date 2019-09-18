<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "habitaciones".
 *
 * @property int $id_habitacion
 * @property string $habitacion
 * @property string $estado
 *
 * @property TipoHabitaciones[] $tipoHabitaciones
 */
class Habitaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'habitaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['habitacion'], 'required'],
            [['habitacion'], 'string', 'max' => 45],
            [['estado'], 'string', 'max' => 8],
            [['habitacion'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_habitacion' => 'Id Habitacion',
            'habitacion' => 'Habitacion',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoHabitaciones()
    {
        return $this->hasMany(TipoHabitaciones::className(), ['id_habitacion' => 'id_habitacion']);
    }
}
