<?php 
namespace app\controllers;

use Yii;

use yii\web\Controller;

use app\models\Habitaciones;
use app\models\Hoteles;
use app\models\TipoHabitaciones;
use app\models\AsignacionHabitaciones;

use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;


class HabitacionController extends Controller{

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => AccessControl::class,
                'rules' =>[
                    'actions' => [
                        'allow' => true,
                        'actions' =>['index', 'view', 'create','update', 'delete', 'habitacionesdisponibles'],
                        'roles' => ['?','@'],
                    ],
                ],
            ],
        ];
    }

    /* ============================================================
      ================ Trae las habitaciones de la BD ============
     ============================================================ */

    public function actionIndex(){
        $model = Habitaciones::find()
        ->where('estado = :estado')
        ->addParams([':estado' => 'Activo'])
        ->all();

        if(!empty($model)){
            $habitaciones = ArrayHelper::map($model, 'id_habitacion', 'habitacion');
            $data =[
                'status' => 'success',
                'code' => '200',
                'habitaciones' => $habitaciones,
            ];
        }else{
            $data =[
                'status' => 'error',
                'code' => '400',
                'message' => 'No se encontró ninguna habitación',
            ];
        }

        return $data;
    }

    /* ============================================================
       Trae las acomodaciones que tiene la habitación escogida  
     ============================================================ */

    public function actionView($id){
        $model = new Habitaciones;
        $model = $model->find()->where(['id_habitacion' => $id])->one();
        $acomodaciones = $model->acomodaciones;
        if(!empty($acomodaciones)){
            $acomodaciones = ArrayHelper::map($acomodaciones,'id_acomodacion','acomodacion');
            $data =[
                'status' => 'success',
                'code' => '200',
                'habitaciones' => $model,
                'acomodaciones' => $acomodaciones,
            ]; 
        }else{
            $data=[
                'status' => 'error',
                'code' => '400',
                'message' => 'No se encontró ninguna acomodacion para la habitacion '.$model->habitacion, 
            ];
        }

        return $data;
    }

    /*==========================================================================
    =============== Crear Asignacion de habitaciones del hotel ================
    ==========================================================================*/
    public function actionCreate($id){

        $request = Yii::$app->request;
        $datos = json_decode($request->post('json'),true);

        $model = new AsignacionHabitaciones;
        $model->id_hotel = $id;

        if(isset($datos['id_habitacion']) && isset($datos['id_acomodacion'])):
            $tipo = TipoHabitaciones::find()
                ->where('id_habitacion = :id_habitacion')
                ->andWhere('id_acomodacion = :id_acomodacion')
                ->addParams([
                    'id_habitacion' => $datos['id_habitacion'],
                    'id_acomodacion' => $datos['id_acomodacion'],
                ])
                ->one();
            if($tipo != NULL)$datos['id_tipo'] = $tipo->id_tipo;      

        endif;    

        $model->attributes = $datos;

        if($model->validate()){
            $validacion_habitacion = $model->validacionHabitacion();
            $validacion_hotel = $model->validarCantidadHabitacion();

            if($validacion_habitacion != ''){
                $data =[
                    'status' => 'error',
                    'code' => '400',
                    'error' => $validacion_habitacion
                ]; 
            }else if($validacion_hotel !=''){
                $data =[
                    'status' => 'error',
                    'code' => '400',
                    'error' => $validacion_hotel
                ]; 
            }else{
                $model->save();

                $data =[
                    'status' => 'success',
                    'code' => '200',
                    'message' => 'Registro de asignacion completa',
                ]; 
            }
        }else{
            $data =[
                'status' => 'error',
                'code' => '400',
                'errors' => $model->getErrors()
            ]; 
        }

        return $data;
    }
    

    public function actionHabitacionesdisponibles($id){
        $sum = 0;
        $model = AsignacionHabitaciones::find()
            ->where('id_hotel = :id_hotel')
            ->andWhere('estado = :estado')
            ->addParams([
                'id_hotel' => $id,
                'estado' => 'Activo',
            ])
            ->sum('cantidad');

            $hotel = Hoteles::find()
            ->where('id_hotel = :id_hotel')
            ->addParams(['id_hotel' => $id]) 
            ->one();
        
        if($hotel != null){
            $sum = $hotel->num_habitaciones - $model;
            $data =[
                'status' => 'success',
                'code' => '200',
                'cantidad' => $sum,
            ]; 
        }else{
            $data =[
                'status' => 'error',
                'code' => '400',
                'message' => 'No se encuentra el hotel',
            ];
        }

         return $data;
    }

    /*==========================================================================
    ============= Actualización de Asignacion de Habitaciones ==================
    ==========================================================================*/
    public function actionUpdate($id){
        $request = Yii::$app->request;
        $datos = json_decode($request->post('json'),true);

        if(!empty($datos)){ 
            if(isset($datos['id_habitacion']) && isset($datos['id_acomodacion'])):
                $tipo = TipoHabitaciones::find()
                    ->where('id_habitacion = :id_habitacion')
                    ->andWhere('id_acomodacion = :id_acomodacion')
                    ->addParams([
                        'id_habitacion' => $datos['id_habitacion'],
                        'id_acomodacion' => $datos['id_acomodacion'],
                    ])
                    ->one();
                if($tipo != NULL)$datos['id_tipo'] = $tipo->id_tipo;      
    
            endif;    

            $model = AsignacionHabitaciones::findOne($id);
            $model->attributes = $datos;

            if($model->validate() && $model->save()){
                $data =[
                    'status' => 'success',
                    'code' => '200',
                    'message' => 'Registro de asignacion completa',
                ]; 
            }else{
                 $data =[
                    'status' => 'error',
                    'code' => '400',
                    'error' => $model->getErrors(),
                 ];
            }
        }else{
            $data =[
                'status' => 'error',
                'code' => '400',
                'message' => 'No se ha podido actualizar el hotel',
            ]; 
        }
        
        return $data;
    }


    public function actionDelete($id){
        $model = AsignacionHabitaciones::findOne($id);
        $model->estado = 'Inactivo';
        $model->save();

        $data =[
            'status' => 'success',
            'code' => '200',
            'message' => 'La asignacion ha sido eliminado',
        ];

        return $data;
    }

    
    protected function findModel($id)
    {
        if (($model = Habitaciones::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
?>