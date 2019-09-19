<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "hoteles".
 *
 * @property int $id_hotel
 * @property string $nombre
 * @property string $nit
 * @property string $direccion
 * @property int $num_habitaciones
 * @property string $fecha_creacion
 * @property string $fecha_actualizacion
 * @property string $estado
 */
class Hoteles extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'hoteles';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre', 'nit', 'direccion', 'num_habitaciones'], 'required', 'message' => '{attribute} es requerido'],
            [['fecha_creacion'], 'required', 'message' => 'No hay una fecha de creación', 'on' =>['crear_hotel']],
            [['fecha_actualizacion'], 'required', 'message' => 'No hay una fecha de actualizacion', 'on' =>['modificar_hotel']],
            [['num_habitaciones'], 'default', 'value' => null],
            [['num_habitaciones'], 'integer'],
            [['fecha_creacion', 'fecha_actualizacion'], 'safe'],
            [['nombre', 'direccion'], 'string', 'max' => 45],
            [['nit'], 'string', 'max' => 10],
            [['estado'], 'string', 'max' => 8],
            ['nombre', 'validaHotel', 'on' =>['crear_hotel']]
        ];
    }

    public function scenarios(){
        $scenarios = parent::scenarios();
        $scenarios['crear_hotel'] = ['nombre', 'nit','direccion', 'num_habitaciones', 'fecha_creacion'];
        $scenarios['modificar_hotel'] = ['nombre', 'nit','direccion', 'num_habitaciones', 'fecha_actualizacion'];
        return $scenarios;
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id_hotel' => 'Id Hotel',
            'nombre' => 'Nombre',
            'nit' => 'Nit',
            'direccion' => 'Dirección',
            'num_habitaciones' => 'Número de Habitaciones',
            'estado' => 'Estado',
        ];
    }

    /*=============================================================
    ================== Validaciones ===============================
    =============================================================*/

    /*El hotel no se repita por nombre y nit*/
    public function validaHotel($attribute, $params){
        $nombre = $this->nombre;
        $nit = $this->nit;

        $consulta = $this->find()
            ->where('nombre LIKE :nombre')
            ->andWhere('nit LIKE :nit')
            ->addParams([
                ':nombre'=>'%'.$this->nombre.'%',
                ':nit' => $this->nit,
            ])
        ->all();
         
        if(count($consulta) > 0):
            $this->addError($attribute,'El hotel ya existe');
                return true;
        endif;    

       return false;
    }
}
