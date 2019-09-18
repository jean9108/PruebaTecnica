<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tipo_habitaciones".
 *
 * @property int $id_tipo
 * @property int $id_habitacion
 * @property int $id_acomodacion
 * @property string $estado
 *
 * @property AsignacionHabitaciones[] $asignacionHabitaciones
 * @property Acomodaciones $acomodacion
 * @property Habitaciones $habitacion
 */
class TipoHabitaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tipo_habitaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_habitacion', 'id_acomodacion'], 'default', 'value' => null],
            [['id_habitacion', 'id_acomodacion'], 'integer'],
            [['estado'], 'string', 'max' => 8],
            [['id_acomodacion'], 'exist', 'skipOnError' => true, 'targetClass' => Acomodaciones::className(), 'targetAttribute' => ['id_acomodacion' => 'id_acomodacion']],
            [['id_habitacion'], 'exist', 'skipOnError' => true, 'targetClass' => Habitaciones::className(), 'targetAttribute' => ['id_habitacion' => 'id_habitacion']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_tipo' => 'Id Tipo',
            'id_habitacion' => 'Id Habitacion',
            'id_acomodacion' => 'Id Acomodacion',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAsignacionHabitaciones()
    {
        return $this->hasMany(AsignacionHabitaciones::className(), ['id_tipo' => 'id_tipo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAcomodacion()
    {
        return $this->hasOne(Acomodaciones::className(), ['id_acomodacion' => 'id_acomodacion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHabitacion()
    {
        return $this->hasOne(Habitaciones::className(), ['id_habitacion' => 'id_habitacion']);
    }
}
