<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "asignacion_habitaciones".
 *
 * @property int $id_asignacion
 * @property int $id_tipo
 * @property int $id_hotel
 * @property int $cantidad
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
            [['id_tipo', 'id_hotel', 'cantidad'], 'required', 'message' => 'El campo {attribute} es obligatorio'],
            [['id_tipo', 'id_hotel', 'cantidad'], 'integer'],
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
            'cantidad' => 'Cantidad',
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

    /* ============================================================
      ======================== Validaciones =======================
     ============================================================ */
     //1. Valida si la habitación y la Acomodación ya fueron asignadas al hotel
    public function validacionHabitacion(){
        $message = '';

        $habitacion = $this->find()
            ->where('id_tipo = :id_tipo')
            ->andWhere('id_hotel = :id_hotel')
            ->addParams(['id_tipo' => $this->id_tipo,
                'id_hotel' => $this->id_hotel
            ])
            ->count();
        
        if($habitacion > 0):
            $message = 'Ya se encuentra registrada la habitación';
        endif;  
        
        return $message;
    }

    //2. Valida si la cantidad de habitaciones no supere el tope del hotel
    public function validarCantidadHabitacion(){
        $message  = '';

        $habitaciones_hotel = $this->find()
            ->where('id_hotel = :id_hotel')
            ->andWhere('estado = :estado')
            ->addParams([
                'id_hotel' => $this->id_hotel,
                'estado' => 'Activo',
            ])
            ->sum('cantidad');

        $hotel = Hoteles::find()
            ->where('id_hotel = :id_hotel')
            ->addParams(['id_hotel' => $this->id_hotel]) 
            ->one();

        if($habitaciones_hotel >= $hotel->num_habitaciones):
            $message = 'Ya no hay mas habitaciones para asignar';
        endif;

        if($this->cantidad > $hotel->num_habitaciones):
            $message =  'La cantidad seleccionada tiene más habitaciones que el hotel';
        endif;    

        return $message;
    }

    


}
