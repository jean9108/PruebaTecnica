<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignacion_habitaciones".
 *
 * @property int $id_asignacion
 * @property int $id_tipo
 * @property int $id_hotel
 * @property string $estado
 *
 * @property Hoteles $hotel
 * @property TipoHabitaciones $tipo
 */
class AsignacionHabitaciones extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'asignacion_habitaciones';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tipo', 'id_hotel'], 'required'],
            [['id_tipo', 'id_hotel'], 'integer'],
            [['estado'], 'string', 'max' => 8],
            [['id_hotel'], 'exist', 'skipOnError' => true, 'targetClass' => Hoteles::className(), 'targetAttribute' => ['id_hotel' => 'id_hotel']],
            [['id_tipo'], 'exist', 'skipOnError' => true, 'targetClass' => TipoHabitaciones::className(), 'targetAttribute' => ['id_tipo' => 'id_tipo']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_asignacion' => 'Id Asignacion',
            'id_tipo' => 'Id Tipo',
            'id_hotel' => 'Id Hotel',
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getHotel()
    {
        return $this->hasOne(Hoteles::className(), ['id_hotel' => 'id_hotel']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(TipoHabitaciones::className(), ['id_tipo' => 'id_tipo']);
    }
}
