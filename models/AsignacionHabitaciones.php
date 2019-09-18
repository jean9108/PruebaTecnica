<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignacion_habitaciones".
 *
 * @property int $id_asignacion
 * @property int $id_tipo
 * @property string $estado
 *
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
            [['id_tipo'], 'required'],
            [['id_tipo'], 'default', 'value' => null],
            [['id_tipo'], 'integer'],
            [['estado'], 'string', 'max' => 8],
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
            'estado' => 'Estado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipo()
    {
        return $this->hasOne(TipoHabitaciones::className(), ['id_tipo' => 'id_tipo']);
    }
}
